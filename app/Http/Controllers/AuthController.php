<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $validation = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ];

        $validator = Validator::make($request->all(), $validation);

        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "message" => $validator->errors(),
            ]);
        }

        $user = User::create([
            'full_name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            "status" => 201,
            "message" => "user successfully created",
            "data" => $user,
        ]);
    }

    public function login(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($data)){
            return response()->json([
                "status" => 200,
                "message" => "login successful",
                "token" => auth()->user()->createToken('API Token')->plainTextToken
            ]);
        }

        return response()->json([
            "status" => 400,
            "message" => "incorrect credentials",
        ]);
    }

    public function logout(){
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => 200,
            "message" => "logout successful"
        ]);
    }
}
