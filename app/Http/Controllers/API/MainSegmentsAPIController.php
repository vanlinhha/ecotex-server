<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMainSegmentsAPIRequest;
use App\Http\Requests\API\UpdateMainSegmentsAPIRequest;
use App\Models\MainSegments;
use App\Repositories\MainSegmentsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainSegmentsController
 * @package App\Http\Controllers\API
 */

class MainSegmentsAPIController extends AppBaseController
{
    /** @var  MainSegmentsRepository */
    private $mainSegmentsRepository;

    public function __construct(MainSegmentsRepository $mainSegmentsRepo)
    {
        $this->mainSegmentsRepository = $mainSegmentsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/mainSegments",
     *      summary="Get a listing of the MainSegments.",
     *      tags={"MainSegments"},
     *      description="Get all MainSegments",
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
     *                  @SWG\Items(ref="#/definitions/MainSegments")
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
        $this->mainSegmentsRepository->pushCriteria(new RequestCriteria($request));
        $this->mainSegmentsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainSegments = $this->mainSegmentsRepository->paginate(1);

        return $this->sendResponse($mainSegments->toArray(), 'Main Segments retrieved successfully');
    }

    /**
     * @param CreateMainSegmentsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/mainSegments",
     *      summary="Store a newly created MainSegments in storage",
     *      tags={"MainSegments"},
     *      description="Store MainSegments",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainSegments that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainSegments")
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
     *                  ref="#/definitions/MainSegments"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMainSegmentsAPIRequest $request)
    {
        $input = $request->all();

        $mainSegments = $this->mainSegmentsRepository->create($input);

        return $this->sendResponse($mainSegments->toArray(), 'Main Segments saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/mainSegments/{id}",
     *      summary="Display the specified MainSegments",
     *      tags={"MainSegments"},
     *      description="Get MainSegments",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainSegments",
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
     *                  ref="#/definitions/MainSegments"
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
        /** @var MainSegments $mainSegments */
        $mainSegments = $this->mainSegmentsRepository->findWithUserInfo($id);

        if (empty($mainSegments)) {
            return $this->sendError('Main Segments not found');
        }

        return $this->sendResponse($mainSegments->toArray(), 'Main Segments retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMainSegmentsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/mainSegments/{id}",
     *      summary="Update the specified MainSegments in storage",
     *      tags={"MainSegments"},
     *      description="Update MainSegments",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainSegments",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainSegments that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainSegments")
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
     *                  ref="#/definitions/MainSegments"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMainSegmentsAPIRequest $request)
    {
        $input = $request->all();

        /** @var MainSegments $mainSegments */
        $mainSegments = $this->mainSegmentsRepository->findWithoutFail($id);

        if (empty($mainSegments)) {
            return $this->sendError('Main Segments not found');
        }

        $mainSegments = $this->mainSegmentsRepository->update($input, $id);

        return $this->sendResponse($mainSegments->toArray(), 'MainSegments updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/mainSegments/{id}",
     *      summary="Remove the specified MainSegments from storage",
     *      tags={"MainSegments"},
     *      description="Delete MainSegments",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainSegments",
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
        /** @var MainSegments $mainSegments */
        $mainSegments = $this->mainSegmentsRepository->findWithoutFail($id);

        if (empty($mainSegments)) {
            return $this->sendError('Main Segments not found');
        }

        $mainSegments->delete();

        return $this->sendResponse($id, 'Main Segments deleted successfully');
    }
}
