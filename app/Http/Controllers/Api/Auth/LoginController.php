<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ResponseController;
use App\Http\Requests\Api\Auth\LoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends ResponseController
{
    public function login(LoginRequest $request){
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
                return ResponseController::CustomError('invalid credentials');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return ResponseController::CustomError('something went wrong');
        }

        //Authenticate the user with the token
        $user = JWTAuth::authenticate($token);

        $user->token = $token;

        return ResponseController::Response($user);

    }
}
