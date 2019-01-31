<?php

namespace App\Repositories;

use App\Models\Pets;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PetsRepository
 * @package App\Repositories
 * @version January 30, 2019, 12:53 am ICT
 *
 * @method Pets findWithoutFail($id, $columns = ['*'])
 * @method Pets find($id, $columns = ['*'])
 * @method Pets first($columns = ['*'])
*/
class PetsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'category'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pets::class;
    }
}
