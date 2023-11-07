<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'     => 'required|string|max:150',
            'email'    => 'required|email:rfc|unique:App\Models\User,email',
            'picture'  => 'file|image',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {

            return response()->json([
                'status' => "ok",
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $data = $validator->validated();
            $fileName = 'profil_'.time().'.'.$request->picture->extension();
            $request->picture->move(public_path('uploads/Users/Pictures'), $fileName);
            $user = User::create([
                "name"     => $data['name'],
                "email"    => $data['email'],
                "password" => $data['password'],
                "picture"  => "uploads/Users/Pictures/".$fileName
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(
                [
                    'status' => "ok",
                    'message' => "User saved",
                    'data'  => [
                        "access_token" => $token,
                        "token_type"   => 'Bearer'
                    ]
                ], 200);
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'    => 'required|email:rfc|exists:App\Models\User,email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {

            return response()->json([
                'status' => "ok",
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $data = $validator->validated();
            if (Auth::attempt($data)) {
                $user  = User::select('users.*')->where('email', $data['email'])->first();
                // dd($user);
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json(
                    [
                        'status' => "ok",
                        'message' => "Login successful",
                        'data'  => [
                            "user" => $user,
                            "access_token" => $token,
                            "token_type"   => 'Bearer'
                        ]
                    ], 200);
            }else {
                return response()->json([
                    'status' => "ok",
                    'errors' => "Incorrect email or password.",
                ], 422);
            }

        }
    }
}
