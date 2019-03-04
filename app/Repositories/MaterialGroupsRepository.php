<?php

namespace App\Repositories;

use App\Models\MaterialGroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MaterialGroupsRepository
 * @package App\Repositories
 * @version March 4, 2019, 10:53 am ICT
 *
 * @method MaterialGroups findWithoutFail($id, $columns = ['*'])
 * @method MaterialGroups find($id, $columns = ['*'])
 * @method MaterialGroups first($columns = ['*'])
*/
class MaterialGroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'parent_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MaterialGroups::class;
    }
}
