<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsersAPIRequest;
use App\Http\Requests\API\UpdateUsersAPIRequest;
use App\Models\Users;
use App\Repositories\MainProductGroupsRepository;
use App\Repositories\MainSegmentsRepository;
use App\Repositories\MainTargetsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Response;

/**
 * Class UsersController
 * @package App\Http\Controllers\API
 */
class UsersAPIController extends AppBaseController
{
    /** @var  UsersRepository */
    private $usersRepository;

    public function __construct(UsersRepository $usersRepo)
    {
        $this->usersRepository = $usersRepo;
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
    public function index(Request $request, MainProductGroupsRepository $mainProductGroupsRepository, MainTargetsRepository $mainTargetsRepository, MainSegmentsRepository $mainSegmentsRepository)
    {
//        $this->usersRepository->pushCriteria(new RequestCriteria($request));
//        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));

        if (isset($request->paginate)) {
            $paginate = $request->paginate == false || $request->paginate == 'false' ? false : true;
        } else {
            $paginate = true;
        }

        $text_search   = $request->text_search ? $request->text_search : "";
        $list_user_IDs = $this->usersRepository->findWhere([['company_name', 'like', "%" . $text_search . "%"], ['is_activated', '=', 1]])->pluck('id')->all();

        if (isset($request->main_product_groups) && $request->main_product_groups[0] != null) {
            $main_product_group_IDs = array_map('intval', $request->main_product_groups);
            $user_IDs               = $mainProductGroupsRepository->findWhereIn('product_group_id', $main_product_group_IDs)->pluck('user_id')->all();
            $list_user_IDs          = array_intersect($list_user_IDs, $user_IDs);
        }

        if (isset($request->main_target_groups) && $request->main_target_groups[0] != null) {
            $main_target_group_IDs = array_map('intval', $request->main_target_groups);
            $user_IDs2             = $mainTargetsRepository->findWhereIn('target_group_id', $main_target_group_IDs, ['user_id'])->pluck('user_id')->all();
            $list_user_IDs         = array_intersect($list_user_IDs, $user_IDs2);
        }

        if (isset($request->main_segment_groups) && $request->main_segment_groups[0] != null) {
            $main_segment_group_IDs = array_map('intval', $request->main_segment_groups);
            $user_IDs3              = $mainSegmentsRepository->findWhereIn('segment_id', $main_segment_group_IDs, ['user_id'])->pluck('user_id')->all();
            $list_user_IDs          = array_intersect($list_user_IDs, $user_IDs3);
        }

        $limit     = is_null($request->limit) ? config('repository.pagination.limit', 10) : intval($request->limit);
        $order_by  = is_null($request->order_by) ? 'id' : $request->order_by;
        $direction = (is_null($request->direction) || $request->direction !== 'desc') ? 'asc' : $request->direction;

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

    public function getInfo(&$user)
    {
        if ($user->roles()->get(['id'])->count()) {
            $roles = $user->roles()->get()[0]['id'];
        } else {
            $roles = 0;
        }

        $mainProductGroups = $user->mainProductGroups()->pluck('product_group_id');
        $mainTargets       = $user->mainTargets()->pluck('target_group_id');
        $mainSegments      = $user->mainSegments()->pluck('segment_id');
        $role_type_ids     = $user->roleTypes()->pluck('role_type_id');

        $user['role_type_id']        = $role_type_ids;
        $user['role_id']             = $roles;
        $user['main_product_groups'] = $mainProductGroups;
        $user['main_segment_groups'] = $mainSegments;
        $user['main_target_groups']  = $mainTargets;
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
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
        }

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
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
    public function update($id, UpdateUsersAPIRequest $request)
    {
        $input = $request->all();

        /** @var Users $users */
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
        }
        if(trim($input['password']) != ''){
            $input['password'] = bcrypt($input['password']);
        }
        else{
            unset($input['password']);
        }

        $users = $this->usersRepository->update($input, $id);

        return $this->sendResponse($users->toArray(), 'Users updated successfully');
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
            return $this->sendError('Users not found');
        }

        $users->delete();

        return $this->sendResponse($id, 'Users deleted successfully');
    }

    public function showMainProductGroup($id)
    {
        /** @var Users $users */
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
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

        $limit     = is_null($request->limit) ? config('repository.pagination.limit', 10) : intval($request->limit);
        $order_by  = is_null($request->order_by) ? 'id' : $request->order_by;
        $direction = is_null($request->direction) ? 'asc' : $request->direction;

//        $this->usersRepository->pushCriteria(new RequestCriteria($request));
//        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));
        $users = $this->usersRepository->findWhereInAndPaginate('is_activated', [0], $order_by, $direction, $limit, $paginate, ['*']);

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
        $limit     = is_null($request->limit) ? config('repository.pagination.limit', 10) : intval($request->limit);
        $order_by  = is_null($request->order_by) ? 'id' : $request->order_by;
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
            return $this->sendError('Users not found');
        }
    }

    public function verify(Request $request)
    {
        $user = $this->usersRepository->findWithoutFail($request->user_id);
        if(!$user){
            return $this->sendError('Users not found!');
        }
        if(trim($user->activation_code) == ""){
            return $this->sendError('Users already activated!');
        }
        if (trim($user->activation_code) === trim($request->activation_code)) {
            $this->usersRepository->update(['activation_code' => ""], $request->user_id);
            return $this->sendResponse($request->user_id, 'Users activated successfully!');
        } else {
            return $this->sendError('Users activated unsuccessfully!');
        }

    }

    public function resendActivationCode(Request $request)
    {
        $user = $this->usersRepository->findWithoutFail($request->user_id);
    }
}
