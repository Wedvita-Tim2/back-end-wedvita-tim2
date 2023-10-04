<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\EventInformation;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Import Exception
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request, $id){
        try{
            if($request->hasfile('cover_image')){
                $cover = $request->file('cover_image');
                $coverName = Str::random(10) . "." . $cover->getClientOriginalName();
                $path = public_path('assets/cover');
                File::makeDirectory($path, 0777, true, true);
                $location = 'assets/cover';
                $cover->move($location, $coverName);
            } else {
                $coverName = 'default.png';
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
    
            if ($request->has('attachment_name')) {
                foreach ($request->file('attachment_name') as $attachmentFile) {
                    $fileName = Str::random(10) . '.' . $attachmentFile->getClientOriginalExtension();
                    $path = public_path('assets/attachments');
                    
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0777, true, true);
                    }
                    
                    $location = 'assets/attachments';
                    $attachmentFile->move($location, $fileName);
            
                    $attachment = new Attachment([
                        'attachment_name' => $fileName,
                        'event_information_id' => $eventInformation->id,
                    ]);
            
                    $eventInformation->attachment()->save($attachment);
                }
            } else {
                $fileName = 'default.png';
            
                $attachment = new Attachment([
                    'attachment_name' => $fileName,
                    'event_information_id' => $eventInformation->id,
                ]);
            
                $eventInformation->attachment()->save($attachment);
            }
    
           $order = new Order([
                'order_code'           => Str::random(10),
                'user_id'              => $request->id,
                'template_id'          => $id,
                'event_information_id' => $eventInformation->id,
                'order_verification'   => '0',
           ]);
           $eventInformation->order()->save($order);
           
           return response()->json([
                    'eventInformation' => $eventInformation,
                    'message' => 'Data Undangan Pernikahan berhasil dibuat', 
                    'response' => 200
                ]);
        }catch (\Exception $e) {
            if (isset($coverName) && $coverName !== 'default.png') {
                $coverPath = public_path('assets/cover/' . $coverName);
                if (File::exists($coverPath)) {
                    File::delete($coverPath);
                }
            }
    
            return response()->json([
                'message' => 'Gagal membuat data Undangan Pernikahan: ' . $e->getMessage(), 
                'response' => 500
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

