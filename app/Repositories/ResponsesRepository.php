<?php

namespace App\Repositories;

use App\Models\Responses;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ResponsesRepository
 * @package App\Repositories
 * @version March 25, 2019, 11:05 pm ICT
 *
 * @method Responses findWithoutFail($id, $columns = ['*'])
 * @method Responses find($id, $columns = ['*'])
 * @method Responses first($columns = ['*'])
*/
class ResponsesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_post_id',
        'owner_id',
        'accepted_quantity',
        'suggest_quantity',
        'accepted_price',
        'suggest_price',
        'accepted_delivery',
        'suggest_delivery'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Responses::class;
    }
}
