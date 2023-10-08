<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\EventInformation;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import Exception
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with(['user' => function($query){
                $query->select('id','username');
            }, 'template' => function($query){
                $query->select('id','template_name');
            }])->get();

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
            }])->find($id);

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

    public function store(Request $request, $id){
        try{
            $validator = Validator::make($request->all(), [
                'cover_image' => 'max:2048',
                'attachment_name' => 'max:2048',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $coverName = 'default.webp';
            if($request->hasFile('cover_image')){
                $coverName = Str::random(20) . '.webp';
                $webpImageData = Image::make($request->cover_image);
                $webpImageData->encode('webp');
                $webpImageData->resize(200, 250);

                Storage::put('public/assets/cover/' . $coverName, (string) $webpImageData);
            }
    
            $eventInformation = EventInformation::create([
                'bride_name'          => $request->bride_name,
                'groom_name'          => $request->groom_name,
                'bride_father_name'   => $request->bride_father_name,
                'bride_mother_name'   => $request->bride_mother_name,
                'groom_father_name'   => $request->groom_father_name,
                'groom_mother_name'   => $request->groom_mother_name,
                'cover_image'         => $coverName,
                'date_event'          => $request->date_event,
                'guests'              => $request->guests,
                'account_number'      => $request->account_number,
                'account_holder_name' => $request->account_holder_name,
                'quotes'              => $request->quotes,
                'address'             => $request->address,
                'building_name'       => $request->building_name,
                'lat'                 => $request->lat,
                'lng'                 => $request->lng,
            ]);
    
            if ($request->hasFile('attachment_name')) {
                foreach ($request->file('attachment_name') as $attachmentFile) {
                    $attachment = $this->storeAttachment($attachmentFile, $eventInformation->id);
                    $eventInformation->attachment()->save($attachment);
                }
            } else {
                $attachment = $this->storeAttachment(null, $eventInformation->id);
                $eventInformation->attachment()->save($attachment);
            }
    
           $order = new Order([
                'order_code'           => Str::random(15),
                'user_id'              => $request->id,
                'template_id'          => $id,
                'event_information_id' => $eventInformation->id,
                'order_verification'   => '0',
           ]);
           $eventInformation->order()->save($order);
           
           return response()->json([
                    'eventInformation' => $eventInformation->loadMissing('attachment'),
                    'message' => 'Data Undangan Pernikahan berhasil dibuat', 
                    'response' => 200
                ]);

        }catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json([
                'message' => 'Gagal membuat data Undangan Pernikahan: ' . $e->getMessage(), 
                'errors' => $errors,
                'response' => 422,
            ]);
        
        }
    }

    public function destroy($id){
        $destroy = Order::findOrFail($id);
        $destroy->delete();

        return response()->json([
            'message'   => 'Order deleted successfully',
            'status'    => 200
        ]);
    }

}

