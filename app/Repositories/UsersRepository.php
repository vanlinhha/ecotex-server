<?php

namespace App\Repositories;

use App\Models\Users;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsersRepository
 * @package App\Repositories
 * @version February 9, 2019, 2:58 pm ICT
 *
 * @method Users findWithoutFail($id, $columns = ['*'])
 * @method Users find($id, $columns = ['*'])
 * @method Users first($columns = ['*'])
*/
class UsersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'email',
        'password',
        'type',
        'first_name',
        'last_name',
        'phone',
        'country',
        'company_name',
        'brief_name',
        'company_address',
        'website',
        'description',
        'is_paid',
        'address',
        'identity_card',
        'establishment_year',
        'business_registration_number',
        'form_of_ownership',
        'number_of_employees',
        'floor_area',
        'area_of_factory',
        'commercial_service_type',
        'revenue_per_year',
        'pieces_per_year',
        'compliance',
        'activation_code'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Users::class;
    }
}
