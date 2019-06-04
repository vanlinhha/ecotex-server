<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProductPostsAPIRequest;
use App\Http\Requests\API\UpdateProductPostsAPIRequest;
use App\Models\AttachedFiles;
use App\Models\AttachedImages;
use App\Models\ProductPosts;
use App\Repositories\ProductPostsRepository;
use App\Repositories\AttachedFilesRepository;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Intervention\Image\Image;
use Intervention\Image\ImageServiceProvider;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use JWTAuth;

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
        $this->productPostsRepository  = $productPostsRepo;
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
//        $this->productPostsRepository->pushCriteria(new RequestCriteria($request));
//        $this->productPostsRepository->pushCriteria(new LimitOffsetCriteria($request));

        $text_search   = $request->text_search ? $request->text_search : "";
        $list_post_IDS = $this->productPostsRepository->findWhere([['title', 'like', "%" . $text_search . "%"]])->pluck('id')->all();

        if(isset($request->type_id)){
            $type_IDs = json_decode($request->type_id);
            if (count($type_IDs)) {
                $post_IDs      = $this->productPostsRepository->findWhereIn('type_id', $type_IDs)->pluck('id')->all();
                $list_post_IDS = array_intersect($list_post_IDS, $post_IDs);
            }
        }

        if(isset($request->product_group_id)){
            $product_group_IDs = json_decode($request->product_group_id);
            if (count($product_group_IDs)) {
                $post_IDs2     = $this->productPostsRepository->findWhereIn('product_group_id', $product_group_IDs)->pluck('id')->all();
                $list_post_IDS = array_intersect($list_post_IDS, $post_IDs2);
            }
        }

        if(isset($request->creator)){
            if ($request->creator == "me") {
                $post_IDs3     = $this->productPostsRepository->findWhereIn('creator_id', [JWTAuth::parseToken()->authenticate()->id])->pluck('id')->all();
                $list_post_IDS = array_intersect($list_post_IDS, $post_IDs3);
            } elseif ($request->creator == "other") {
                $post_IDs4     = $this->productPostsRepository->findWhereNotIn('creator_id', [JWTAuth::parseToken()->authenticate()->id])->pluck('id')->all();
                $list_post_IDS = array_intersect($list_post_IDS, $post_IDs4);
            }
        }

        $limit     = is_null($request->limit) ? config('repository.pagination.limit', 10) : intval($request->limit);
        $order_by  = is_null($request->order_by) ? 'id' : $request->order_by;
        $direction = (is_null($request->direction) || $request->direction !== 'desc') ? 'asc' : $request->direction;

        $productPosts = $this->productPostsRepository->findWhereInAndPaginate('id', $list_post_IDS, $order_by, $direction, $limit, true, ['*']);

        foreach ($productPosts as $productPost) {
            $attachedFiles                 = $productPost->attachedFiles()->get();
            $productPost['attached_files'] = $attachedFiles;
            $attachedImages                = $productPost->attachedImages()->get();
            $productPost['images']         = $attachedImages;

            $productPost['creator'] = $productPost->creator()->select('id', 'first_name', 'last_name', 'company_name', 'avatar')->first();
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
    public function store(Request $request)
    {

        DB::beginTransaction();
        try{
            $input        = $request->all();
            $productPosts = $this->productPostsRepository->create($input);

            if (!is_dir(storage_path('app'))) {
                mkdir(storage_path('app'), 0777);
            }

            if (!is_dir(storage_path('app/public'))) {
                mkdir(storage_path('app/public'), 0777);

            }
            if (!is_dir(storage_path('app/public/files'))) {
                mkdir(storage_path('app/public/files'), 0777);
            }

            if (!is_dir(storage_path('app/public/images'))) {
                mkdir(storage_path('app/public/images'), 0777);
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $extension = $image->getClientOriginalName();
                    $filename  = uniqid() . '-' . $extension;
                    $image->move(storage_path('app/public/images'), $filename);

                    $productPosts->attachedImages()->create(['url' => '/storage/images/' . $filename, 'name' => $extension]);
                }
            }

            if ($request->hasFile('attached_files')) {
                foreach ($request->file('attached_files') as $file) {

                    $extension = $file->getClientOriginalName();
                    $filename  = uniqid() . '-' . $extension;
                    $file->move(storage_path('app/public/files'), $filename);

                    $productPosts->attachedFiles()->create(['url' => '/storage/files/' . $filename, 'name' => $extension]);
                }
            }
            DB::commit();
        }
        catch (\Exception $exception){
            DB::rollBack();
            $this->sendError(__("Can not create posts, please try again later!"), 500);
        }


        $attachedFiles                  = $productPosts->attachedFiles()->get();
        $productPosts['attached_files'] = $attachedFiles;
        $attachedImages                 = $productPosts->attachedImages()->get();
        $productPosts['images']         = $attachedImages;
        $productPosts['creator']        = $productPosts->creator()->select('first_name', 'last_name', 'company_name', 'avatar')->first();


        return $this->sendResponse($productPosts->toArray(), 'Product Posts saved successfully');


//        Storage::disk('local')->put('file.png', $input);

//        return Storage::url($url);
//
//        return Storage::disk('local')->get($path);
    }

    /**
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
            return $this->sendError(__('Product Posts not found'));
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
    public function update($id, Request $request)
    {

        /** @var ProductPosts $productPosts */
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            return $this->sendError(__('Product Posts not found'));
        }

        $input = $request->all();

        return $input;

        $productPosts = $this->productPostsRepository->update($input, $id);

//        $productPosts = $this->productPostsRepository->update($input, $id);

        DB::beginTransaction();
        try{


            if(isset($request->delete_images)){
                $delete_images = count($request->delete_images) ? $request->delete_images : [];
                if(count($delete_images)){
                    foreach ($productPosts->attachedImages()->get() as &$item) {
                        if(in_array($item['id'], $delete_images )){
                            unlink(substr($item['url'], 1));
//                            $item->delete();
                            AttachedImages::find($item['id'])->delete();
                        }
                    }
                }
            }

            if(isset($request->delete_files)){
                $delete_files = count($request->delete_files) ? $request->delete_files : [];
                if(count($delete_files)){
                    foreach ($productPosts->attachedFiles()->get() as &$item) {
                        if(in_array($item['id'], $delete_files )){
                            unlink(substr($item['url'], 1));
//                            $item->delete();
                            AttachedFiles::find($item['id'])->delete();
                        }
                    }

                }

            }

//            $productPosts->attachedFiles()->delete();
//            $productPosts->attachedImages()->delete();

            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $extension = $image->getClientOriginalName();
                    $filename  = uniqid() . '-' . $extension;
                    $image->move(storage_path('app/public/images'), $filename);

                    $productPosts->attachedImages()->create(['url' => '/storage/images/' . $filename, 'name' => $extension]);
                }
            }

            if ($request->hasFile('new_files')) {
                foreach ($request->file('new_files') as $file) {

                    $extension = $file->getClientOriginalName();
                    $filename  = uniqid() . '-' . $extension;
                    $file->move(storage_path('app/public/files'), $filename);

                    $productPosts->attachedFiles()->create(['url' => '/storage/files/' . $filename, 'name' => $extension]);
                }
            }
            DB::commit();
        }
        catch (\Exception $exception){
            DB::rollBack();
            $this->sendError(__("Can not update posts, please try again later!"), 500);
        }


        $attachedFiles                  = $productPosts->attachedFiles()->get();
        $productPosts['attached_files'] = $attachedFiles;
        $attachedImages                 = $productPosts->attachedImages()->get();
        $productPosts['images']         = $attachedImages;
        $productPosts['creator']        = $productPosts->creator()->select('first_name', 'last_name', 'company_name', 'avatar')->first();

        return $this->sendResponse($productPosts->toArray(), 'ProductPosts updated successfully');
    }

    /**
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
            return $this->sendError(__('Product Posts not found'));
        }

        foreach ($productPosts->attachedFiles()->get() as $item) {
            unlink(substr($item['url'], 1));
        }
        foreach ($productPosts->attachedImages() as $item) {
            unlink(substr($item['url'], 1));
        }

        $productPosts->attachedFiles()->delete();
        $productPosts->attachedImages()->delete();

        $productPosts->delete();

        return $this->sendResponse($id, 'Product Posts deleted successfully');
    }

    /**
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
        foreach ($productPosts as $productPost) {
            $attachedFiles                 = $productPost->attachedFiles()->get();
            $productPost['attached_files'] = $attachedFiles;
            $attachedImages                = $productPost->attachedImages()->get();
            $productPost['images']         = $attachedImages;
            $productPost['creator']        = $productPost->creator()->select('id', 'first_name', 'last_name', 'company_name', 'avatar')->first();
        }

        return $this->sendResponse($productPosts->toArray(), 'Product Posts retrieved successfully');
    }
}
