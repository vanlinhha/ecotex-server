<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Users;
use Illuminate\Http\Request;
use Nahid\Talk\Facades\Talk;
use JWTAuth;

class MessageAPIController extends AppBaseController
{
    protected $authUser;

    public function __construct()
    {
        Talk::setAuthUserId(JWTAuth::parseToken()->authenticate()->id);
    }

    public function chatHistory($user_id, Request $request)
    {
        $start = isset($request->start) ? intval($request->start) : 0;
        $offset = isset($request->offset) ? intval($request->offset) : 10;

        $conversations = Talk::getMessagesByUserId($user_id, $start, $offset);
        $user = '';
        $messages = [];
        if (!$conversations) {
            $user = Users::find($user_id);
        } else {
            $user = $conversations->withUser;

            $messages = $conversations->messages;
        }
        if (count($messages) > 0) {
            $messages = $messages->sortBy('id');
        }
        return $messages;

    }

    public function deleteMessage(Request $request, $id)
    {
        if (Talk::deleteMessage($id)) {
            return response()->json(['success' => true, 'message' => 'Message deleted successfully!'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Something went wrong'], 401);
    }

    public function sendMessage(Request $request)
    {
        $body = $request->input('message');
        $userId = $request->input('user_id');
        if (Talk::sendMessageByUserId($userId, $body)) {
            return response()->json(['success' => true, 'message' => 'Message sent successfully!'], 201);
        }
    }

    public function getInbox(){
        return Talk::getInbox();
    }


    public function test()
    {

        $threads = Talk::threads();
        return $threads;
//        return view('test');
    }
}