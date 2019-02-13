<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    //
    protected $hidden = ['password', 'pivot', 'created_at', 'updated_at'];

}
