<?php

namespace App\Repositories;

use App\Models\ProductPosts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProductPostsRepository
 * @package App\Repositories
 * @version March 19, 2019, 10:50 am ICT
 *
 * @method ProductPosts findWithoutFail($id, $columns = ['*'])
 * @method ProductPosts find($id, $columns = ['*'])
 * @method ProductPosts first($columns = ['*'])
*/
class ProductPostsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'product_group_id',
        'quantity',
        'target_price',
        'specification',
        'type_id',
        'incoterm',
        'creator_id',
        'title'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductPosts::class;
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
