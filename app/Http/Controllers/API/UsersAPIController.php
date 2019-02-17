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
     *      summary="Get a listing of the Users.",
     *      tags={"Users"},
     *      description="Get all Users",
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
        $this->usersRepository->pushCriteria(new RequestCriteria($request));
        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));

        $text_search   = $request->text_search || "";
        $list_user_IDs = $this->usersRepository->findWhere([['company_name', 'like', "%" . $text_search . "%"]])->pluck('id')->all();
        if (isset($request->main_product_groups) && $request->main_product_groups[0] != null) {
            $main_product_group_IDs = array_map('intval', $request->main_product_groups);
            $user_IDs               = $mainProductGroupsRepository->findWhereIn('product_group_id', $main_product_group_IDs)->pluck('user_id')->all();
            $list_user_IDs = array_intersect($list_user_IDs, $user_IDs);
        }

        if (isset($request->main_target_groups) && $request->main_target_groups[0] != null) {
            $main_target_group_IDs = array_map('intval', $request->main_target_groups);
            $user_IDs2             = $mainTargetsRepository->findWhereIn('target_group_id', $main_target_group_IDs, ['user_id'])->pluck('user_id')->all();
            $list_user_IDs = array_intersect($list_user_IDs, $user_IDs2);
        }

        if (isset($request->main_segment_groups) && $request->main_segment_groups[0] != null) {
            $main_segment_group_IDs = array_map('intval', $request->main_segment_groups);
            $user_IDs3              = $mainSegmentsRepository->findWhereIn('segment_id', $main_segment_group_IDs, ['user_id'])->pluck('user_id')->all();
            $list_user_IDs = array_intersect($list_user_IDs, $user_IDs3);
        }

        $users = $this->usersRepository->findWhereIn('id', $list_user_IDs, ['*']);
        $currentPage = Paginator::resolveCurrentPage() - 1;
        $perPage = 10;
        $currentPageSearchResults = $users->slice($currentPage * $perPage, $perPage)->all();
        $users = new LengthAwarePaginator($currentPageSearchResults, count($users), $perPage);

        foreach ($users as $user) {
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
    public function store(CreateUsersAPIRequest $request)
    {
        $input = $request->all();

        $users = $this->usersRepository->create($input);

        return $this->sendResponse($users->toArray(), 'Users saved successfully');
    }

    /**
     * @param int $id
     * @return Response
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
     * @param int $id
     * @param UpdateUsersAPIRequest $request
     * @return Response
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
     *     @SWG\Parameter(
     *          name="email",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *      @SWG\Parameter(
     *          name="first_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="last_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="type",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="phone",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="country",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="company_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="brief_name",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="company_address",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="website",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Users")
     *      ),
     *     @SWG\Parameter(
     *          name="description",
     *          in="query",
     *          type="string",
     *          description="Users that should be updated",
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
    public function update($id, UpdateUsersAPIRequest $request)
    {
        $input = $request->all();

        /** @var Users $users */
        $users = $this->usersRepository->findWithoutFail($id);

        if (empty($users)) {
            return $this->sendError('Users not found');
        }

        $users = $this->usersRepository->update($input, $id);

        return $this->sendResponse($users->toArray(), 'Users updated successfully');
    }

    /**
     * @param int $id
     * @return Response
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
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/inactivated_users",
     *      summary="Get a listing of the inactivated Users.",
     *      tags={"Users"},
     *      description="Get all Users",
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
        $this->usersRepository->pushCriteria(new RequestCriteria($request));
        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));
        $users = $this->usersRepository->findWhereNotIn('is_activated', ['1', 1]);

        foreach ($users as $user) {
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

        return $this->sendResponse($users->toArray(), 'Inactivated users retrieved successfully');
    }

    public function verifyUsers(Request $request)
    {
        $user_ids = json_decode($request->user_ids);
        if (count($user_ids)) {
            foreach ($user_ids as $user_id) {
                $this->usersRepository->update(['is_activated' => 1], $user_id);
            }
            return $this->sendResponse($user_ids, 'Users verified successfully');
        } else {
            return $this->sendError('Users not found');
        }
    }
}
