<?php

namespace App\Repositories;

use App\Models\MainProductGroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainProductGroupsRepository
 * @package App\Repositories
 * @version February 10, 2019, 12:37 am ICT
 *
 * @method MainProductGroups findWithoutFail($id, $columns = ['*'])
 * @method MainProductGroups find($id, $columns = ['*'])
 * @method MainProductGroups first($columns = ['*'])
*/
class MainProductGroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'product_group_id',
        'percent'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainProductGroups::class;
    }
}
