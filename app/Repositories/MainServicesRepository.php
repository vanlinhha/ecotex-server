<?php

namespace App\Repositories;

use App\Models\MainServices;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MainServicesRepository
 * @package App\Repositories
 * @version February 26, 2019, 6:16 pm ICT
 *
 * @method MainServices findWithoutFail($id, $columns = ['*'])
 * @method MainServices find($id, $columns = ['*'])
 * @method MainServices first($columns = ['*'])
*/
class MainServicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'service_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MainServices::class;
    }
}
