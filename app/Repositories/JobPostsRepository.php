<?php

namespace App\Repositories;

use App\Models\JobPosts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class JobPostsRepository
 * @package App\Repositories
 * @version June 2, 2019, 2:36 pm ICT
 *
 * @method JobPosts findWithoutFail($id, $columns = ['*'])
 * @method JobPosts find($id, $columns = ['*'])
 * @method JobPosts first($columns = ['*'])
*/
class JobPostsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'creator_id',
        'title',
        'division',
        'amount',
        'salary',
        'welfare',
        'position',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return JobPosts::class;
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
}
