<?php

namespace App\Models\Cores;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Cores_user extends Model
{
    use Notifiable;

    protected $primaryKey = 'id';
    public $timestamps    = FALSE;
    protected $table      = 'users';
    protected $hidden     = [
        'password', 'remember_token',
    ];

    static function makeInstance()
    {
        return new self();
    }

    function insertUser(array $userInfo = [], array $userOther = [], array $arrGroupChosen = [], array $arrOuChosen = [], array $arrPermitChosen = [])
    {
        $v_user_id = 0;
        $userMeta  = new Cores_user_meta();
        try
        {
            $userInfo['password']    = bcrypt($userInfo['password']);
            $userInfo['user_status'] = boolval($userInfo['user_status']);
            $userInfo['user_order']  = intval($userInfo['user_order']);
            $v_user_id               = $this->insertGetId($userInfo);

            //update info
            $userMeta->updateUserInfo($v_user_id, $userOther);
            //update ou parent
            $userMeta->updateByMetaKey($v_user_id, $arrOuChosen, Cores_user_meta::_CONST_OU_PARENT);
            #Insert permit
            $userMeta->updateByMetaKey($v_user_id, $arrPermitChosen, Cores_user_meta::_CONST_PERMIT);
            #Insert group
            $userMeta->updateByMetaKey($v_user_id, $arrGroupChosen, Cores_user_meta::_CONST_GROUP_PARENT);
        }
        catch (Exception $ex)
        {
            //Rollback
            $this->where('id', $v_user_id)->delete();
            Cores_user_meta::where('user_id', $v_user_id)->delete();
        }
        return $v_user_id;
    }

    function edit(array $userInfo = [], array $userOther = [], array $arrGroupChosen = [], array $arrOuChosen = [], array $arrPermitChosen = [])
    {
        $userMeta = new Cores_user_meta();
        try
        {
            $v_user_id = $userInfo['id'];
            if (trim($userInfo['password']) != '')
            {
                $userInfo['password'] = bcrypt($userInfo['password']);
            }
            else
            {
                unset($userInfo['password']);
            }
            $userInfo['user_status'] = boolval($userInfo['user_status']);
            $userInfo['user_order']  = intval($userInfo['user_order']);
            $this->where('id', $v_user_id)->update($userInfo);

            //update info
            $userMeta->updateUserInfo($v_user_id, $userOther);
            //update ou parent
            $userMeta->updateByMetaKey($v_user_id, $arrOuChosen, Cores_user_meta::_CONST_OU_PARENT);
            #Insert permit
            $userMeta->updateByMetaKey($v_user_id, $arrPermitChosen, Cores_user_meta::_CONST_PERMIT);
            #Insert group
            $userMeta->updateByMetaKey($v_user_id, $arrGroupChosen, Cores_user_meta::_CONST_GROUP_PARENT);
        }
        catch (Exception $ex)
        {
            //Rollback
            $this->where('id', $v_user_id)->delete();
            Cores_user_meta::where('user_id', $v_user_id)->delete();
        }
        return $v_user_id;
    }

    /**
     * Lấy danh sách người sử dụng theo quyền cần xét
     * @param string $v_permit \App\Libs\Config\PermitConfig;
     * @param array $arr_group_permit Mạng chứa danh sách group có quyền $permit nếu có
     * @return array  mảng chứa danh sách ID các user thỏa mãn điều kiện
     */
    function getFullUserPermit($v_permit, array $arr_group_permit = array())
    {
        return Cores_user_meta::select('users.user_name', 'users.id')
                        ->leftJoin('users', 'users.id', '=', 'cores_user_metas.user_id')
                        ->where([
                            ['user_meta_key', Cores_user_meta::_CONST_PERMIT],
                            ['user_meta_value', $v_permit],
                        ])
                        ->orWhere(function($sql) use($arr_group_permit)
                        {
                            $sql->where([
                                ['user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT]
                            ])
                            ->whereIn('user_meta_value', $arr_group_permit);
                        })
                        ->select(\DB::raw('distinct(users.id) as id'))
                        ->pluck('users.id')->toArray();
    }

    /**
     * 
     * @param type $v_user_id
     * @return type
     */
    function getSingle($v_user_id)
    {
        $userInfo = Cores_user::find($v_user_id);
        if (is_null($userInfo))
        {
            return [];
        }
        $this->_load_other($userInfo);
        return $userInfo->toArray();
    }

    /**
     * Lay danh sach nguoi su dung
     */
    public function getAll($v_limit = 25, $v_ou_id = null)
    {
        if (is_null($v_ou_id))
        {
            $allUsers = $this->orderBy('id', 'desc')->paginate($v_limit);
        }
        else
        {
            $arr_user_id = Cores_user_meta::where([
                        ['user_meta_key', Cores_user_meta::_CONST_OU_PARENT],
                        ['user_meta_value', $v_ou_id],
                    ])->pluck('user_id');
            $allUsers = $this->whereIn('id', $arr_user_id)->orderBy('id', 'desc')->paginate($v_limit);
        }

        if (is_null($allUsers))
        {
            return [];
        }

        foreach ($allUsers as &$userInfo)
        {
            $this->_load_other($userInfo);
        }
        return $allUsers->toArray();
    }

    /**
     * Load user info from meta
     * @param object $userInfo
     */
    private function _load_other(&$userInfo)
    {
        $other  = Cores_user_meta::where('user_id', $userInfo->id)->get();
        $permit = [];
        $groups = [];
        $ou     = [];
        foreach ($other as $otherInfo)
        {
            if ($otherInfo->user_meta_key == Cores_user_meta::_CONST_PERMIT)
            {
                $permit[] = $otherInfo->user_meta_value;
            }
            elseif ($otherInfo->user_meta_key == Cores_user_meta::_CONST_GROUP_PARENT)
            {
                $groups[] = (int) $otherInfo->user_meta_value;
            }
            elseif ($otherInfo->user_meta_key == Cores_user_meta::_CONST_OU_PARENT)
            {
                $ou[] = (int) $otherInfo->user_meta_value;
            }
            else
            {
                $userInfo->{$otherInfo->user_meta_key} = $otherInfo->user_meta_value;
            }
        }
        $userInfo->permit = $permit;
        $userInfo->groups = $groups;
        $userInfo->ou     = $ou;
    }

    function getAllUserAssgin($role)
    {
        //Load danh sách nhóm có quyền $role

        $arr_group_id = Cores_group_meta::where([
                    ['group_meta_key', Cores_group_meta::_CONST_PERMIT],
                    ['group_meta_value', $role],
                ])->pluck('group_id');

        $arr_user_id = Cores_user_meta::where('user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT)
                ->whereIn('user_meta_value', $arr_group_id)
                ->orWhere(function($sql) use ($role)
                {
                    $sql->where('user_meta_key', Cores_user_meta::_CONST_PERMIT)
                    ->where('user_meta_value', $role);
                })
                ->pluck('user_id');
        //load danh sách user có quyền $role
        $users = $this->whereIn('id', $arr_user_id)->get();
        foreach ($users as &$userInfo)
        {
            $this->_load_other($userInfo);
        }
        return $users;
    }

    function permission($role)
    {
        if (!Auth::check())
        {
            return FALSE;
        }
        $v_user_id = auth()->user()->id;
        $hasRole   = Cores_user_meta::where([
                    ['user_id', $v_user_id],
                    ['user_meta_key', Cores_user_meta::_CONST_PERMIT],
                    ['user_meta_value', $role],
                ])->count();
        if ($hasRole > 0)
            return TRUE;

        //Check join group has permission
        $allGroupIdHasRole = Cores_group_meta::where([
                    ['group_meta_key', Cores_group_meta::_CONST_PERMIT],
                    ['group_meta_value', $role],
                ])
                ->leftJoin('cores_groups', 'cores_groups.group_id', '=', 'cores_group_metas.group_id')
                ->where('cores_groups.group_status', 1)
                ->pluck('cores_groups.group_id');

        $hasRole = Cores_user_meta::where([
                    ['user_id', $v_user_id],
                    ['user_meta_key', Cores_user_meta::_CONST_GROUP_PARENT],
                ])
                ->whereIn('user_meta_value', $allGroupIdHasRole)
                ->count();

        if ($hasRole > 0)
            return TRUE;
        return FALSE;
    }

    function changePassword($user_login_name, $userInfo)
    {
        $this->where('user_login_name', $user_login_name)->update($userInfo);
    }

}
