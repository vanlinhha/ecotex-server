<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class DataController
{
    public function open()
    {
        $user = JWTAuth::parseToken()->authenticate();
        dd(JWTAuth::user());
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('user'));
//        return response()->json(compact('data'),200);

    }

    public function closed()
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'), 200);
    }
}