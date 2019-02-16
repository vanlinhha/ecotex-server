<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMinimumOrderQuantityAPIRequest;
use App\Http\Requests\API\UpdateMinimumOrderQuantityAPIRequest;
use App\Models\MinimumOrderQuantity;
use App\Repositories\MinimumOrderQuantityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MinimumOrderQuantityController
 * @package App\Http\Controllers\API
 */

class MinimumOrderQuantityAPIController extends AppBaseController
{
    /** @var  MinimumOrderQuantityRepository */
    private $minimumOrderQuantityRepository;

    public function __construct(MinimumOrderQuantityRepository $minimumOrderQuantityRepo)
    {
        $this->minimumOrderQuantityRepository = $minimumOrderQuantityRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/minimum_order_quantities",
     *      summary="Get a listing of the MinimumOrderQuantities.",
     *      tags={"MinimumOrderQuantity"},
     *      description="Get all MinimumOrderQuantities",
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
     *                  @SWG\Items(ref="#/definitions/MinimumOrderQuantity")
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
        $this->minimumOrderQuantityRepository->pushCriteria(new RequestCriteria($request));
        $this->minimumOrderQuantityRepository->pushCriteria(new LimitOffsetCriteria($request));
        $minimumOrderQuantities = $this->minimumOrderQuantityRepository->all();

        return $this->sendResponse($minimumOrderQuantities->toArray(), 'Minimum Order Quantities retrieved successfully');
    }

    /**
     * @param CreateMinimumOrderQuantityAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/minimum_order_quantities",
     *      summary="Store a newly created MinimumOrderQuantity in storage",
     *      tags={"MinimumOrderQuantity"},
     *      description="Store MinimumOrderQuantity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MinimumOrderQuantity that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MinimumOrderQuantity")
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
     *                  ref="#/definitions/MinimumOrderQuantity"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMinimumOrderQuantityAPIRequest $request)
    {
        $input = $request->all();

        $minimumOrderQuantities = $this->minimumOrderQuantityRepository->create($input);

        return $this->sendResponse($minimumOrderQuantities->toArray(), 'Minimum Order Quantity saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/minimum_order_quantities/{id}",
     *      summary="Display the specified MinimumOrderQuantity",
     *      tags={"MinimumOrderQuantity"},
     *      description="Get MinimumOrderQuantity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MinimumOrderQuantity",
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
     *                  ref="#/definitions/MinimumOrderQuantity"
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
        /** @var MinimumOrderQuantity $minimumOrderQuantity */
        $minimumOrderQuantity = $this->minimumOrderQuantityRepository->findWithoutFail($id);

        if (empty($minimumOrderQuantity)) {
            return $this->sendError('Minimum Order Quantity not found');
        }

        return $this->sendResponse($minimumOrderQuantity->toArray(), 'Minimum Order Quantity retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMinimumOrderQuantityAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/minimum_order_quantities/{id}",
     *      summary="Update the specified MinimumOrderQuantity in storage",
     *      tags={"MinimumOrderQuantity"},
     *      description="Update MinimumOrderQuantity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MinimumOrderQuantity",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MinimumOrderQuantity that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MinimumOrderQuantity")
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
     *                  ref="#/definitions/MinimumOrderQuantity"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMinimumOrderQuantityAPIRequest $request)
    {
        $input = $request->all();

        /** @var MinimumOrderQuantity $minimumOrderQuantity */
        $minimumOrderQuantity = $this->minimumOrderQuantityRepository->findWithoutFail($id);

        if (empty($minimumOrderQuantity)) {
            return $this->sendError('Minimum Order Quantity not found');
        }

        $minimumOrderQuantity = $this->minimumOrderQuantityRepository->update($input, $id);

        return $this->sendResponse($minimumOrderQuantity->toArray(), 'MinimumOrderQuantity updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/minimum_order_quantities/{id}",
     *      summary="Remove the specified MinimumOrderQuantity from storage",
     *      tags={"MinimumOrderQuantity"},
     *      description="Delete MinimumOrderQuantity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MinimumOrderQuantity",
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
        /** @var MinimumOrderQuantity $minimumOrderQuantity */
        $minimumOrderQuantity = $this->minimumOrderQuantityRepository->findWithoutFail($id);

        if (empty($minimumOrderQuantity)) {
            return $this->sendError('Minimum Order Quantity not found');
        }

        $minimumOrderQuantity->delete();

        return $this->sendResponse($id, 'Minimum Order Quantity deleted successfully');
    }
}
