<?php

namespace App\Repositories;

use App\Models\Services;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ServicesRepository
 * @package App\Repositories
 * @version February 25, 2019, 11:32 am ICT
 *
 * @method Services findWithoutFail($id, $columns = ['*'])
 * @method Services find($id, $columns = ['*'])
 * @method Services first($columns = ['*'])
*/
class ServicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'role_id',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Services::class;
    }
}
