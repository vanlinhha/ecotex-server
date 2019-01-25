<?php

/*
 * Cấu hình danh sách quyền sử dụng
 */

namespace App\Libs\Config;

class MenuLeftConfig
{

    private $arrMenuLeft;

    public function __construct()
    {
        $config            = config('parIndex');
        $this->arrMenuLeft = array_get($config, 'menu-left');
    }

    public function listMenuLeft()
    {
        $retVal = $this->arrMenuLeft;
        return $retVal;
    }

    public function checkRole($code)
    {
        $retVal = false;
        foreach ($this->arrMenuLeft as $item)
        {
            if (array_key_exists($code, $item['permit']))
            {
                $retVal = true;
                break;
            }
        }
        return $retVal;
    }

}
