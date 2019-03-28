<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductsAPIRequest;
use App\Http\Requests\API\UpdateProductsAPIRequest;
use App\Models\Products;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ProductsController
 * @package App\Http\Controllers\API
 */

class ProductsAPIController extends AppBaseController
{
    /** @var  ProductsRepository */
    private $productsRepository;

    public function __construct(ProductsRepository $productsRepo)
    {
        $this->productsRepository = $productsRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/products",
     *      summary="Get a listing of the Products.",
     *      tags={"Products"},
     *      description="Get all Products",
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
     *                  @SWG\Items(ref="#/definitions/Products")
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
        $this->productsRepository->pushCriteria(new RequestCriteria($request));
        $this->productsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $products = $this->productsRepository->all();

        foreach ($products as $product) {
            $productImages = $product->productImages()->get();
            $product['images'] = $productImages;
        }

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/products",
     *      summary="Store a newly created Products in storage",
     *      tags={"Products"},
     *      description="Store Products",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Products that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Products")
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
     *                  ref="#/definitions/Products"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateProductsAPIRequest $request)
    {
        $input = $request->all();

        $products = $this->productsRepository->create($input);

        if (!is_dir(storage_path('app'))) {
            mkdir(storage_path('app'), 0777);
        }

        if (!is_dir(storage_path('app/public'))) {
            mkdir(storage_path('app/public'), 0777);

        }
        if (!is_dir(storage_path('app/public/product_images'))) {
            mkdir(storage_path('app/public/product_images'), 0777);
        }

        if($request->hasFile('images')){
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalName();
                $filename = uniqid() . '-' . $extension;
                $image->move(storage_path('app/public/product_images'), $filename);

                $products->productImages()->create(['url' => '/storage/product_images/' . $filename, 'name' => $extension]);
            }
        }

        $productImages = $products->productImages()->get();
        $products['images'] = $productImages;

        return $this->sendResponse($products->toArray(), 'Products saved successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/products/{id}",
     *      summary="Display the specified Products",
     *      tags={"Products"},
     *      description="Get Products",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Products",
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
     *                  ref="#/definitions/Products"
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
        /** @var Products $products */
        $products = $this->productsRepository->findWithoutFail($id);

        if (empty($products)) {
            return $this->sendError('Products not found');
        }
        $productImages = $products->productImages()->get();
        $products['images'] = $productImages;

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }

    /**
     *
     * @SWG\Put(
     *      path="/products/{id}",
     *      summary="Update the specified Products in storage",
     *      tags={"Products"},
     *      description="Update Products",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Products",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Products that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Products")
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
     *                  ref="#/definitions/Products"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateProductsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Products $products */
        $products = $this->productsRepository->findWithoutFail($id);

        if (empty($products)) {
            return $this->sendError('Products not found');
        }

        $products = $this->productsRepository->update($input, $id);

        $productImages = $products->productImages()->get();
        $products['images'] = $productImages;

        return $this->sendResponse($products->toArray(), 'Products updated successfully');
    }

    /**
     *
     * @SWG\Delete(
     *      path="/products/{id}",
     *      summary="Remove the specified Products from storage",
     *      tags={"Products"},
     *      description="Delete Products",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Products",
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
        /** @var Products $products */
        $products = $this->productsRepository->findWithoutFail($id);

        if (empty($products)) {
            return $this->sendError('Products not found');
        }

        $products->delete();

        return $this->sendResponse($id, 'Products deleted successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/product_user/{user_id}",
     *      summary="Display the specified Products",
     *      tags={"Products"},
     *      description="Get Products",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="user_id",
     *          description="id of User",
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
     *                  ref="#/definitions/Products"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function product_user($user_id)
    {
        /** @var Products $products */
        $products = $this->productsRepository->findWhere(['user_id' => $user_id]);

        if (empty($products)) {
            return $this->sendError('Products not found');
        }

        foreach ($products as $product) {
            $productImages = $product->productImages()->get();
            $product['images'] = $productImages;
        }

        return $this->sendResponse($products->toArray(), 'Products retrieved successfully');
    }
}
