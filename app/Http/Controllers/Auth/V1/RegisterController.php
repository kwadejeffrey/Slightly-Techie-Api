<?php

namespace App\Http\Controllers\Auth\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\V1\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function register(RegisterRequest $request)
    {
        // return dd($request);
        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ];

        $user = User::create($data);

        if(!$user){
            new JsonResponse([
                "Failed" => "Failed to create account"
            ]);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return new JsonResponse([
            "user" => new UserResource($user),
            "token" => $token
        ]);
    }
}
