<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Models\Cores\Cores_user;
use App\Models\Cores\Cores_user_meta;
use App\Models\Cores\Cores_ou;
use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ChangePasswordRequest;
use Auth;

class UserCtrl extends RestController
{

    /**
     * Get user info
     * @param Request $request
     * @param Cores_user $Cores_user
     * @return type
     */
    function getSingle(Request $request, Cores_user $Cores_user)
    {
        $userInfo = $Cores_user->getSingle($request->id);
        return response()->json($userInfo);
    }

    /**
     * get all user
     *
     * @param  \App\Models\Cores\Cores_user  $cores_ou
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request, Cores_user $cores_ou)
    {
        $v_limit = 25;
        return $cores_ou->getAll($v_limit, $request->ou);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(UserRequest $request, Cores_user $Cores_user)
    {

        //Build userInfo
        $userInfo       = [
            'user_login_name' => $request->input('user_login_name'),
            'user_name' => $request->input('user_name'),
            'user_email' => $request->input('user_email'),
            'password' => $request->input('user_password'),
            'user_order' => $request->input('user_order'),
            'user_status' => $request->input('user_status'),
        ];
        //Bui userOther
        $userOther      = [
            'user_address' => $request->input('user_address'),
            'user_job_title' => $request->input('user_job_title'),
            'user_phone' => $request->input('user_phone'),
        ];
        //Build Group Chosen
        $arrGroupChosen = is_array($request->input('groups')) ? $request->input('groups') : [];


        //Build unit chosen
        $arrOuChosen = is_array($request->input('ou')) ? $request->input('ou') : [];

        //Build unit chosen
        $arrPermitChosen = is_array($request->input('permit')) ? $request->input('permit') : [];

        $resp = $Cores_user->insertUser($userInfo, $userOther, $arrGroupChosen, $arrOuChosen, $arrPermitChosen);
        return response()->json([$resp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cores\Cores_user  $cores_user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, Cores_user $Cores_user)
    {
        //Build userInfo
        $userInfo       = [
            'id' => $request->id,
            'user_login_name' => $request->input('user_login_name'),
            'user_name' => $request->input('user_name'),
            'user_email' => $request->input('user_email'),
            'password' => $request->input('user_password'),
            'user_order' => $request->input('user_order'),
            'user_status' => $request->input('user_status'),
        ];
        //Bui userOther
        $userOther      = [
            'user_address' => $request->input('user_address'),
            'user_job_title' => $request->input('user_job_title'),
            'user_phone' => $request->input('user_phone'),
        ];
        //Build Group Chosen
        $arrGroupChosen = is_array($request->input('groups')) ? $request->input('groups') : [];

        //Build unit chosen
        $arrOuChosen = is_array($request->input('ou')) ? $request->input('ou') : [];

        //Build unit chosen
        $arrPermitChosen = is_array($request->input('permit')) ? $request->input('permit') : [];

        $resp = $Cores_user->edit($userInfo, $userOther, $arrGroupChosen, $arrOuChosen, $arrPermitChosen);
        return response()->json([$resp]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cores\Cores_user  $cores_ou
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cores_user $cores_ou)
    {
        $cores_ou::destroy($request->ou_id);
        return response()->json([]);
    }

    /**
     * Lấy danh sách cán bộ có quyền thẩm định
     */
    function getAllAssgin(Cores_user $userModel)
    {
        $arr_user = $userModel->getAllUserAssgin('expertise');
        return response()->json($arr_user);
    }

    /**
     * 
     * @param int $id Mã người sử dụng
     * @param ChangePasswordRequest $request
     * @param Cores_user $cores_user
     * @return type
     */
    function changePassword($id, ChangePasswordRequest $request, Cores_user $cores_user)
    {
        $cores_user::findOrFail($id);
        //valid id
        if (Auth::attempt(['id' => $id, 'user_login_name' => $request->user_login_name, 'password' => $request->password_old]))
        {
            $userInfo = ['password' => bcrypt($request->input('password'))];
            $cores_user->changePassword($request->user_login_name, $userInfo);
            return response()->json([]);
        }
        return $this->response('Mật khẩu cũ không chính xác!', null, 422);
    }
    /**
     * Lấy thông tin người sử dụng đã đăng nhập
     * return json
     */
    function getUser()
    {
        if (auth()->check())
        {
            return response(json_encode(auth()->user()));
        }
        return response(json_encode([]), 401);
    }

}
