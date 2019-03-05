<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMainSegmentGroupsAPIRequest;
use App\Http\Requests\API\UpdateMainSegmentGroupsAPIRequest;
use App\Models\MainSegmentGroups;
use App\Models\Users;
use App\Repositories\MainSegmentGroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainSegmentGroupsController
 * @package App\Http\Controllers\API
 */

class MainSegmentGroupsAPIController extends AppBaseController
{
    /** @var  MainSegmentGroupsRepository */
    private $mainSegmentGroupsRepository;

    public function __construct(MainSegmentGroupsRepository $mainSegmentGroupsRepo)
    {
        $this->mainSegmentGroupsRepository = $mainSegmentGroupsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_segment_groups",
     *      summary="Get a listing of the MainSegmentGroups.",
     *      tags={"MainSegmentGroups"},
     *      description="Get all MainSegmentGroups",
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
     *                  @SWG\Items(ref="#/definitions/MainSegmentGroups")
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
        $this->mainSegmentGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->mainSegmentGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainSegmentGroups = $this->mainSegmentGroupsRepository->paginate(1);

        return $this->sendResponse($mainSegmentGroups->toArray(), 'Main Segments retrieved successfully');
    }

    /**
     * @param CreateMainSegmentGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/main_segment_groups",
     *      summary="Store a newly created MainSegmentGroups in storage",
     *      tags={"MainSegmentGroups"},
     *      description="Store MainSegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainSegmentGroups that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainSegmentGroups")
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
     *                  ref="#/definitions/MainSegmentGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMainSegmentGroupsAPIRequest $request)
    {
        $input = $request->all();

        $mainSegmentGroups = $this->mainSegmentGroupsRepository->create($input);

        return $this->sendResponse($mainSegmentGroups->toArray(), 'Main Segments saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_segment_groups/{id}",
     *      summary="Display the specified MainSegmentGroups",
     *      tags={"MainSegmentGroups"},
     *      description="Get MainSegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainSegmentGroups",
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
     *                  ref="#/definitions/MainSegmentGroups"
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
        /** @var MainSegmentGroups $mainSegmentGroups */
        $mainSegmentGroups = $this->mainSegmentGroupsRepository->findWithUserInfo($id);

        if (empty($mainSegmentGroups)) {
            return $this->sendError('Main Segments not found');
        }

        return $this->sendResponse($mainSegmentGroups->toArray(), 'Main Segments retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMainSegmentGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/main_segment_groups/{id}",
     *      summary="Update the specified MainSegmentGroups in storage",
     *      tags={"MainSegmentGroups"},
     *      description="Update MainSegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainSegmentGroups",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainSegmentGroups that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainSegmentGroups")
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
     *                  ref="#/definitions/MainSegmentGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMainSegmentGroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var MainSegmentGroups $mainSegmentGroups */
        $mainSegmentGroups = $this->mainSegmentGroupsRepository->findWithoutFail($id);

        if (empty($mainSegmentGroups)) {
            return $this->sendError('Main Segments not found');
        }

        $mainSegmentGroups = $this->mainSegmentGroupsRepository->update($input, $id);

        return $this->sendResponse($mainSegmentGroups->toArray(), 'MainSegmentGroups updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/main_segment_groups/{id}",
     *      summary="Remove the specified MainSegmentGroups from storage",
     *      tags={"MainSegmentGroups"},
     *      description="Delete MainSegmentGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainSegmentGroups",
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
        /** @var MainSegmentGroups $mainSegmentGroups */
        $mainSegmentGroups = $this->mainSegmentGroupsRepository->findWithoutFail($id);

        if (empty($mainSegmentGroups)) {
            return $this->sendError('Main Segments not found');
        }

        $mainSegmentGroups->delete();

        return $this->sendResponse($id, 'Main Segments deleted successfully');
    }

    public function updateMainSegmentGroups($id, Request $request)
    {
        foreach ($request->main_segment_groups as $item) {
            if (!isset($item['id'])) {
                $this->mainSegmentGroupsRepository->create($item);
            }

            elseif (isset($item['_destroy']) && ($item['_destroy'] == true)) {

                $mainSegmentGroups = $this->mainSegmentGroupsRepository->findWithoutFail($item['id']);

                if (empty($mainSegmentGroups)) {
                    return $this->sendError('Main Segments not found');
                }
                $mainSegmentGroups->delete();
            }
            else{

                $this->mainSegmentGroupsRepository->update($item, $item['id']);
            }
        }
        $mainSegmentGroups = Users::find($id)->mainSegmentGroups()->get(['*']);
        return $this->sendResponse($mainSegmentGroups, 'Main Segments updated successfully');

    }
}
