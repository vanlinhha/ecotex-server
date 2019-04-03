<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCountriesAPIRequest;
use App\Http\Requests\API\UpdateCountriesAPIRequest;
use App\Models\Countries;
use App\Repositories\CountriesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class CountriesController
 * @package App\Http\Controllers\API
 */

class CountriesAPIController extends AppBaseController
{
    /** @var  CountriesRepository */
    private $countriesRepository;

    public function __construct(CountriesRepository $countriesRepo)
    {
        $this->countriesRepository = $countriesRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/countries",
     *      summary="Get a listing of the Countries.",
     *      tags={"Countries"},
     *      description="Get all Countries",
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
     *                  @SWG\Items(ref="#/definitions/Countries")
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
        $this->countriesRepository->pushCriteria(new RequestCriteria($request));
        $this->countriesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $countries  = $this->countriesRepository->scopeQuery(function($query){
            return $query->orderBy('name','asc');
        })->all();
//        $countries = $this->countriesRepository->orderBy('name');
//        $countries = $countries->orderBy

        return $this->sendResponse($countries->toArray(), 'Countries retrieved successfully');
    }

    /**
     * @param CreateCountriesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/countries",
     *      summary="Store a newly created Countries in storage",
     *      tags={"Countries"},
     *      description="Store Countries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Countries that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Countries")
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
     *                  ref="#/definitions/Countries"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCountriesAPIRequest $request)
    {
        $input = $request->all();

        $countries = $this->countriesRepository->create($input);

        return $this->sendResponse($countries->toArray(), 'Countries saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/countries/{id}",
     *      summary="Display the specified Countries",
     *      tags={"Countries"},
     *      description="Get Countries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Countries",
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
     *                  ref="#/definitions/Countries"
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
        /** @var Countries $countries */
        $countries = $this->countriesRepository->findWithoutFail($id);

        if (empty($countries)) {
            return $this->sendError(__('Countries not found'));
        }

        return $this->sendResponse($countries->toArray(), 'Countries retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCountriesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/countries/{id}",
     *      summary="Update the specified Countries in storage",
     *      tags={"Countries"},
     *      description="Update Countries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Countries",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Countries that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Countries")
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
     *                  ref="#/definitions/Countries"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCountriesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Countries $countries */
        $countries = $this->countriesRepository->findWithoutFail($id);

        if (empty($countries)) {
            return $this->sendError(__('Countries not found'));
        }

        $countries = $this->countriesRepository->update($input, $id);

        return $this->sendResponse($countries->toArray(), 'Countries updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/countries/{id}",
     *      summary="Remove the specified Countries from storage",
     *      tags={"Countries"},
     *      description="Delete Countries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Countries",
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
        /** @var Countries $countries */
        $countries = $this->countriesRepository->findWithoutFail($id);

        if (empty($countries)) {
            return $this->sendError(__('Countries not found'));
        }

        $countries->delete();

        return $this->sendResponse($id, 'Countries deleted successfully');
    }
}
