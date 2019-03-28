<?php

namespace App\Repositories;

use App\Models\ProductImages;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductImagesRepository
 * @package App\Repositories
 * @version March 23, 2019, 11:51 pm ICT
 *
 * @method ProductImages findWithoutFail($id, $columns = ['*'])
 * @method ProductImages find($id, $columns = ['*'])
 * @method ProductImages first($columns = ['*'])
*/
class ProductImagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_id',
        'url',
        'name',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductImages::class;
    }
}
