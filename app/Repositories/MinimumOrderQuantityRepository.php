<?php

namespace App\Repositories;

use App\Models\MinimumOrderQuantity;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MinimumOrderQuantityRepository
 * @package App\Repositories
 * @version February 16, 2019, 4:22 pm ICT
 *
 * @method MinimumOrderQuantity findWithoutFail($id, $columns = ['*'])
 * @method MinimumOrderQuantity find($id, $columns = ['*'])
 * @method MinimumOrderQuantity first($columns = ['*'])
*/
class MinimumOrderQuantityRepository extends BaseRepository
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
        return MinimumOrderQuantity::class;
    }
}
