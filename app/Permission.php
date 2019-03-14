<?php

namespace App;

use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    //
    protected $hidden = ['password', 'created_at', 'updated_at'];

}
