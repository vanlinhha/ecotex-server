<?php

namespace App\Repositories;

use App\Models\MainCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainCategoryRepository
 * @package App\Repositories
 * @version May 15, 2019, 9:26 am ICT
 *
 * @method MainCategory findWithoutFail($id, $columns = ['*'])
 * @method MainCategory find($id, $columns = ['*'])
 * @method MainCategory first($columns = ['*'])
*/
class MainCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'category_id',
        'percent'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainCategory::class;
    }
}
