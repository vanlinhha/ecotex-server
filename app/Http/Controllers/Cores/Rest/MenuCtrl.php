<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Http\Controllers\RestController;
use Illuminate\Http\Request;
use App\User;

class MenuCtrl extends RestController
{

    private $asideLeft;

    function __construct()
    {
        $this->asideLeft = app('MenuLeftConfig');
    }

    public function store()
    {
        $user     = new User();
        $arr_menu = $this->asideLeft->listMenuLeft();
        $menu_tmp = [];
        if (is_null($user))
        {
            return response()->json($menu_tmp);
        }

        foreach ($arr_menu as &$menu)
        {
            $show       = false;
            $permit_tmp = [];
            foreach ($menu['permit'] as $key => $permit)
            {
                if ($user->hasRole($key) || $key == 'notification' || $key == 'media')
                {
                    $permit_tmp[$key] = $menu['permit'][$key];
                    $show             = true;
                }
            }
            if ($show)
            {
                $menu['permit'] = $permit_tmp;
                $menu_tmp[]     = $menu;
            }
        }
        return response()->json($menu_tmp);
    }

}
