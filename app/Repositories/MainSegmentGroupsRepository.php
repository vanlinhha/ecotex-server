<?php

namespace App\Repositories;

use App\Models\MainSegmentGroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainSegmentGroupsRepository
 * @package App\Repositories
 * @version February 11, 2019, 11:28 pm ICT
 *
 * @method MainSegmentGroups findWithoutFail($id, $columns = ['*'])
 * @method MainSegmentGroups find($id, $columns = ['*'])
 * @method MainSegmentGroups first($columns = ['*'])
*/
class MainSegmentGroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'segment_id',
        'percent'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainSegmentGroups::class;
    }

    public function findWithUserInfo($id, $columns = ['*']){
//        $this->applyCriteria();
//        $this->applyScope();
        return $this->model->findOrFail($id, $columns)->users()->get(['id', 'first_name']);
    }
}
