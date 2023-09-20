<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class RegisterController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'username'     => 'required|alpha_num|min:3',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'phone_number' => 'required|numeric|digits_between:10,13'
        ];
        $messages = [
            'username.required'           => 'Username harus diisi!',
            'username.alpha_num'          => 'Username hanya diisi dengan huruf dan angka.',
            'username.min'                => 'Username minimal :min karakter.',
            'email.required'              => 'Email harus diisi!',
            'email.email'                 => 'Email harus alamat email yang valid.',
            'email.unique'                => 'Email sudah digunakan!',
            'password.required'           => 'Password harus diisi!',
            'password.confirmed'          => 'Password harus sama dengan konfirmasi password!',
            'password.min'                => 'Password minimal :min karakter.',
            'password.regex'              => 'Password terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol.',
            'phone_number.required'       => 'Nomor Telepon harus diisi!',
            'phone_number.numeric'        => 'Nomor Telepon harus angka.',
            'phone_number.digits_between' => 'Nomor Telepon harus di antara :min dan :max digit',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        $now = date('Y-m-d H:i:s');
        $limit = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime($now)));

        $user = User::create([
            'username'              => $request->username,
            'email'                 => $request->email,
            'password'              => Hash::make($request->password),
            'phone_number'          => $request->phone_number,
            'register_verification' => '1',
            'role_id'               => '3',
            'encrypt_id'            => Crypt::encrypt($request->email),
            'expired_time'          => $limit,
        ]);

        //Auth::login($user);
        
        //auto redirect to home
        //return redirect(RouteServiceProvider::HOME); 

        return response()->json(['user' => $user,'message' => 'Registration successful',], 201);
    }
}
