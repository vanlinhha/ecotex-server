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
        $start  = isset($request->start) ? intval($request->start) : 0;
        $offset = isset($request->offset) ? intval($request->offset) : 10;

        $conversations = Talk::getMessagesByUserId($user_id, $start, $offset);
        $user          = '';
        $messages      = [];
        if (!$conversations) {
            $user = Users::find($user_id);
        } else {
            $user = $conversations->withUser;

            $messages = $conversations->messages;
        }
        if (count($messages) > 0) {
            $messages = $messages->sortBy('id');
        }
        return ['data' => $messages, 'success' => true] ;

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
        $body   = $request->input('message');
        $userId = $request->input('user_id');
        if (Talk::sendMessageByUserId($userId, $body)) {
            return response()->json(['success' => true, 'message' => 'Message sent successfully!'], 201);
        }
    }

    public function getInbox(Request $request)
    {

        $offset = isset($request->offset) ? intval($request->offset) : 0;
        $take   = isset($request->take) ? intval($request->take) : 20;
        $order  = isset($request->order) ? $request->order : "desc";
        return ['data' => Talk::getInbox($order, $offset, $take), 'success' => true] ;
    }

    public function getConversationsById($id, Request $request)
    {
        $offset = isset($request->offset) ? intval($request->offset) : 0;
        $take   = isset($request->take) ? intval($request->take) : 20;

        $conversations = Talk::getConversationsById($id, $offset, $take);
        $messages      = $conversations->messages;
        $withUser      = $conversations->withUser;
        return ['data' => $messages, 'success' => true] ;

    }

    public function getConversationsByUserId($id, Request $request)
    {
        $offset = isset($request->offset) ? intval($request->offset) : 0;
        $take   = isset($request->take) ? intval($request->take) : 20;
        $conversations = Talk::getConversationsByUserId($id, $offset, $take);
        $messages      = $conversations->messages;
        $withUser      = $conversations->withUser;
        return ['data' => $messages, 'success' => true] ;
    }

    public function makeSeen($message_id)
    {
        if(Talk::makeSeen($message_id)){
            return response()->json(['success' => true, 'message' => 'Message updated successfully!'], 200);
        };
        return response()->json(['success' => false, 'message' => 'Message updated unsuccessfully!'], 400);
    }


    public function test()
    {

        $threads = Talk::threads();
        return $threads;
//        return view('test');
    }
}