<?php

namespace App\Repositories;

use App\Models\RoleTypes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RoleTypesRepository
 * @package App\Repositories
 * @version February 13, 2019, 6:34 pm ICT
 *
 * @method RoleTypes findWithoutFail($id, $columns = ['*'])
 * @method RoleTypes find($id, $columns = ['*'])
 * @method RoleTypes first($columns = ['*'])
*/
class RoleTypesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'role_id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RoleTypes::class;
    }
}
