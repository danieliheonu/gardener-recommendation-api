<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function update_user_profile(Request $request, $id){
        $user = User::find($id);
        if($user == null){
            return response()->json([
                "status" => 404,
                "message" => "user not found"
            ]);
        }

        $user->update([
            "full_name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        return response()->json([
            "status" => 200,
            "message" => "successfully updated",
            "data" => $user
        ]);
    }

    public function retrieve_user_profile($id){
        $user = User::find($id);

        if($user == null){
            return response()->json([
                "status" => 404,
                "message" => "user not found"
            ]);
        }

        return response()->json([
            "status" => 200,
            "message" => "successfully updated",
            "data" => $user
        ]);
    }
}
