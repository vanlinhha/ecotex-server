<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CategoryTypeCriteria.
 *
 * @package namespace App\Criteria;
 */
class CategoryTypeCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (trim($this->request->type) != '') {
            $model = $model->where('type', '=', $this->request->type);
        }

        if (trim($this->request->role_id) != '') {
            $model = $model->where('role_id', '=', $this->request->role_id);
        }

        if (trim($this->request->parent_id) != '') {
            $model = $model->where('parent_id', '=', $this->request->parent_id);
        }

        return $model;
    }
}
