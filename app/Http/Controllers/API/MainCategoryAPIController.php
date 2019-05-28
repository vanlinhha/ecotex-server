<?php

namespace App\Http\Controllers\API;

use App\Criteria\CategoryTypeCriteria;
use App\Http\Requests\API\CreateMainCategoryAPIRequest;
use App\Http\Requests\API\UpdateMainCategoryAPIRequest;
use App\Models\MainCategory;
use App\Repositories\MainCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainCategoryController
 * @package App\Http\Controllers\API
 */

class MainCategoryAPIController extends AppBaseController
{
    /** @var  MainCategoryRepository */
    private $mainCategoryRepository;

    public function __construct(MainCategoryRepository $mainCategoryRepo)
    {
        $this->mainCategoryRepository = $mainCategoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/mainCategories",
     *      summary="Get a listing of the MainCategories.",
     *      tags={"MainCategory"},
     *      description="Get all MainCategories",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/MainCategory")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->mainCategoryRepository->pushCriteria(new RequestCriteria($request));
        $this->mainCategoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainCategories = $this->mainCategoryRepository->all();

        return $this->sendResponse($mainCategories->toArray(), 'Main Categories retrieved successfully');
    }

    /**
     * @param CreateMainCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/mainCategories",
     *      summary="Store a newly created MainCategory in storage",
     *      tags={"MainCategory"},
     *      description="Store MainCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainCategory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainCategory")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/MainCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $mainCategories = $this->mainCategoryRepository->create($input);

        return $this->sendResponse($mainCategories->toArray(), 'Main Category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/mainCategories/{id}",
     *      summary="Display the specified MainCategory",
     *      tags={"MainCategory"},
     *      description="Get MainCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/MainCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var MainCategory $mainCategory */
        $mainCategory = $this->mainCategoryRepository->findWithoutFail($id);

        if (empty($mainCategory)) {
            return $this->sendError('Main Category not found');
        }

        return $this->sendResponse($mainCategory->toArray(), 'Main Category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMainCategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/mainCategories/{id}",
     *      summary="Update the specified MainCategory in storage",
     *      tags={"MainCategory"},
     *      description="Update MainCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainCategory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainCategory")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/MainCategory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var MainCategory $mainCategory */
        $mainCategory = $this->mainCategoryRepository->findWithoutFail($id);

        if (empty($mainCategory)) {
            return $this->sendError('Main Category not found');
        }

        $mainCategory = $this->mainCategoryRepository->update($input, $id);

        return $this->sendResponse($mainCategory->toArray(), 'MainCategory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/mainCategories/{id}",
     *      summary="Remove the specified MainCategory from storage",
     *      tags={"MainCategory"},
     *      description="Delete MainCategory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainCategory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var MainCategory $mainCategory */
        $mainCategory = $this->mainCategoryRepository->findWithoutFail($id);

        if (empty($mainCategory)) {
            return $this->sendError('Main Category not found');
        }

        $mainCategory->delete();

        return $this->sendResponse($id, 'Main Category deleted successfully');
    }
}
