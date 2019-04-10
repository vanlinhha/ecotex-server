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
        $this->middleware('jwt.verify');
        Talk::setAuthUserId(JWTAuth::parseToken()->authenticate()->id);
    }
    public function chatHistory($id)
    {
        $conversations = Talk::getMessagesByUserId($id, 0, 5);
        $user = '';
        $messages = [];
        if(!$conversations) {
            $user = Users::find($id);
        } else {
            $user = $conversations->withUser;
            $messages = $conversations->messages;
        }
        if (count($messages) > 0) {
            $messages = $messages->sortBy('id');
        }
        return $messages;

    }
    public function ajaxSendMessage(Request $request)
    {
        if ($request->ajax()) {
            $rules = [
                'message-data'=>'required',
                '_id'=>'required'
            ];
            $this->validate($request, $rules);
            $body = $request->input('message-data');
            $userId = $request->input('_id');
            if ($message = Talk::sendMessageByUserId($userId, $body)) {
                $html = view('ajax.newMessageHtml', compact('message'))->render();
                return response()->json(['status'=>'success', 'html'=>$html], 200);
            }
        }
    }
    public function ajaxDeleteMessage(Request $request, $id)
    {
        if ($request->ajax()) {
            if(Talk::deleteMessage($id)) {
                return response()->json(['status'=>'success'], 200);
            }
            return response()->json(['status'=>'errors', 'msg'=>'something went wrong'], 401);
        }
    }

    public function tests(Request $request)
    {
        $body = $request->input('message');
        $userId = $request->input('user_id');
        if (Talk::sendMessageByUserId($userId, $body)) {
            return response()->json(['success'=>'true', 'message'=>'OK'], 201);
        }
    }



    public function test()
    {
        return view('test');

        return talk_live(['user'=>["id"=>auth()->user()->id]]);
    }
}