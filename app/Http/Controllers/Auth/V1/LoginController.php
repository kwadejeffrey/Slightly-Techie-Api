<?php

namespace App\Http\Controllers\Auth\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\V1\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login(LoginRequest $request)
    {
        $data = [
            "email" => $request->email,
            "password" => $request->password
        ];
        
        if(Auth::attempt($data)){
            $user = auth()->user();
            $token = $user->createToken($user->name)->plainTextToken;
            return new JsonResponse([
                "success" => "Welcome back" . ' '. $user->name . rand(1,10),
                "token" => $token
            ]);
        }else{
            return new JsonResponse([
                "Failed" => "Login failed"
            ]);
        }
        // dd(auth()->user());
        // 1|QZHc0pFc62bf1WVcubEQapf3vTthfQV14Jbblzbm
    }
}
