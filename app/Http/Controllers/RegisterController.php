<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'username'     => 'required|alpha_num|min:3',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'phone_number' => 'required'
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
            return response()->json(['message' => 'Validasi gagal ' + $validator->errors(), 'errors' => $validator->errors(), 'response' => 422]);
        }

        $user = User::create([
            'username'              => $request->username,
            'email'                 => $request->email,
            'password'              => bcrypt($request->password),
            'phone_number'          => $request->phone_number,
            'role_id'               => '2',
        ]);

        return response()->json(['user' => $user,'message' => 'Registrasi berhasil', 'response' => 200]);
    }
}
