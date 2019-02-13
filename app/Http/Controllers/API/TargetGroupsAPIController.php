<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTargetGroupsAPIRequest;
use App\Http\Requests\API\UpdateTargetGroupsAPIRequest;
use App\Models\TargetGroups;
use App\Repositories\TargetGroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class TargetGroupsController
 * @package App\Http\Controllers\API
 */

class TargetGroupsAPIController extends AppBaseController
{
    /** @var  TargetGroupsRepository */
    private $targetGroupsRepository;

    public function __construct(TargetGroupsRepository $targetGroupsRepo)
    {
        $this->targetGroupsRepository = $targetGroupsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/target_groups",
     *      summary="Get a listing of the TargetGroups.",
     *      tags={"TargetGroups"},
     *      description="Get all TargetGroups",
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
     *                  @SWG\Items(ref="#/definitions/TargetGroups")
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
        $this->targetGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->targetGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $targetGroups = $this->targetGroupsRepository->all();

        return $this->sendResponse($targetGroups->toArray(), 'Target Groups retrieved successfully');
    }

    /**
     * @param CreateTargetGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/target_groups",
     *      summary="Store a newly created TargetGroups in storage",
     *      tags={"TargetGroups"},
     *      description="Store TargetGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TargetGroups that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TargetGroups")
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
     *                  ref="#/definitions/TargetGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTargetGroupsAPIRequest $request)
    {
        $input = $request->all();

        $targetGroups = $this->targetGroupsRepository->create($input);

        return $this->sendResponse($targetGroups->toArray(), 'Target Groups saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/target_groups/{id}",
     *      summary="Display the specified TargetGroups",
     *      tags={"TargetGroups"},
     *      description="Get TargetGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TargetGroups",
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
     *                  ref="#/definitions/TargetGroups"
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
        /** @var TargetGroups $targetGroups */
        $targetGroups = $this->targetGroupsRepository->findWithoutFail($id);

        if (empty($targetGroups)) {
            return $this->sendError('Target Groups not found');
        }

        return $this->sendResponse($targetGroups->toArray(), 'Target Groups retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTargetGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/target_groups/{id}",
     *      summary="Update the specified TargetGroups in storage",
     *      tags={"TargetGroups"},
     *      description="Update TargetGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TargetGroups",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TargetGroups that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TargetGroups")
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
     *                  ref="#/definitions/TargetGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTargetGroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var TargetGroups $targetGroups */
        $targetGroups = $this->targetGroupsRepository->findWithoutFail($id);

        if (empty($targetGroups)) {
            return $this->sendError('Target Groups not found');
        }

        $targetGroups = $this->targetGroupsRepository->update($input, $id);

        return $this->sendResponse($targetGroups->toArray(), 'TargetGroups updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/target_groups/{id}",
     *      summary="Remove the specified TargetGroups from storage",
     *      tags={"TargetGroups"},
     *      description="Delete TargetGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TargetGroups",
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
        /** @var TargetGroups $targetGroups */
        $targetGroups = $this->targetGroupsRepository->findWithoutFail($id);

        if (empty($targetGroups)) {
            return $this->sendError('Target Groups not found');
        }

        $targetGroups->delete();

        return $this->sendResponse($id, 'Target Groups deleted successfully');
    }
}
