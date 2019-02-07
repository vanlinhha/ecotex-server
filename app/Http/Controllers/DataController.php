<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

class DataController
{
    public function open()
    {
        $data = __('test');
        return $data;
//        return response()->json(compact('data'),200);

    }

    public function closed()
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'), 200);
    }
}