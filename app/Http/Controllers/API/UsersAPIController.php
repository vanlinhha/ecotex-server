<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsersAPIRequest;
use App\Http\Requests\API\UpdateUsersAPIRequest;
use App\Models\Users;
use App\Repositories\CategoryRepository;
use App\Repositories\MainCategoryRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Mail;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use JWTAuth;

/**
 * Class UsersController
 * @package App\Http\Controllers\API
 */
class UsersAPIController extends AppBaseController
{
    /** @var  UsersRepository */
    private $usersRepository;
    protected $user;

    private $categoryRepository;
    private $mainCategoryRepository;

//    protected $type;

    public function __construct(UsersRepository $usersRepo, CategoryRepository $categoryRepository, MainCategoryRepository $mainCategoryRepo)
    {
        $this->usersRepository = $usersRepo;
        $this->categoryRepository = $categoryRepository;
        $this->mainCategoryRepository = $mainCategoryRepo;
    }

    static function makeInstance(UsersRepository $usersRepo, CategoryRepository $categoryRepository, MainCategoryRepository $mainCategoryRepo)
    {
        return new self($usersRepo, $categoryRepository, $mainCategoryRepo);
    }

    /**
     *
     * @SWG\Get(
     *      path="/users",
     *      summary="Get a listing of activated Users.",
     *      tags={"Users"},
     *      description="Get all Users",
     *      produces={"application/json"},
     *
     *     @SWG\Parameter(
     *          name="text_search",
     *          type="string",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="main_product_groups[]",
     *          type="array",
     *          required=false,
     *          in="query",
     *          @SWG\Items(
     *             type="integer",
     *         ),
     *         collectionFormat="multi"
     *      ),
     *
     *     @SWG\Parameter(
     *          name="main_target_groups[]",
     *          type="array",
     *          required=false,
     *          in="query",
     *          @SWG\Items(
     *             type="integer",
     *         ),
     *         collectionFormat="multi"
     *      ),
     *
     *     @SWG\Parameter(
     *          name="main_segment_groups[]",
     *          type="array",
     *          required=false,
     *          in="query",
     *          @SWG\Items(
     *             type="integer",
     *         ),
     *         collectionFormat="multi"
     *      ),
     *
     *     @SWG\Parameter(
     *          name="roles[]",
     *          type="array",
     *          required=false,
     *          in="query",
     *          @SWG\Items(
     *             type="integer",
     *         ),
     *         collectionFormat="multi"
     *      ),
     *
     *     @SWG\Parameter(
     *          name="limit",
     *          type="integer",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="page",
     *          type="integer",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="order_by",
     *          type="string",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="direction",
     *          type="string",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="paginate",
     *          type="boolean",
     *          required=false,
     *          in="query",
     *      ),
     *
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
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Users")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request, MainCategoryRepository $mainCategoryRepo)
    {
//        $this->usersRepository->pushCriteria(new RequestCriteria($request));
//        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));

        if (isset($request->paginate)) {
            $paginate = $request->paginate == false || $request->paginate == 'false' ? false : true;
        } else {
            $paginate = true;
        }

        $text_search = $request->text_search ? $request->text_search : "";
        if (trim($text_search)) {
            $list_user_IDs_1 = $this->usersRepository->findWhere([['company_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 1]])->pluck('id')->all();
            $list_user_IDs_2 = $this->usersRepository->findWhere([['first_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 1]])->pluck('id')->all();
            $list_user_IDs_3 = $this->usersRepository->findWhere([['last_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 1]])->pluck('id')->all();
            $list_user_IDs_4 = $this->usersRepository->findWhere([['email', 'like', "%" . $text_search . "%"], ['is_activated', '=', 1]])->pluck('id')->all();
            $list_user_IDs = array_merge($list_user_IDs_1, $list_user_IDs_2, $list_user_IDs_3, $list_user_IDs_4);

        } else {
            $list_user_IDs = $this->usersRepository->findWhere([['is_activated', '=', 1]])->pluck('id')->all();

        }

        if (isset($request->main_product_groups)) {
            $main_product_group_IDs = json_decode($request->main_product_groups);
            if (count($main_product_group_IDs)) {
                $user_IDs = $mainCategoryRepo->findWhereIn('category_id', $main_product_group_IDs)->pluck('user_id')->all();
                $list_user_IDs = array_intersect($list_user_IDs, $user_IDs);
            }
        }

        if (isset($request->main_target_groups)) {
            $main_target_group_IDs = json_decode($request->main_target_groups);
            if (count($main_target_group_IDs)) {
                $user_IDs2 = $mainCategoryRepo->findWhereIn('category_id', $main_target_group_IDs, ['user_id'])->pluck('user_id')->all();
                $list_user_IDs = array_intersect($list_user_IDs, $user_IDs2);
            }
        }

        if (isset($request->main_segment_groups)) {
            $main_segment_group_IDs = json_decode($request->main_segment_groups);
            if (count($main_segment_group_IDs)) {
                $user_IDs3 = $mainCategoryRepo->findWhereIn('category_id', $main_segment_group_IDs, ['user_id'])->pluck('user_id')->all();
                $list_user_IDs = array_intersect($list_user_IDs, $user_IDs3);
            }
        }

        if (isset($request->main_services)) {
            $main_sercvice_IDs = json_decode($request->main_services);
            if (count($main_sercvice_IDs)) {
                $user_IDs4 = $mainCategoryRepo->findWhereIn('category_id', $main_sercvice_IDs, ['user_id'])->pluck('user_id')->all();
                $list_user_IDs = array_intersect($list_user_IDs, $user_IDs4);
            }
        }

        $limit = isset($request->limit) ? intval($request->limit) : 5;
        $order_by = isset($request->order_by) ? $request->order_by : 'id';
        $direction = (isset($request->direction) || $request->direction !== 'desc') ? 'asc' : $request->direction;

        $users = $this->usersRepository->findWhereInAndPaginate('id', $list_user_IDs, $order_by, $direction, $limit, $paginate, ['*']);

        foreach ($users as $user) {
            $this->getInfo($user);
        }
        return $this->sendResponse($users, 'Users retrieved successfully');
    }

    /**
     * @SWG\Post(
     *      path="/users",
     *      summary="Store a newly created Users in storage",
     *      tags={"Users"},
     *      description="Store Users",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Users that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
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
     *                  ref="#/definitions/Users"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */

    public function getMainCategoryByType($mainCategories = array(), $type = "")
    {
        if (trim($type) == "") {
            return $mainCategories;
        }

        $temp = [];
        foreach ($mainCategories as $item) {
            $category_type = $this->categoryRepository->findWithoutFail(intval($item['category_id']))['type'];
            if ($category_type == $type) {
                $temp[] = $item;
            }
        }
        return $temp;
    }

    public function getInfo(&$user)
    {
        $locations           = $user->locations()->get();
        $role_type_ids       = $user->roleTypes()->pluck('role_type_id');
        $role                = $user->roles()->first();
        $bookmarks           = $user->bookmarks()->get();

        $mainCategories = $user->categories()->get();
        foreach ($this->mainType as $type => $mainType) {
            if (trim($mainType) != 'minimum_order_quantity') {
                $user[$mainType] = $this->getMainCategoryByType($mainCategories, $type);
            }
        }
        $user['role_type_ids']         = $role_type_ids;
        $user['role']                  = $role;
        $user['bookmarks']             = $bookmarks;
        $user['locations']             = $locations;
    }

    public function getProductsOfUser(&$user)
    {
        $products = $user->products()->get();
        foreach ($products as $product) {
            $productImages = $product->productImages()->get();
            $product['images'] = $productImages;
        }
        return $products;
    }

    public function store(CreateUsersAPIRequest $request)
    {
        $input = $request->all();
        $users = $this->usersRepository->create($input);
        return $this->sendResponse($users->toArray(), 'Users saved successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/users/{id}",
     *      summary="Display the specified Users",
     *      tags={"Users"},
     *      description="Get Users",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Users",
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
     *                  ref="#/definitions/Users"
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
        /** @var Users $users */
        $user = $this->usersRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError(__('User not found'), 404);
        }
        $this->getInfo($user);

        return $this->sendResponse($user->toArray(), 'Users retrieved successfully');
    }


    /**
     *
     * @SWG\Put(
     *      path="/users/{id}",
     *      summary="Update the specified Users in storage",
     *      tags={"Users"},
     *      description="Update Users",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Users",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
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
     *                  ref="#/definitions/Services"
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

        /** @var Users $user */
        $user = $this->usersRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError(__('User not found'), 404);
        }
        if (trim($input['password']) != '') {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }

        $this->usersRepository->update($input, $id);

        $user = $this->usersRepository->findWithoutFail($id);

        if (empty($user)) {
            return $this->sendError(__('User not found'), 404);
        }

        if(isset($request->main_categories)){
            foreach ($request->main_categories as $item) {
                if(!isset($item['id'])){
                    $item['id'] = null;
                }
                if(!isset($item['_destroy'])){
                    $item['_destroy'] = false;
                }
                if (($item['id'] == 'null' || $item['id'] == null) && $item['_destroy'] == true) {
                    continue;
                }
                if ($item['id'] == 'null' || $item['id'] == null) {
                    $this->mainCategoryRepository->create($item);
                } elseif (isset($item['_destroy']) && ($item['_destroy'] == true)) {
                    $mainCategories = $this->mainCategoryRepository->findWithoutFail($item['id']);
                    if (empty($mainCategories)) {
                        return $this->sendError(__('Main category not found'));
                    }
                    $mainCategories->delete();
                } else {
                    $this->mainCategoryRepository->update($item, $item['id']);
                }
            }
        }

        $this->getInfo($user);

        return $this->sendResponse($user->toArray(), 'Users updated successfully');
    }

    public function updateMainCategories($id, Request $request)
    {
        foreach ($request->main_categories as $item) {
            if(!isset($item['id'])){
                $item['id'] = null;
            }
            if(!isset($item['_destroy'])){
                $item['_destroy'] = false;
            }
            if (($item['id'] == 'null' || $item['id'] == null) && $item['_destroy'] == true) {
                continue;
            }
            if ($item['id'] == 'null' || $item['id'] == null) {
                $this->mainCategoryRepository->create($item);
            } elseif (isset($item['_destroy']) && ($item['_destroy'] == true)) {
                $mainCategories = $this->mainCategoryRepository->findWithoutFail($item['id']);
                if (empty($mainCategories)) {
                    return $this->sendError(__('Main category not found'));
                }
                $mainCategories->delete();
            } else {
                $this->mainCategoryRepository->update($item, $item['id']);
            }
        }
        $mainCategories = $this->mainCategoryRepository->findWhere(['user_id' => $id, 'deleted_at' => NULL]);
        //        $mainCategories = Users::find($id)->categories()->get(['*']);
        return $this->sendResponse($mainCategories, 'Main category updated successfully');
    }


    /**
     *
     * @SWG\Delete(
     *      path="/users/{id}",
     *      summary="Remove the specified Users from storage",
     *      tags={"Users"},
     *      description="Delete Users",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Users",
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
        /** @var Users $users */
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            return $this->sendError(__('User not found'), 404);
        }

        $users->delete();

        return $this->sendResponse($id, 'Users deleted successfully');
    }

    public function showMainProductGroup($id)
    {
        /** @var Users $users */
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            return $this->sendError(__('User not found'), 404);
        }

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/inactivated_users",
     *      summary="Get a listing of the inactivated Users.",
     *      tags={"Users"},
     *      description="Get all Users",
     *      produces={"application/json"},
     *
     *     @SWG\Parameter(
     *          name="limit",
     *          type="integer",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="page",
     *          type="integer",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="order_by",
     *          type="string",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="direction",
     *          type="string",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="paginate",
     *          type="boolean",
     *          required=false,
     *          in="query",
     *      ),
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
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Users")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getInactivatedUser(Request $request)
    {
        if (isset($request->paginate)) {
            $paginate = $request->paginate == false || $request->paginate == 'false' ? false : true;
        } else {
            $paginate = true;
        }

        $limit = is_null($request->limit) ? config('repository.pagination.limit', 10) : intval($request->limit);
        $order_by = is_null($request->order_by) ? 'id' : $request->order_by;
        $direction = is_null($request->direction) ? 'asc' : $request->direction;

//        $this->usersRepository->pushCriteria(new RequestCriteria($request));
//        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));
        $text_search = $request->text_search ? $request->text_search : "";
        if (trim($text_search)) {
//            $list_user_IDs = $this->usersRepository->findWhere([['company_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 0]])->pluck('id')->all();
            $list_user_IDs_1 = $this->usersRepository->findWhere([['company_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 0]])->pluck('id')->all();
            $list_user_IDs_2 = $this->usersRepository->findWhere([['first_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 0]])->pluck('id')->all();
            $list_user_IDs_3 = $this->usersRepository->findWhere([['last_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 0]])->pluck('id')->all();
            $list_user_IDs_4 = $this->usersRepository->findWhere([['email', 'like', "%" . $text_search . "%"], ['is_activated', '=', 0]])->pluck('id')->all();
            $list_user_IDs = array_merge($list_user_IDs_1, $list_user_IDs_2, $list_user_IDs_3, $list_user_IDs_4);
        } else {
            $list_user_IDs = $this->usersRepository->findWhere([['is_activated', '=', 0]])->pluck('id')->all();

        }

        $users = $this->usersRepository->findWhereInAndPaginate('id', $list_user_IDs, $order_by, $direction, $limit, $paginate, ['*']);

        foreach ($users as $user) {
            $this->getInfo($user);
        }

        return $this->sendResponse($users->toArray(), 'Inactivated users retrieved successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/all_users",
     *      summary="Get a listing of all Users.",
     *      tags={"Users"},
     *      description="Get all Users",
     *      produces={"application/json"},
     *
     *     @SWG\Parameter(
     *          name="limit",
     *          type="integer",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="page",
     *          type="integer",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="order_by",
     *          type="string",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="direction",
     *          type="string",
     *          required=false,
     *          in="query",
     *      ),
     *
     *     @SWG\Parameter(
     *          name="paginate",
     *          type="boolean",
     *          required=false,
     *          in="query",
     *      ),
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
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Users")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getAllUser(Request $request)
    {
        $limit = is_null($request->limit) ? config('repository.pagination.limit', 10) : intval($request->limit);
        $order_by = is_null($request->order_by) ? 'id' : $request->order_by;
        $direction = is_null($request->direction) ? 'asc' : $request->direction;

        if (isset($request->paginate)) {
            $paginate = $request->paginate == false || $request->paginate == 'false' ? false : true;
        } else {
            $paginate = true;
        }

//        $this->usersRepository->pushCriteria(new RequestCriteria($request));
//        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));
        $users = $this->usersRepository->findWhereAndPaginate([], $order_by, $direction, $limit, $paginate, ['*']);

        foreach ($users as $user) {
            $this->getInfo($user);
        }

        return $this->sendResponse($users->toArray(), 'Inactivated users retrieved successfully');
    }

    public function verifyUsers(Request $request)
    {
        $user_ids = json_decode($request->user_ids);
        if (count($user_ids)) {
            foreach ($user_ids as $user_id) {
                $this->usersRepository->update(['is_activated' => 1], $user_id);
            }
            return $this->sendResponse($user_ids, 'Users verified successfully!');
        } else {
            return $this->sendError(__('User not found'), 404);
        }
    }

    public function verify(Request $request)
    {
        $user = $this->usersRepository->findWithoutFail($request->user_id);
        if (!$user) {
            return $this->sendError(__('User not found'), 404);
        }
        if (trim($user->activation_code) == "") {
            return $this->sendError(__('Users already activated!'), 403);
        }
        if (trim($user->activation_code) === trim($request->activation_code)) {
            $this->usersRepository->update(['activation_code' => ""], $request->user_id);
            return $this->sendResponse($request->user_id, 'Users activated successfully!');
        } else {
            return $this->sendError(__('Users activated unsuccessfully!'), 500);
        }

    }

    public function resendActivationCode(Request $request)
    {
        $user = $this->usersRepository->findWithoutFail($request->user_id);
    }

    public function uploadAvatar(Request $request)
    {
        if (!is_dir(storage_path('app'))) {
            mkdir(storage_path('app'), 0777);
        }

        if (!is_dir(storage_path('app/public'))) {
            mkdir(storage_path('app/public'), 0777);

        }
        if (!is_dir(storage_path('app/public/avatars/'))) {
            mkdir(storage_path('app/public/avatars'), 0777);
        }

        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->getClientOriginalName();
            $filename = uniqid() . '-' . $extension;
            $request->file('avatar')->move(storage_path('app/public/avatars'), $filename);
            $user = $this->usersRepository->update(['avatar' => '/storage/avatars/' . $filename], JWTAuth::parseToken()->authenticate()->id);
        }
        return $this->sendResponse($user->toArray(), 'User avatar updated successfully');

    }

    public function forgotPassword(Request $request)
    {
        if (isset($request->email)) {
            $user = $this->usersRepository->findWhere([['email', '=', $request->email], ['is_activated', '=', 1]]);
            if (!$user) {
                return $this->sendError('User not found', 404);
            }
            $this->user = $user;
            Mail::raw(__("Please click on this link to reset your password, ") .
                env('APP_CLIENT_BASE_PATH') . '/forgot/' . $this->user->id, function ($mail) {
                $mail->to($this->user->email)
                    ->from('support@ecotexvietnam.com', 'Ecotex')
                    ->subject(__("Ecotex: Reset your password "));
            });
            return response()->json(['success' => true, 'data' => [], 'message' => "Sent email successfully"], 200);
        }
    }

    public function resetPassword(Request $request)
    {
        $input = $request->only(['id, password']);
        $user = $this->usersRepository->findWithoutFail($input['id']);

        if (empty($user)) {
            return $this->sendError(__('User not found'), 404);
        }
        if (trim($input['password']) != '') {
            $input['password'] = bcrypt($input['password']);
        }
        $this->usersRepository->update($input, $user->id);

        return response()->json(['success' => true, 'data' => [], 'message' => "Reset password successfully"], 200);
    }

}
