<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductPostsAPIRequest;
use App\Http\Requests\API\UpdateProductPostsAPIRequest;
use App\Models\ProductPosts;
use App\Repositories\ProductPostsRepository;
use App\Repositories\AttachedFilesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Intervention\Image\Image;
use Intervention\Image\ImageServiceProvider;
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
    private $attachedFilesRepository;

    public function __construct(ProductPostsRepository $productPostsRepo, AttachedFilesRepository $attachedFilesRepo)
    {
        $this->productPostsRepository = $productPostsRepo;
        $this->attachedFilesRepository = $attachedFilesRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/product_posts",
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
        foreach ($productPosts as $productPost){
            $attachedFiles = $productPost->attachedFiles()->get();
            $productPost['attached_files'] = $attachedFiles;
            $attachedImages = $productPost->attachedImages()->get();
            $productPost['images'] = $attachedImages;
        }

        return $this->sendResponse($productPosts->toArray(), 'Product Posts retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/product_posts",
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
        foreach ($request->images as $image) {
            $base64 = $image['base64'];
            $png_url = "photo-" . time() . ".png";
            $path = storage_path('app\\public\\img') . $png_url;
            \Image::make($base64)->save($path);
            $productPosts->attachedImages()->create(['url' => env('APP_URL') . Storage::disk('local')->url($png_url), 'name' => $image['name'], 'type' => 1]);
        }

//        foreach ($request->attach_files as $file) {
//            $base64 = $image['base64'];
//            $png_url = "photo-" . time() . ".png";
//            $path = storage_path('app\\public\\img') . $png_url;
//            \Image::make($base64)->save($path);
//            $productPosts->attachedImages()->create(['url' => env('APP_URL') . Storage::disk('local')->url($png_url), 'name' => $image['name'], 'type' => 1]);
//        }

        $attachedFiles = $productPosts->attachedFiles()->get();
        $productPosts['attached_files'] = $attachedFiles;
        $attachedImages = $productPosts->attachedImages()->get();
        $productPosts['images'] = $attachedImages;

        return $this->sendResponse($productPosts->toArray(), 'Product Posts saved successfully');


//        Storage::disk('local')->put('file.png', $input);

//        return Storage::url($png_url);
//
//        return Storage::disk('local')->get($path);
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/product_posts/{id}",
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
     *
     * @SWG\Put(
     *      path="/product_posts/{id}",
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
     *      path="/product_posts/{id}",
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

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/product_posts/get_own_posts/{user_id}",
     *      summary="Display the specified ProductPosts",
     *      tags={"ProductPosts"},
     *      description="Get ProductPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="user_id",
     *          description="id of user",
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
    public function getOwnPosts($user_id)
    {
        /** @var ProductPosts $productPosts */
        $productPosts = $this->productPostsRepository->findWhere(['creator_id' => $user_id]);
        foreach ($productPosts as $productPost){
            $attachedFiles = $productPost->attachedFiles()->get();
            $productPost['attached_files'] = $attachedFiles;
            $attachedImages = $productPost->attachedImages()->get();
            $productPost['images'] = $attachedImages;
        }

        return $this->sendResponse($productPosts->toArray(), 'Product Posts retrieved successfully');
    }
}
