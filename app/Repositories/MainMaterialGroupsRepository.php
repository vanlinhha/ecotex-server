<?php

namespace App\Repositories;

use App\Models\MainMaterialGroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainMaterialGroupsRepository
 * @package App\Repositories
 * @version March 4, 2019, 11:42 am ICT
 *
 * @method MainMaterialGroups findWithoutFail($id, $columns = ['*'])
 * @method MainMaterialGroups find($id, $columns = ['*'])
 * @method MainMaterialGroups first($columns = ['*'])
*/
class MainMaterialGroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'material_group_id',
        'percent'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainMaterialGroups::class;
    }
}
