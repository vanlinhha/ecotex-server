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
        'country_id',
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

    public function findWhereInAndPaginate($field, array $values, $group_by, $direction, $limit, $paginate = true, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();

        $this->model = $this->model->whereIn($field, $values)->orderBy($group_by, $direction);

        if ($paginate != true) {
            $results = $this->model->get($columns);
            $this->resetScope();
        } else {
            $limit   = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
            $results = $this->model->paginate($limit, $columns);
            $results->appends(app('request')->query());
        }

        $this->resetModel();

        return $this->parserResult($results);
    }

    public function findWhereAndPaginate(array $where, $group_by, $direction, $limit = null, $paginate = true, $columns = ['*'], $method = "paginate")
    {
        $this->applyConditions($where);

        if ($paginate != true) {
            if ($this->model instanceof Builder) {
                $results = $this->model->get($columns);
            } else {
                $results = $this->model->all($columns);
            }
            $this->resetScope();
        } else {

            $this->applyCriteria();
            $this->applyScope();

            $limit       = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
            $this->model = $this->model->orderBy($group_by, $direction);
            $results     = $this->model->{$method}($limit, $columns);
            $results->appends(app('request')->query());
        }

        $this->resetModel();
        return $this->parserResult($results);
    }

}
