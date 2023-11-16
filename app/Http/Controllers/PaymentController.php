<?php

namespace App\Http\Controllers;

use App\Mail\PaymentMail;
use App\Mail\PaymentFailMail;
use App\Mail\PaymentSuccessMail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

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
            $user = User::findOrFail($order->user_id);
    
            if($order->order_verification === 1){
                return response()->json('Payment has been already processed');
            }
    
            if($response->transaction_status === 'capture' || $response->transaction_status === 'settlement'){
                $order->order_verification = 1;
                $order->invitation_url = '/invitation' .'/'. $order->template_id . '/' . $order->order_code;
                $content = [
                    'subject' => 'Wedvita Anda Siap Untuk Diakses',
                    'user'=> $user->username,
                    'body' => 'selamat pembayaran berhasil, berikut tautan wedvita anda',
                    'link' => 'localhost:3000/invitation' .'/'. $order->template_id . '/' . $order->order_code
                ];
                
                Mail::to($user->email)->send(new PaymentSuccessMail($content));
            }
            else if($response->transaction_status === 'pending'){
                // Handle pending status
                $expiryTime = $response->expiry_time;
                $content = [
                    'subject' => 'Menunggu Pembayaran',
                    'user'=> $user->username,
                    'body' => 'bayar undangan digital anda sebelum',
                    'expiryTime' => $expiryTime,
                    'price' => $response->gross_amount,
                ];
                
                Mail::to($user->email)->send(new PaymentMail($content));
        
            }
            else if($response->transaction_status === 'deny'){
                // Handle deny status
                $content = [
                    'subject' => 'Order Dihapus',
                    'user'=> $user->username,
                    'body' => 'Admin menolak pembayaran dengan order code '. $response->order_id,
                    'status' =>'deny'
                ];
                
                Mail::to($user->email)->send(new PaymentFailMail($content));
                $orderController = App::make('App\Http\Controllers\OrderController');
                $orderController->destroy($order->id);
            }
            else if($response->transaction_status === 'cancel'){
                // Handle cancel status
                $content = [
                    'subject' => 'Order Dihapus',
                    'user'=> $user->username,
                    'body' => 'Admin membatalkan pembayaran dengan order code '. $response->order_id,
                    'status' =>'cancel'
                ];
                
                Mail::to($user->email)->send(new PaymentFailMail($content));
                $orderController = App::make('App\Http\Controllers\OrderController');
                $orderController->destroy($order->id);
                
            }
            else if($response->transaction_status === 'expire'){
                // Handle expire status
                $content = [
                    'subject' => 'Order Dihapus',
                    'user'=> $user->username,
                    'body' => 'Pembayaran sudah melewati batas expire/kadaluwarsa',
                    'status' =>'expire'
                ];
                
                Mail::to($user->email)->send(new PaymentFailMail($content));
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
