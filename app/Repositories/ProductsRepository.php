<?php

namespace App\Repositories;

use App\Models\Products;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductsRepository
 * @package App\Repositories
 * @version March 29, 2019, 12:12 am ICT
 *
 * @method Products findWithoutFail($id, $columns = ['*'])
 * @method Products find($id, $columns = ['*'])
 * @method Products first($columns = ['*'])
*/
class ProductsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'product_group_id',
        'name',
        'is_main_product',
        'minimum_order_quantity_id',
        'lead_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Products::class;
    }
}
