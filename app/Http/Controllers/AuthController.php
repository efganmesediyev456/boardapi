<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){

        $this->validate($request,[
            "email"=>"required|email",
            "password"=>"required"
        ]);
        $user=User::where("email",$request->email)->first();

        if(!$user || ! Hash::check($request->password,$user->password)){
            return response()->json([
                "errors"=>[
                    "message"=>[
                        "password and email does not match"
                    ]
                ]
            ],404);
        }
        $token=$user->createToken('Token Name')->accessToken;
        return response()->json([
            "message"=>"success",
            "data"=>$user,
            "token"=>$token,
        ],200);
    }
    public function register(Request $request){

        $this->validate($request,[
            "email"=>"required|email|unique:users,email",
            "password"=>"required|confirmed",
            "name"=>"required"
        ]);
        $user=User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
        ]);
        $token=$user->createToken('Token Name')->accessToken;
        return response()->json([
            "message"=>"success",
            "data"=>$user,
            "token"=>$token,
        ],200);
    }
}
