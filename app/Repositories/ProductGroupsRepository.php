<?php

namespace App\Repositories;

use App\Models\ProductGroups;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductGroupsRepository
 * @package App\Repositories
 * @version February 9, 2019, 10:26 pm ICT
 *
 * @method ProductGroups findWithoutFail($id, $columns = ['*'])
 * @method ProductGroups find($id, $columns = ['*'])
 * @method ProductGroups first($columns = ['*'])
*/
class ProductGroupsRepository extends BaseRepository
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
        return ProductGroups::class;
    }
}
