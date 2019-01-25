<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Models\Cores\Cores_group;
use App\Models\Cores\Cores_group_meta;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\RestController;
use Validator;
use App\Http\Requests\GroupRequest;

class GroupCtrl extends RestController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(GroupRequest $request, Cores_group $Cores_group)
    {
        $groupInfo = [
            'group_name'   => $request->group_name,
            'group_status' => $request->group_status
        ];
        $permit    = $request->input('permit');
        $users     = $request->input('users');
        try
        {
            $Cores_group->addNew($groupInfo, $permit, $users);
        }
        catch (\Exception $ex)
        {
            return response()->json(['data' => ['errors' => $ex->getMessage()]], 500);
        }
        return response()->json([]);
    }

    /**
     * Store a edit created resource in storage.
     * @param GroupRequest $request
     * @param Cores_group $Cores_group
     * @return type
     */
    public function edit(GroupRequest $request, Cores_group $Cores_group)
    {
        $groupInfo = [
            'group_name'   => $request->group_name,
            'group_status' => $request->group_status
        ];
        $permit    = $request->input('permit');
        $users     = $request->input('users');
        try
        {
            $Cores_group->edit($request->id, $groupInfo, $permit, $users);
        }
        catch (\Exception $ex)
        {
            return response()->json(['data' => ['errors' => $ex->getMessage()]], 500);
        }
        return response()->json([]);
    }

    /**
     * get group info
     * @param Request $request
     * @param Cores_group $Cores_group
     * @return type
     */
    function getSingle(Request $request, Cores_group $Cores_group)
    {
        $Cores_group::findOrFail($request->id);
        $groupInfo = $Cores_group->getSingle($request->id);
        $groupInfo['users'] = Cores_user_meta::where([
                    ['user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT],
                    ['user_meta_value', $request->id],
                ])->pluck('user_id');
        return response()->json($groupInfo);
    }

    function getAll(Request $request, Cores_group $Cores_group)
    {
        $allGroups = $Cores_group->getAll();
        return response()->json($allGroups);
    }
}
