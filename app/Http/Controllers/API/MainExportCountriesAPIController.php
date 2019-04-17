<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMainExportCountriesAPIRequest;
use App\Http\Requests\API\UpdateMainExportCountriesAPIRequest;
use App\Models\MainExportCountries;
use App\Models\Users;
use App\Repositories\MainExportCountriesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Laratrust\Laratrust;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainExportCountriesController
 * @package App\Http\Controllers\API
 */

class MainExportCountriesAPIController extends AppBaseController
{
    /** @var  MainExportCountriesRepository */
    private $mainExportCountriesRepository;

    public function __construct(MainExportCountriesRepository $mainExportCountriesRepo)
    {
        $this->mainExportCountriesRepository = $mainExportCountriesRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/main_export_countries",
     *      summary="Get a listing of the MainExportCountries.",
     *      tags={"MainExportCountries"},
     *      description="Get all MainExportCountries",
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
     *                  @SWG\Items(ref="#/definitions/MainExportCountries")
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
        $this->mainExportCountriesRepository->pushCriteria(new RequestCriteria($request));
        $this->mainExportCountriesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainExportCountries = $this->mainExportCountriesRepository->all();

        return $this->sendResponse($mainExportCountries->toArray(), 'Main Export Countries retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/main_export_countries",
     *      summary="Store a newly created MainExportCountries in storage",
     *      tags={"MainExportCountries"},
     *      description="Store MainExportCountries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainExportCountries that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainExportCountries")
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
     *                  ref="#/definitions/MainExportCountries"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMainExportCountriesAPIRequest $request)
    {
        $input = $request->all();

        $mainExportCountries = $this->mainExportCountriesRepository->create($input);

        return $this->sendResponse($mainExportCountries->toArray(), 'Main Export Countries saved successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/main_export_countries/{id}",
     *      summary="Display the specified MainExportCountries",
     *      tags={"MainExportCountries"},
     *      description="Get MainExportCountries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainExportCountries",
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
     *                  ref="#/definitions/MainExportCountries"
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
        /** @var MainExportCountries $mainExportCountries */
        $mainExportCountries = $this->mainExportCountriesRepository->findWithoutFail($id);

        if (empty($mainExportCountries)) {
            return $this->sendError(__('Main Export Countries not found'));
        }

        return $this->sendResponse($mainExportCountries->toArray(), 'Main Export Countries retrieved successfully');
    }

    /**
     *
     * @SWG\Put(
     *      path="/main_export_countries/{id}",
     *      summary="Update the specified MainExportCountries in storage",
     *      tags={"MainExportCountries"},
     *      description="Update MainExportCountries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainExportCountries",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainExportCountries that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainExportCountries")
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
     *                  ref="#/definitions/MainExportCountries"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMainExportCountriesAPIRequest $request)
    {
        $input = $request->all();

        /** @var MainExportCountries $mainExportCountries */
        $mainExportCountries = $this->mainExportCountriesRepository->findWithoutFail($id);

        if (empty($mainExportCountries)) {
            return $this->sendError(__('Main Export Countries not found'));
        }

        $mainExportCountries = $this->mainExportCountriesRepository->update($input, $id);

        return $this->sendResponse($mainExportCountries->toArray(), 'MainExportCountries updated successfully');
    }

    /**
     *
     * @SWG\Delete(
     *      path="/main_export_countries/{id}",
     *      summary="Remove the specified MainExportCountries from storage",
     *      tags={"MainExportCountries"},
     *      description="Delete MainExportCountries",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainExportCountries",
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
        /** @var MainExportCountries $mainExportCountries */
        $mainExportCountries = $this->mainExportCountriesRepository->findWithoutFail($id);

        if (empty($mainExportCountries)) {
            return $this->sendError(__('Main Export Countries not found'));
        }

        $mainExportCountries->delete();

        return $this->sendResponse($id, 'Main Export Countries deleted successfully');
    }

    public function updateMainExportCountries($id, Request $request)
    {
        foreach ($request->main_export_countries as $item) {
            if (($item['id'] == 'null' || $item['id'] == null) && $item['_destroy'] == true) {
                continue;
            }
            if ($item['id'] == 'null' || $item['id'] == null) {
                $this->mainExportCountriesRepository->create($item);
            }

            elseif ($item['_destroy'] == true) {

                $mainExportCountries = $this->mainExportCountriesRepository->findWithoutFail($item['id']);

                if (empty($mainExportCountries)) {
                    return $this->sendError(__('Main Export Countries not found'));
                }
                $mainExportCountries->delete();
            }
            else{
                $this->mainExportCountriesRepository->update($item, $item['id']);
            }
        }
        $mainExportCountries = Users::find($id)->mainExportCountries()->get(['*', 'country_id', 'percent']);
        return $this->sendResponse($mainExportCountries, 'Main export countries updated successfully');

    }
}
