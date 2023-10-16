<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{

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
                    'required', 'confirmed',
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

        return response()->json([
            'user' => $user,
            'message' => 'Registrasi berhasil', 
            'response' => 200
        ]);
    }
}
