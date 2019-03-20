<?php

namespace App\Repositories;

use App\Models\ProductPosts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductPostsRepository
 * @package App\Repositories
 * @version March 19, 2019, 10:50 am ICT
 *
 * @method ProductPosts findWithoutFail($id, $columns = ['*'])
 * @method ProductPosts find($id, $columns = ['*'])
 * @method ProductPosts first($columns = ['*'])
*/
class ProductPostsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_group_id',
        'quantity',
        'target_price',
        'specification',
        'type_id',
        'incoterm',
        'creator_id',
        'title'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductPosts::class;
    }
}
