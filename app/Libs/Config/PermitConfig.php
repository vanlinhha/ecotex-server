<?php

/*
 * Cấu hình danh sách quyền sử dụng
 */

namespace App\Libs\Config;

class PermitConfig
{

    private $arrPermit;

    public function __construct()
    {
        $config          = config('parIndex');
        $this->arrPermit = array_get($config, 'roles');
    }

    /**
     * lấy danh sách quyền sử dụng
     * @return type
     */
    public function listPermit()
    {
        $retVal = $this->arrPermit;
        return $retVal;
    }

    public function checkPermit($code)
    {
        $retVal = false;
        foreach ($this->arrPermit as $item)
        {
            if (array_key_exists($code, $item['permit']))
            {
                $retVal = true;
                break;
            }
        }
        return $retVal;
    }

    public function listPermitOfArray($data)
    {
        $retVal = [];
        foreach ($this->arrPermit as $item)
        {
            foreach ($item['permit'] as $permitCode => $permitName)
            {
                if ($data->contains('permit', $permitCode))
                {
                    $retVal[$permitCode] = $permitName;
                }
            }
        }

        return $retVal;
    }

}
