<?php

namespace App\Repositories;

use App\Models\MainExportCountries;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainExportCountriesRepository
 * @package App\Repositories
 * @version March 4, 2019, 7:48 pm ICT
 *
 * @method MainExportCountries findWithoutFail($id, $columns = ['*'])
 * @method MainExportCountries find($id, $columns = ['*'])
 * @method MainExportCountries first($columns = ['*'])
*/
class MainExportCountriesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'country_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainExportCountries::class;
    }
}
