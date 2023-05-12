<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Rider;
use App\Role;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {


        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        $email = $request->login;
        $password = $request->password;

        if (Auth::guard('api')->attempt(['email' => $email, 'password' => $password])) {
            $rider = Rider::where('email', $email)->first();
            $token = Auth::guard('api')->login($rider);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, Auth::guard('api')->user());
    } //end method login

    private function respondWithToken($token, $user)
    {
        return response()->json([
            'token_info' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                // 'expires_in' => auth()->factory()->getTTL() * 60
            ],
            'user' => $user,
            'roles' => Role::orderBy('admin')->pluck('admin')->toArray()
        ]);
    }
}//
