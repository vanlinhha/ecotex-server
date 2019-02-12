<?php

namespace App\Repositories;

use App\Models\SegmentGroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SegmentGroupsRepository
 * @package App\Repositories
 * @version February 12, 2019, 9:03 pm ICT
 *
 * @method SegmentGroups findWithoutFail($id, $columns = ['*'])
 * @method SegmentGroups find($id, $columns = ['*'])
 * @method SegmentGroups first($columns = ['*'])
*/
class SegmentGroupsRepository extends BaseRepository
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
        return SegmentGroups::class;
    }
}
