<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAppliedCVAPIRequest;
use App\Http\Requests\API\UpdateAppliedCVAPIRequest;
use App\Models\AppliedCV;
use App\Repositories\AppliedCVRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AppliedCVController
 * @package App\Http\Controllers\API
 */

class AppliedCVAPIController extends AppBaseController
{
    /** @var  AppliedCVRepository */
    private $appliedCVRepository;

    public function __construct(AppliedCVRepository $appliedCVRepo)
    {
        $this->appliedCVRepository = $appliedCVRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/appliedCVs",
     *      summary="Get a listing of the AppliedCVs.",
     *      tags={"AppliedCV"},
     *      description="Get all AppliedCVs",
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
     *                  @SWG\Items(ref="#/definitions/AppliedCV")
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
        $this->appliedCVRepository->pushCriteria(new RequestCriteria($request));
        $this->appliedCVRepository->pushCriteria(new LimitOffsetCriteria($request));
        $appliedCVs = $this->appliedCVRepository->all();

        return $this->sendResponse($appliedCVs->toArray(), 'Applied C Vs retrieved successfully');
    }

    /**
     * @param CreateAppliedCVAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/appliedCVs",
     *      summary="Store a newly created AppliedCV in storage",
     *      tags={"AppliedCV"},
     *      description="Store AppliedCV",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AppliedCV that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AppliedCV")
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
     *                  ref="#/definitions/AppliedCV"
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
        $input = $request->all();

        $appliedCVs = $this->appliedCVRepository->create($input);

        return $this->sendResponse($appliedCVs->toArray(), 'Applied C V saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/appliedCVs/{id}",
     *      summary="Display the specified AppliedCV",
     *      tags={"AppliedCV"},
     *      description="Get AppliedCV",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AppliedCV",
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
     *                  ref="#/definitions/AppliedCV"
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
        /** @var AppliedCV $appliedCV */
        $appliedCV = $this->appliedCVRepository->findWithoutFail($id);

        if (empty($appliedCV)) {
            return $this->sendError('Applied C V not found');
        }

        return $this->sendResponse($appliedCV->toArray(), 'Applied C V retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAppliedCVAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/appliedCVs/{id}",
     *      summary="Update the specified AppliedCV in storage",
     *      tags={"AppliedCV"},
     *      description="Update AppliedCV",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AppliedCV",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AppliedCV that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AppliedCV")
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
     *                  ref="#/definitions/AppliedCV"
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

        /** @var AppliedCV $appliedCV */
        $appliedCV = $this->appliedCVRepository->findWithoutFail($id);

        if (empty($appliedCV)) {
            return $this->sendError('Applied C V not found');
        }

        $appliedCV = $this->appliedCVRepository->update($input, $id);

        return $this->sendResponse($appliedCV->toArray(), 'AppliedCV updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/appliedCVs/{id}",
     *      summary="Remove the specified AppliedCV from storage",
     *      tags={"AppliedCV"},
     *      description="Delete AppliedCV",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AppliedCV",
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
        /** @var AppliedCV $appliedCV */
        $appliedCV = $this->appliedCVRepository->findWithoutFail($id);

        if (empty($appliedCV)) {
            return $this->sendError('Applied C V not found');
        }

        $appliedCV->delete();

        return $this->sendResponse($id, 'Applied C V deleted successfully');
    }
}
