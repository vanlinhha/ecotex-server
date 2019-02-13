<?php

namespace App\Repositories;

use App\Models\TargetGroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TargetGroupsRepository
 * @package App\Repositories
 * @version February 13, 2019, 7:20 pm ICT
 *
 * @method TargetGroups findWithoutFail($id, $columns = ['*'])
 * @method TargetGroups find($id, $columns = ['*'])
 * @method TargetGroups first($columns = ['*'])
*/
class TargetGroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TargetGroups::class;
    }
}
