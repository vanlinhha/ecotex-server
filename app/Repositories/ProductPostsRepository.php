<?php

namespace App\Repositories;

use App\Models\ProductPosts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductPostsRepository
 * @package App\Repositories
 * @version March 10, 2019, 3:39 pm ICT
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
        'target_group_id',
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
