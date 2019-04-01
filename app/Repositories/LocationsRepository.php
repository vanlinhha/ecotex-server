<?php

namespace App\Repositories;

use App\Models\Locations;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class LocationsRepository
 * @package App\Repositories
 * @version April 1, 2019, 11:26 am ICT
 *
 * @method Locations findWithoutFail($id, $columns = ['*'])
 * @method Locations find($id, $columns = ['*'])
 * @method Locations first($columns = ['*'])
*/
class LocationsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'is_headquater',
        'address',
        'zip_code',
        'city',
        'country_id',
        'phone'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Locations::class;
    }
}
