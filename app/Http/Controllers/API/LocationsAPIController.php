<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLocationsAPIRequest;
use App\Http\Requests\API\UpdateLocationsAPIRequest;
use App\Models\Locations;
use App\Repositories\LocationsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class LocationsController
 * @package App\Http\Controllers\API
 */

class LocationsAPIController extends AppBaseController
{
    /** @var  LocationsRepository */
    private $locationsRepository;

    public function __construct(LocationsRepository $locationsRepo)
    {
        $this->locationsRepository = $locationsRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/locations",
     *      summary="Get a listing of the Locations.",
     *      tags={"Locations"},
     *      description="Get all Locations",
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
     *                  @SWG\Items(ref="#/definitions/Locations")
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
        $this->locationsRepository->pushCriteria(new RequestCriteria($request));
        $this->locationsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $locations = $this->locationsRepository->all();

        return $this->sendResponse($locations->toArray(), 'Locations retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/locations",
     *      summary="Store a newly created Locations in storage",
     *      tags={"Locations"},
     *      description="Store Locations",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Locations that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Locations")
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
     *                  ref="#/definitions/Locations"
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

        $locations = $this->locationsRepository->create($input);

        return $this->sendResponse($locations->toArray(), 'Locations saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/locations/{id}",
     *      summary="Display the specified Locations",
     *      tags={"Locations"},
     *      description="Get Locations",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Locations",
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
     *                  ref="#/definitions/Locations"
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
        /** @var Locations $locations */
        $locations = $this->locationsRepository->findWithoutFail($id);

        if (empty($locations)) {
            return $this->sendError('Locations not found');
        }

        return $this->sendResponse($locations->toArray(), 'Locations retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLocationsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/locations/{id}",
     *      summary="Update the specified Locations in storage",
     *      tags={"Locations"},
     *      description="Update Locations",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Locations",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Locations that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Locations")
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
     *                  ref="#/definitions/Locations"
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

        /** @var Locations $locations */
        $locations = $this->locationsRepository->findWithoutFail($id);

        if (empty($locations)) {
            return $this->sendError('Locations not found');
        }

        $locations = $this->locationsRepository->update($input, $id);

        return $this->sendResponse($locations->toArray(), 'Locations updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/locations/{id}",
     *      summary="Remove the specified Locations from storage",
     *      tags={"Locations"},
     *      description="Delete Locations",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Locations",
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
        /** @var Locations $locations */
        $locations = $this->locationsRepository->findWithoutFail($id);

        if (empty($locations)) {
            return $this->sendError('Locations not found');
        }

        $locations->delete();

        return $this->sendResponse($id, 'Locations deleted successfully');
    }
}
