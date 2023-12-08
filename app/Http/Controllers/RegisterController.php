<?php

namespace App\Http\Controllers;

use App\Mail\UserVerification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class RegisterController extends Controller
{

    /**  Keterangan verifikasi status:
    *       0 => sudah terferifikasi
    *       1 => belum terverifikasi
    *    Keterangan role:
    *       1 => admin
    *       2 => customer
    */
    public function store(Request $request)
    {
        try{
            $validatedData = $request->validate([
                'username' => [
                    'required',
                    'alpha_num',
                    'min:3'
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:users'
                ],
                'password' => [
                    'required',
                    Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                ],
                    'phone_number' => ['required'],
            ]);
        }catch (ValidationException $e){
            return response()->json([
                'message' => 'Validasi gagal ',
                'errors' => $e->errors(), 
                'response' => 422
            ]);
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['role_id'] = 2;
        $user = User::create($validatedData);

        if($user){
            try{
                Mail::mailer('smtp')->to($user->email)->send(new UserVerification($user));
    
                return response()->json([
                    'user' => $user,
                    'message' => 'Registrasi berhasil', 
                    'response' => 200
                ]);
            }
            catch (\Exception $e){
                $user->delete();
            }   
        }
    }

    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'message' => 'Invalid/Expired url provided',
                'response' => 400,
            ]);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            $redirect = $request->input('redirect', null);
            if ($redirect) {
                return redirect()->away($redirect);
            }

            return response()->json([
                'message' => 'Email berhasil diverifikasi',
                'response' => 200,
            ]);
        } else {
            return redirect()->back()->with('error', 'Email sudah terverifikasi');
        }
    }

}
