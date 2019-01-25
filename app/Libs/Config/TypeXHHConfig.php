<?php

/*
 * Cấu hình danh sách quyền sử dụng
 */

namespace App\Libs\Config;

class TypeXHHConfig
{

    private $arrTypeXHH;

    public function __construct()
    {
        $config          = config('parIndex');
        $this->arrTypeXHH = array_get($config, 'type-xhh');
    }

    /**
     * lấy danh sách quyền sử dụng
     * @return type
     */
    public function listTypeXHH()
    {
        $retVal = $this->arrTypeXHH;
        return $retVal;
    }
}
