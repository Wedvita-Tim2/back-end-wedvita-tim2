<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

class PaymentController extends Controller
{
    public function webhook(Request $request){
        try {
            $auth = base64_encode(env('SERVER_KEY_MIDTRANS'));
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => "Basic $auth"
            ])->get("https://api.sandbox.midtrans.com/v2/$request->order_id/status");
    
            $response = json_decode($response->body());

            $order = Order::where('order_code', $response->order_id)->firstOrFail();

    
            if($order->order_verification === 1){
                return response()->json('Payment has been already processed');
            }
    
            if($response->transaction_status === 'capture' || $response->transaction_status === 'settlement'){
                $order->order_verification = 1;
                $order->invitation_url = '/invitation' .'/'. $order->template_id . '/' . $order->order_code;
            }
            else if($response->transaction_status === 'pending'){
                // Handle pending status
            }
            else if($response->transaction_status === 'deny'){
                // Handle deny status
                $orderController = App::make('App\Http\Controllers\OrderController');
                $orderController->destroy($order->id);
            }
            else if($response->transaction_status === 'cancel'){
                // Handle cancel status
                $orderController = App::make('App\Http\Controllers\OrderController');
                $orderController->destroy($order->id);
            }
            else if($response->transaction_status === 'expire'){
                // Handle expire status
                $orderController = App::make('App\Http\Controllers\OrderController');
                $orderController->destroy($order->id);
            }
    
            $order->save();
    
            return response()->json('Success');
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json('Error: ' . $e->getMessage(), 500);
        }
    }
    
}
