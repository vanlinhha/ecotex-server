<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateServicesAPIRequest;
use App\Http\Requests\API\UpdateServicesAPIRequest;
use App\Models\Services;
use App\Repositories\ServicesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ServicesController
 * @package App\Http\Controllers\API
 */

class ServicesAPIController extends AppBaseController
{
    /** @var  ServicesRepository */
    private $servicesRepository;

    public function __construct(ServicesRepository $servicesRepo)
    {
        $this->servicesRepository = $servicesRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/services",
     *      summary="Get a listing of the Services.",
     *      tags={"Services"},
     *      description="Get all Services",
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
     *                  @SWG\Items(ref="#/definitions/Services")
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
        $this->servicesRepository->pushCriteria(new RequestCriteria($request));
        $this->servicesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $services = $this->servicesRepository->all();

        return $this->sendResponse($services->toArray(), 'Services retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/services",
     *      summary="Store a newly created Services in storage",
     *      tags={"Services"},
     *      description="Store Services",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Services that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Services")
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
    public function store(CreateServicesAPIRequest $request)
    {
        $input = $request->all();

        $services = $this->servicesRepository->create($input);

        return $this->sendResponse($services->toArray(), 'Services saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/services/{id}",
     *      summary="Display the specified Services",
     *      tags={"Services"},
     *      description="Get Services",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Services",
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
    public function show($id)
    {
        /** @var Services $services */
        $services = $this->servicesRepository->findWithoutFail($id);

        if (empty($services)) {
            return $this->sendError(__('Services not found'));
        }

        return $this->sendResponse($services->toArray(), 'Services retrieved successfully');
    }

    /**
     *
     * @SWG\Put(
     *      path="/services/{id}",
     *      summary="Update the specified Services in storage",
     *      tags={"Services"},
     *      description="Update Services",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Services",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Services that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Services")
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
    public function update($id, UpdateServicesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Services $services */
        $services = $this->servicesRepository->findWithoutFail($id);

        if (empty($services)) {
            return $this->sendError(__('Services not found'));
        }

        $services = $this->servicesRepository->update($input, $id);

        return $this->sendResponse($services->toArray(), 'Services updated successfully');
    }

    /**
     *
     * @SWG\Delete(
     *      path="/services/{id}",
     *      summary="Remove the specified Services from storage",
     *      tags={"Services"},
     *      description="Delete Services",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Services",
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
        /** @var Services $services */
        $services = $this->servicesRepository->findWithoutFail($id);

        if (empty($services)) {
            return $this->sendError(__('Services not found'));
        }

        $services->delete();

        return $this->sendResponse($id, 'Services deleted successfully');
    }
}
