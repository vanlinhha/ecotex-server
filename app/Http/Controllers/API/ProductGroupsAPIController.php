<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductGroupsAPIRequest;
use App\Http\Requests\API\UpdateProductGroupsAPIRequest;
use App\Models\ProductGroups;
use App\Repositories\ProductGroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProductGroupsController
 * @package App\Http\Controllers\API
 */

class ProductGroupsAPIController extends AppBaseController
{
    /** @var  ProductGroupsRepository */
    private $productGroupsRepository;

    public function __construct(ProductGroupsRepository $productGroupsRepo)
    {
        $this->productGroupsRepository = $productGroupsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/product_groups",
     *      summary="Get a listing of the ProductGroups.",
     *      tags={"ProductGroups"},
     *      description="Get all ProductGroups",
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
     *                  @SWG\Items(ref="#/definitions/ProductGroups")
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
        $this->productGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->productGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $productGroups = $this->productGroupsRepository->all();

        return $this->sendResponse($productGroups->toArray(), 'Product Groups retrieved successfully');
    }

    /**
     *
     * @return Response
     *
     * @SWG\Post(
     *      path="/product_groups",
     *      summary="Store a newly created ProductGroups in storage",
     *      tags={"ProductGroups"},
     *      description="Store ProductGroups",
     *      produces={"application/json"},
     *
     *      @SWG\Parameter(
     *          name="name",
     *          in="query",
     *          description="ProductGroups that should be stored",
     *          type="string",
     *          required=true
     *      ),
     *     @SWG\Parameter(
     *          name="parent_id",
     *          in="query",
     *          description="ProductGroups that should be stored",
     *          type="string",
     *          required=false
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
     *                  ref="#/definitions/ProductGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductGroupsAPIRequest $request)
    {
        $input = $request->all();

        $productGroups = $this->productGroupsRepository->create($input);

        return $this->sendResponse($productGroups->toArray(), 'Product Groups saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/product_groups/{id}",
     *      summary="Display the specified ProductGroups",
     *      tags={"ProductGroups"},
     *      description="Get ProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductGroups",
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
     *                  ref="#/definitions/ProductGroups"
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
        /** @var ProductGroups $productGroups */
        $productGroups = $this->productGroupsRepository->findWithoutFail($id);

        if (empty($productGroups)) {
            return $this->sendError('Product Groups not found');
        }

        return $this->sendResponse($productGroups->toArray(), 'Product Groups retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProductGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/product_groups/{id}",
     *      summary="Update the specified ProductGroups in storage",
     *      tags={"ProductGroups"},
     *      description="Update ProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductGroups",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductGroups that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductGroups")
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
     *                  ref="#/definitions/ProductGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductGroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductGroups $productGroups */
        $productGroups = $this->productGroupsRepository->findWithoutFail($id);

        if (empty($productGroups)) {
            return $this->sendError('Product Groups not found');
        }

        $productGroups = $this->productGroupsRepository->update($input, $id);

        return $this->sendResponse($productGroups->toArray(), 'ProductGroups updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/product_groups/{id}",
     *      summary="Remove the specified ProductGroups from storage",
     *      tags={"ProductGroups"},
     *      description="Delete ProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductGroups",
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
        /** @var ProductGroups $productGroups */
        $productGroups = $this->productGroupsRepository->findWithoutFail($id);

        if (empty($productGroups)) {
            return $this->sendError('Product Groups not found');
        }

        $productGroups->delete();

        return $this->sendResponse($id, 'Product Groups deleted successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/parent_product_groups",
     *      summary="Display the all parent ProductGroups",
     *      tags={"ProductGroups"},
     *      description="Get all parent ProductGroups",
     *      produces={"application/json"},
     *
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
     *                  ref="#/definitions/ProductGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function showParentProductGroups(Request $request)
    {
        $this->productGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->productGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $productGroups = $this->productGroupsRepository->findWhere([['parent_id', '=', 0]], ['*']);

        return $this->sendResponse($productGroups->toArray(), 'Product Groups retrieved successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/product_groups/{id}/children",
     *      summary="Display the specified ProductGroups",
     *      tags={"ProductGroups"},
     *      description="Get ProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductGroups",
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
     *                  ref="#/definitions/ProductGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getChildrenProductCategory($id)
    {
        $productGroups = $this->productGroupsRepository->findWhere([['parent_id', '=', $id]], ['*']);

        return $this->sendResponse($productGroups->toArray(), 'Product Groups retrieved successfully');
    }


}
