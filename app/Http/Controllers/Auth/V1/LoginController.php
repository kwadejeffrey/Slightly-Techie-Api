<?php

namespace App\Http\Controllers\Auth\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\V1\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login(LoginRequest $request)
    {
        $user = [
            "email" => $request->email,
            "password" => $request->password
        ];
        
        if(Auth::attempt($user)){
            return new JsonResponse([
                "success" => "Welcome back" . ' '. auth()->user()->name
            ]);
        }
        // 1|QZHc0pFc62bf1WVcubEQapf3vTthfQV14Jbblzbm
    }
}
