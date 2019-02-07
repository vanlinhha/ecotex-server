<?php

namespace App\Http\Controllers\API;

use App\Models\Cores\Cores_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\RestController;
use App\User;

class UserController extends RestController
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('user_email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => __('invalid_credentials')], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => __('could_not_create_token')], 500);
        }

        return response()->json(compact('token'), 201, []);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name'     => 'required|string|max:255',
            'user_email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'user_name'     => $request->post('user_name'),
            'user_email'    => $request->post('user_email'),
            'password' => Hash::make($request->post('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json($user);
    }

    static function makeInstance()
    {
        return new self();
    }
}