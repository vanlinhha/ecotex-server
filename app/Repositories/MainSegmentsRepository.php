<?php

namespace App\Repositories;

use App\Models\MainSegments;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainSegmentsRepository
 * @package App\Repositories
 * @version February 11, 2019, 11:28 pm ICT
 *
 * @method MainSegments findWithoutFail($id, $columns = ['*'])
 * @method MainSegments find($id, $columns = ['*'])
 * @method MainSegments first($columns = ['*'])
*/
class MainSegmentsRepository extends BaseRepository
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
        return MainSegments::class;
    }

    public function findWithUserInfo($id, $columns = ['*']){
//        $this->applyCriteria();
//        $this->applyScope();
        return $this->model->findOrFail($id, $columns)->users()->get(['id', 'first_name']);
    }
}
