<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRoleTypesAPIRequest;
use App\Http\Requests\API\UpdateRoleTypesAPIRequest;
use App\Models\RoleTypes;
use App\Repositories\RoleTypesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class RoleTypesController
 * @package App\Http\Controllers\API
 */

class RoleTypesAPIController extends AppBaseController
{
    /** @var  RoleTypesRepository */
    private $roleTypesRepository;

    public function __construct(RoleTypesRepository $roleTypesRepo)
    {
        $this->roleTypesRepository = $roleTypesRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/role_types",
     *      summary="Get a listing of the RoleTypes.",
     *      tags={"RoleTypes"},
     *      description="Get all RoleTypes",
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
     *                  @SWG\Items(ref="#/definitions/RoleTypes")
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
        $this->roleTypesRepository->pushCriteria(new RequestCriteria($request));
        $this->roleTypesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $roleTypes = $this->roleTypesRepository->all();

        return $this->sendResponse($roleTypes->toArray(), 'Role Types retrieved successfully');
    }

    /**
     * @param CreateRoleTypesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/role_types",
     *      summary="Store a newly created RoleTypes in storage",
     *      tags={"RoleTypes"},
     *      description="Store RoleTypes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RoleTypes that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RoleTypes")
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
     *                  ref="#/definitions/RoleTypes"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRoleTypesAPIRequest $request)
    {
        $input = $request->all();

        $roleTypes = $this->roleTypesRepository->create($input);

        return $this->sendResponse($roleTypes->toArray(), 'Role Types saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/role_types/{id}",
     *      summary="Display the specified RoleTypes",
     *      tags={"RoleTypes"},
     *      description="Get RoleTypes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RoleTypes",
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
     *                  ref="#/definitions/RoleTypes"
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
        /** @var RoleTypes $roleTypes */
        $roleTypes = $this->roleTypesRepository->findWithoutFail($id);

        if (empty($roleTypes)) {
            return $this->sendError('Role Types not found');
        }

        return $this->sendResponse($roleTypes->toArray(), 'Role Types retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRoleTypesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/role_types/{id}",
     *      summary="Update the specified RoleTypes in storage",
     *      tags={"RoleTypes"},
     *      description="Update RoleTypes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RoleTypes",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RoleTypes that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RoleTypes")
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
     *                  ref="#/definitions/RoleTypes"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRoleTypesAPIRequest $request)
    {
        $input = $request->all();

        /** @var RoleTypes $roleTypes */
        $roleTypes = $this->roleTypesRepository->findWithoutFail($id);

        if (empty($roleTypes)) {
            return $this->sendError('Role Types not found');
        }

        $roleTypes = $this->roleTypesRepository->update($input, $id);

        return $this->sendResponse($roleTypes->toArray(), 'RoleTypes updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/role_types/{id}",
     *      summary="Remove the specified RoleTypes from storage",
     *      tags={"RoleTypes"},
     *      description="Delete RoleTypes",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RoleTypes",
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
        /** @var RoleTypes $roleTypes */
        $roleTypes = $this->roleTypesRepository->findWithoutFail($id);

        if (empty($roleTypes)) {
            return $this->sendError('Role Types not found');
        }

        $roleTypes->delete();

        return $this->sendResponse($id, 'Role Types deleted successfully');
    }
}
