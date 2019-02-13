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
//        dd($request->main_product_groups);
        $this->usersRepository->pushCriteria(new RequestCriteria($request));
        $this->usersRepository->pushCriteria(new LimitOffsetCriteria($request));
        if (trim($request->textSearch) != "") {
            $users = $this->usersRepository->findWhere([['company_name', 'like', "%" . $request->textSearch . "%"]]);
            return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
        }

        if (count($request->main_product_groups)) {
            $main_product_group_IDs = array_map('intval', $request->main_product_groups);
            $user_IDs               = $mainProductGroupsRepository->findWhereIn('product_group_id', $main_product_group_IDs, ['user_id'])->pluck('user_id')->all();
        }
        if (count($request->main_target_groups)) {
            $main_target_group_IDs = array_map('intval', $request->main_target_groups);
            $user_IDs2             = $mainTargetsRepository->findWhereIn('target_group_id', $main_target_group_IDs, ['user_id'])->pluck('user_id')->all();
        }

        if (count($request->main_segment_groups)) {
            $main_segment_group_IDs = array_map('intval', $request->main_segment_groups);
            $user_IDs3             = $mainSegmentsRepository->findWhereIn('segment_id', $main_segment_group_IDs, ['user_id'])->pluck('user_id')->all();
        }


        $list_user_IDs = array_merge($user_IDs, $user_IDs2, $user_IDs3);
        $users         = $this->usersRepository->findWhereIn('id', $list_user_IDs, ['*']);

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
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

        return $this->sendResponse($users->toArray(), 'Inactivated users retrieved successfully');
    }
}
