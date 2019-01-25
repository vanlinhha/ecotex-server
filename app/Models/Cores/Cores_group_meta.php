<?php

namespace App\Models\Cores;

use App\Models\Cores\Cores_user_meta;
use Illuminate\Database\Eloquent\Model;

class Cores_group_meta extends Model
{

    protected $primaryKet = 'group_meta_id';
    public $timstamps     = FALSE;
    protected $table      = 'cores_group_metas';

    const _CONST_USER_CHILD = 'USER_CHILD'; //NSD thuộc nhóm NSD
    #quyền
    const _CONST_PERMIT     = 'permit';

    static function makeInstance()
    {
        return new self();
    }

    /**
     * Update meta by key
     * @param int $v_group_id
     * @param array $arr_meta_value
     * @param string $v_meta_key 
     */
    function updateByMetaKey($v_group_id, array $arr_meta_value = [], $key)
    {
        if ($v_group_id)
        {
            $this->where([
                ['group_id', $v_group_id],
                ['group_meta_key', '=', $key]
            ])->delete();
            
            foreach ($arr_meta_value as $item)
            {
                $this->insert([
                    'group_id'         => $v_group_id,
                    'group_meta_key'   => $key,
                    'group_meta_value' => $item
                ]);
            }
        }
    }

    /**
     * Cập nhật quyền sử dụng cho nhóm người sử dụng
     * @param type $group_id
     * @param array $arr_permit
     */
    public function updatePermit($group_id, array $arr_permit = array())
    {
        if ($group_id)
        {
            $this->where([
                ['group_id', $group_id],
                ['group_meta_key', '=', self::_CONST_PERMIT]
            ])->delete();
            foreach ($arr_permit as $permit)
            {
                $this->insert([
                    'group_id'         => $group_id,
                    'group_meta_key'   => self::_CONST_PERMIT,
                    'group_meta_value' => $permit
                ]);
            }
        }
    }

    /**
     * Cập nhật người sử dụng thuộc nhóm
     * @param type $group_id
     * @param array $arr_id_user
     */
    public function updateUserOfGroup($group_id, array $arr_id_user = array())
    {
        if ($group_id)
        {
            $this->where([
                ['group_id', $group_id],
                ['group_meta_key', '=', self::_CONST_USER_CHILD]
            ])->delete();
            foreach ($arr_id_user as $id_user)
            {
                $this->insert([
                    'group_id'         => $group_id,
                    'group_meta_key'   => self::_CONST_USER_CHILD,
                    'group_meta_value' => $id_user
                ]);
            }

            Cores_user_meta::where([
                ['user_meta_value', $group_id],
                ['user_meta_key', '=', Cores_user_meta::_CONST_GROUP_PARENT]
            ])->delete();
            foreach ($arr_id_user as $id_user)
            {
                Cores_user_meta::insert([
                    'user_id'         => $id_user,
                    'user_meta_key'   => Cores_user_meta::_CONST_GROUP_PARENT,
                    'user_meta_value' => $group_id
                ]);
            }
        }
    }

    //lấy danh sách nhóm theo quyền
}
