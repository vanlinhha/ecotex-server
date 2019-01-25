<?php

namespace App\Models\Cores;

use App\Models\Cores\Cores_group_meta;
use Illuminate\Database\Eloquent\Model;

class Cores_group extends Model
{

    protected $primaryKey = 'group_id';
    public $timestamps    = FALSE;
    protected $table      = 'cores_groups';

    /**
     * Thêm mới nhóm người sử dụng
     * @param type $groupInfo
     * @param array $permit
     * @param array $users
     */
    function addNew(array $groupInfo = [], array $permit = [], array $users = [])
    {
        //Save group info
        $v_group_id = $this->insertGetId($groupInfo);
        //Save mapp user->group
        Cores_user_meta::makeInstance()->updateGroupParentByMetaKey($v_group_id, $users);
        //Save mapp permit->group
        Cores_group_meta::makeInstance()->updateByMetaKey($v_group_id, $permit, Cores_group_meta::_CONST_PERMIT);
        return $v_group_id;
    }

    /**
     * Sửa thông tin nhóm người sử dụng
     * @param type $groupInfo
     * @param array $permit
     * @param array $users
     */
    function edit($v_group_id, $groupInfo, array $permit = [], array $users = [])
    {
        //Save group info
        $this->where('group_id', $v_group_id)->update($groupInfo);
        //Save mapp user->group
        Cores_user_meta::makeInstance()->updateGroupParentByMetaKey($v_group_id, $users);
        //Save mapp permit->group
        Cores_group_meta::makeInstance()->updateByMetaKey($v_group_id, $permit, Cores_group_meta::_CONST_PERMIT);
        return $v_group_id;
    }

    /**
     * Get group info
     * @param int $v_id
     * @return array
     */
    function getSingle($v_id)
    {
        $groupInfo = $this->find($v_id);
        if (!is_null($groupInfo))
        {
            $groupInfo = $groupInfo->toArray();
            $this->_getMeta($groupInfo);
        }
        return $groupInfo;
    }

    

    /**
     * get all group
     * @return type
     */
    function getAll()
    {
        $allGroup = $this->orderBy('group_id', 'desc')->get();
        if (is_null($allGroup))
        {
            return [];
        }

        foreach ($allGroup as &$groupInfo)
        {
            $groupInfo = $groupInfo->toArray();
            $this->_getMeta($groupInfo);
        }
        return $allGroup;
    }

    /**
     * 
     * @param type $v_group_id
     */
    private function _getMeta(&$groupInfo)
    {
        $other  = Cores_group_meta::where('group_id', $groupInfo['group_id'])->get();
        $permit = [];
        $users  = [];
        foreach ($other as $otherInfo)
        {
            if ($otherInfo->group_meta_key == Cores_group_meta::_CONST_PERMIT)
            {
                $permit[] = $otherInfo->group_meta_value;
            }
            elseif ($otherInfo->group_meta_key == Cores_group_meta::_CONST_USER_CHILD)
            {
                $users[] = (int) $otherInfo->group_meta_value;
            }
        }
        $groupInfo['users']  = $users;
        $groupInfo['permit'] = $permit;
    }

}
