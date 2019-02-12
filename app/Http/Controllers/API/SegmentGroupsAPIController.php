<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSegmentGroupsAPIRequest;
use App\Http\Requests\API\UpdateSegmentGroupsAPIRequest;
use App\Models\SegmentGroups;
use App\Repositories\SegmentGroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class SegmentGroupsController
 * @package App\Http\Controllers\API
 */

class SegmentGroupsAPIController extends AppBaseController
{
    /** @var  SegmentGroupsRepository */
    private $segmentGroupsRepository;

    public function __construct(SegmentGroupsRepository $segmentGroupsRepo)
    {
        $this->segmentGroupsRepository = $segmentGroupsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/segment_groups",
     *      summary="Get a listing of the SegmentGroups.",
     *      tags={"SegmentGroups"},
     *      description="Get all SegmentGroups",
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
     *                  @SWG\Items(ref="#/definitions/SegmentGroups")
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
        $this->segmentGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->segmentGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $segmentGroups = $this->segmentGroupsRepository->all();

        return $this->sendResponse($segmentGroups->toArray(), 'Segment Groups retrieved successfully');
    }

    /**
     * @param CreateSegmentGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/segment_groups",
     *      summary="Store a newly created SegmentGroups in storage",
     *      tags={"SegmentGroups"},
     *      description="Store SegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="name",
     *          in="query",
     *          type="string",
     *          description="SegmentGroups that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SegmentGroups")
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
     *                  ref="#/definitions/SegmentGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSegmentGroupsAPIRequest $request)
    {
        $input = $request->all();

        $segmentGroups = $this->segmentGroupsRepository->create($input);

        return $this->sendResponse($segmentGroups->toArray(), 'Segment Groups saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/segment_groups/{id}",
     *      summary="Display the specified SegmentGroups",
     *      tags={"SegmentGroups"},
     *      description="Get SegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SegmentGroups",
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
     *                  ref="#/definitions/SegmentGroups"
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
        /** @var SegmentGroups $segmentGroups */
        $segmentGroups = $this->segmentGroupsRepository->findWithoutFail($id);

        if (empty($segmentGroups)) {
            return $this->sendError('Segment Groups not found');
        }

        return $this->sendResponse($segmentGroups->toArray(), 'Segment Groups retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSegmentGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/segment_groups/{id}",
     *      summary="Update the specified SegmentGroups in storage",
     *      tags={"SegmentGroups"},
     *      description="Update SegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SegmentGroups",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SegmentGroups that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SegmentGroups")
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
     *                  ref="#/definitions/SegmentGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSegmentGroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var SegmentGroups $segmentGroups */
        $segmentGroups = $this->segmentGroupsRepository->findWithoutFail($id);

        if (empty($segmentGroups)) {
            return $this->sendError('Segment Groups not found');
        }

        $segmentGroups = $this->segmentGroupsRepository->update($input, $id);

        return $this->sendResponse($segmentGroups->toArray(), 'SegmentGroups updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/segment_groups/{id}",
     *      summary="Remove the specified SegmentGroups from storage",
     *      tags={"SegmentGroups"},
     *      description="Delete SegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SegmentGroups",
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
        /** @var SegmentGroups $segmentGroups */
        $segmentGroups = $this->segmentGroupsRepository->findWithoutFail($id);

        if (empty($segmentGroups)) {
            return $this->sendError('Segment Groups not found');
        }

        $segmentGroups->delete();

        return $this->sendResponse($id, 'Segment Groups deleted successfully');
    }
}
