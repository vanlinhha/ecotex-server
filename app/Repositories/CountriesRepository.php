<?php

namespace App\Repositories;

use App\Models\Countries;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CountriesRepository
 * @package App\Repositories
 * @version February 26, 2019, 12:35 am ICT
 *
 * @method Countries findWithoutFail($id, $columns = ['*'])
 * @method Countries find($id, $columns = ['*'])
 * @method Countries first($columns = ['*'])
*/
class CountriesRepository extends BaseRepository
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
        return Countries::class;
    }
}
