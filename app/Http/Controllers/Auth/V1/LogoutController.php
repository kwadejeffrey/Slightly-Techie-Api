<?php

namespace App\Http\Controllers\Auth\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //
    /**
     * Function to invalidate user token(s)
     * 
     * @return JsonResponse
     */
    public function logouts(Request $request)
    {
         
        auth()->user()->tokens()->delete();


        return new JsonResponse([
            "Success" => "Logged Out!"
        ]);
    }
}
