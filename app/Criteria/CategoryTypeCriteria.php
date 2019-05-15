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

        return $model;
    }
}
