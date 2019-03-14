<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductPostsAPIRequest;
use App\Http\Requests\API\UpdateProductPostsAPIRequest;
use App\Models\ProductPosts;
use App\Repositories\ProductPostsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProductPostsController
 * @package App\Http\Controllers\API
 */

class ProductPostsAPIController extends AppBaseController
{
    /** @var  ProductPostsRepository */
    private $productPostsRepository;

    public function __construct(ProductPostsRepository $productPostsRepo)
    {
        $this->productPostsRepository = $productPostsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/productPosts",
     *      summary="Get a listing of the ProductPosts.",
     *      tags={"ProductPosts"},
     *      description="Get all ProductPosts",
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
     *                  @SWG\Items(ref="#/definitions/ProductPosts")
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
        $this->productPostsRepository->pushCriteria(new RequestCriteria($request));
        $this->productPostsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $productPosts = $this->productPostsRepository->all();

        return $this->sendResponse($productPosts->toArray(), 'Product Posts retrieved successfully');
    }

    /**
     * @param CreateProductPostsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/productPosts",
     *      summary="Store a newly created ProductPosts in storage",
     *      tags={"ProductPosts"},
     *      description="Store ProductPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductPosts that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductPosts")
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
     *                  ref="#/definitions/ProductPosts"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductPostsAPIRequest $request)
    {
        $input = $request->all();

        $productPosts = $this->productPostsRepository->create($input);

        return $this->sendResponse($productPosts->toArray(), 'Product Posts saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/productPosts/{id}",
     *      summary="Display the specified ProductPosts",
     *      tags={"ProductPosts"},
     *      description="Get ProductPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductPosts",
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
     *                  ref="#/definitions/ProductPosts"
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
        /** @var ProductPosts $productPosts */
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            return $this->sendError('Product Posts not found');
        }

        return $this->sendResponse($productPosts->toArray(), 'Product Posts retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateProductPostsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/productPosts/{id}",
     *      summary="Update the specified ProductPosts in storage",
     *      tags={"ProductPosts"},
     *      description="Update ProductPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductPosts",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ProductPosts that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ProductPosts")
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
     *                  ref="#/definitions/ProductPosts"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductPostsAPIRequest $request)
    {
        $input = $request->all();

        /** @var ProductPosts $productPosts */
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            return $this->sendError('Product Posts not found');
        }

        $productPosts = $this->productPostsRepository->update($input, $id);

        return $this->sendResponse($productPosts->toArray(), 'ProductPosts updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/productPosts/{id}",
     *      summary="Remove the specified ProductPosts from storage",
     *      tags={"ProductPosts"},
     *      description="Delete ProductPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ProductPosts",
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
        /** @var ProductPosts $productPosts */
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            return $this->sendError('Product Posts not found');
        }

        $productPosts->delete();

        return $this->sendResponse($id, 'Product Posts deleted successfully');
    }
}
