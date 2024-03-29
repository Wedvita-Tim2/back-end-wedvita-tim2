<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventInformationRequest;
use App\Models\Order;
use App\Models\EventInformation;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import Exception
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Resources\OrderResource;
use App\Models\Template;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with(['user' => function($query){
                $query->select('id','username');
            }, 'template' => function($query){
                $query->select('id','template_name');
            }])->orderBy('id','ASC')->get();

            if ($orders->isEmpty()) {
                throw new ModelNotFoundException('No orders found.');
            }

            return response()->json([
                'Data' => $orders,
                'response' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Data not found',
                'response' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred.',
                'response' => 500
            ], 500);
        }
    }

    public function show($id){
        try {
            $orders = Order::with(['user' => function($query){
                $query->select('id','username');
            }, 'template' => function($query){
                $query->select('id','template_name');
            }])->where('user_id', $id)->get();


            return response()->json([
                'Data' => $orders->loadMissing('eventInformation'),
                'response' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Data not found',
                'response' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred.'.$e,
                'response' => 500
            ], 500);
        }
    }

    public function showDetail($order_code){
        try {
            $orders = Order::with(['user' => function($query){
                $query->select('id','username');
            }, 'template' => function($query){
                $query->select('id','template_name');
            }])->where('order_code', $order_code)->with('eventInformation.attachment')->get();
            $resource = OrderResource::collection($orders);


            return response()->json([
                'Data' => $resource,
                'response' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Data not found',
                'response' => 404
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e,
                'response' => 500
            ], 500);
        }
    }

    private function storeAttachment($attachmentFile, $eventInformationId) {
        $fileName = $attachmentFile ? Str::random(20) . '.webp' : 'default.webp';
        $webpImageData = $attachmentFile ? Image::make($attachmentFile) : null;

        if ($webpImageData) {
            $webpImageData->encode('webp');
            $webpImageData->resize(200, 250);
            Storage::put('public/assets/attachments/' . $fileName, (string) $webpImageData);
        }

        return new Attachment([
            'attachment_name' => $fileName,
            'event_information_id' => $eventInformationId,
        ]);
    }

    public function store(EventInformationRequest $request, $id){
        //Save cover_image
        $coverName = 'default.webp';
        if($request->hasFile('cover_image')){
            $coverName = Str::random(20) . '.webp';
            $webpImageData = Image::make($request->cover_image);
            $webpImageData->encode('webp');
            $webpImageData->resize(200, 250);

            Storage::put('public/assets/cover/' . $coverName, (string) $webpImageData);
        }

        //Store Event Information
        $validatedData = $request->validated();
        $validatedData['cover_image'] = $coverName;
        $eventInformation = EventInformation::create($validatedData);
    
        //Looping & Store attachment
        if ($request->hasFile('attachment_name')) {
            foreach ($request->file('attachment_name') as $attachmentFile) {
                $attachment = $this->storeAttachment($attachmentFile, $eventInformation->id);
                $eventInformation->attachment()->save($attachment);
            }
        } else {
            $attachment = $this->storeAttachment(null, $eventInformation->id);
            $eventInformation->attachment()->save($attachment);
        }
    
        //Store Order
        $order_code = Str::random(15);
        $order = new Order([
            'order_code'           => $order_code,
            'user_id'              => $request->id,
            'template_id'          => $id,
            'event_information_id' => $eventInformation->id,
            'order_verification'   => '0',
        ]);

        //Midtrans Operation
        $template = Template::findOrFail($id);
        $user = User::findOrFail($request->id);
        //Params midtrans
        $params = array(
            'transaction_details' => array(
                'order_id' => $order_code,
                'gross_amount' => $template->price
            ),
            'item_details'=> array(array(
                'id' => $eventInformation->id,
                'name' => 'Wedvita '.$eventInformation->groom_name . ' & '. $eventInformation->bride_name,
                'price' => $template->price,
                'quantity' => 1
            )
            ),
            'customer_details' => array(
                'first_name' => $user->username,
                'email' => $user->email
            )
        );

        $auth = base64_encode(env('SERVER_KEY_MIDTRANS'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Basic $auth"
        ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $params);

        $response = json_decode($response->body());

        $order->checkout_url = $response->redirect_url;
        $order->save();
        $eventInformation->order()->save($order);
           
        return response()->json([
                'eventInformation' => $eventInformation->loadMissing('attachment'),
                'message' => 'Wedding Invitation data has been successfully created', 
                'response' => 200
            ]);
    }

    public function destroy($id){
        try{
            $destroy = Order::findOrFail($id);
            $eventInformation = $destroy->eventInformation;

            foreach ($eventInformation->attachment as $attachment) {
                Storage::delete('public/assets/attachments/' . $attachment->attachment_name);
            }
            Storage::delete('public/assets/cover/' . $eventInformation->cover_image);                
            $eventInformation->delete();
            $attachment->delete();
            $destroy->delete();

            return response()->json([
                'message'   => 'Order deleted successfully',
                'status'    => 200
            ]);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'message'   => 'Not Found',
                'status'    => 404,
            ]);
        }
    }

}

