<?php

namespace App\Repositories;

use App\Models\MainTargets;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainTargetsRepository
 * @package App\Repositories
 * @version February 13, 2019, 7:23 pm ICT
 *
 * @method MainTargets findWithoutFail($id, $columns = ['*'])
 * @method MainTargets find($id, $columns = ['*'])
 * @method MainTargets first($columns = ['*'])
*/
class MainTargetsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'target_group_id',
        'percent'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainTargets::class;
    }
}
