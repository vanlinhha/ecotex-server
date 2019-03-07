<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMainServicesAPIRequest;
use App\Http\Requests\API\UpdateMainServicesAPIRequest;
use App\Models\MainServices;
use App\Repositories\MainServicesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainServicesController
 * @package App\Http\Controllers\API
 */

class MainServicesAPIController extends AppBaseController
{
    /** @var  MainServicesRepository */
    private $mainServicesRepository;

    public function __construct(MainServicesRepository $mainServicesRepo)
    {
        $this->mainServicesRepository = $mainServicesRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_services",
     *      summary="Get a listing of the MainServices.",
     *      tags={"MainServices"},
     *      description="Get all MainServices",
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
     *                  @SWG\Items(ref="#/definitions/MainServices")
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
        $this->mainServicesRepository->pushCriteria(new RequestCriteria($request));
        $this->mainServicesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainServices = $this->mainServicesRepository->all();

        return $this->sendResponse($mainServices->toArray(), 'Main Services retrieved successfully');
    }

    /**
     * @param CreateMainServicesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/main_services",
     *      summary="Store a newly created MainServices in storage",
     *      tags={"MainServices"},
     *      description="Store MainServices",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainServices that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainServices")
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
     *                  ref="#/definitions/MainServices"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMainServicesAPIRequest $request)
    {
        $input = $request->all();

        $mainServices = $this->mainServicesRepository->create($input);

        return $this->sendResponse($mainServices->toArray(), 'Main Services saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_services/{id}",
     *      summary="Display the specified MainServices",
     *      tags={"MainServices"},
     *      description="Get MainServices",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainServices",
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
     *                  ref="#/definitions/MainServices"
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
        /** @var MainServices $mainServices */
        $mainServices = $this->mainServicesRepository->findWithoutFail($id);

        if (empty($mainServices)) {
            return $this->sendError('Main Services not found');
        }

        return $this->sendResponse($mainServices->toArray(), 'Main Services retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMainServicesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/main_services/{id}",
     *      summary="Update the specified MainServices in storage",
     *      tags={"MainServices"},
     *      description="Update MainServices",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainServices",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainServices that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainServices")
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
     *                  ref="#/definitions/MainServices"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMainServicesAPIRequest $request)
    {
        $input = $request->all();

        /** @var MainServices $mainServices */
        $mainServices = $this->mainServicesRepository->findWithoutFail($id);

        if (empty($mainServices)) {
            return $this->sendError('Main Services not found');
        }

        $mainServices = $this->mainServicesRepository->update($input, $id);

        return $this->sendResponse($mainServices->toArray(), 'MainServices updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/main_services/{id}",
     *      summary="Remove the specified MainServices from storage",
     *      tags={"MainServices"},
     *      description="Delete MainServices",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainServices",
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
        /** @var MainServices $mainServices */
        $mainServices = $this->mainServicesRepository->findWithoutFail($id);

        if (empty($mainServices)) {
            return $this->sendError('Main Services not found');
        }

        $mainServices->delete();

        return $this->sendResponse($id, 'Main Services deleted successfully');
    }

    public function updateMainServices($id, Request $request)
    {
        foreach ($request->main_services as $item) {
            if (($item['id'] == 'null' || $item['id'] == null) && $item['_destroy'] == true) {
                continue;
            }
            if ($item['id'] == 'null' || $item['id'] == null) {
                $this->mainServicesRepository->create($item);
            }

            elseif (isset($item['_destroy']) && ($item['_destroy'] == true)) {

                $mainServices = $this->mainServicesRepository->findWithoutFail($item['id']);

                if (empty($mainServices)) {
                    return $this->sendError('Main services not found');
                }
                $mainServices->delete();
            }
            else{

                $this->mainServicesRepository->update($item, $item['id']);
            }
        }
        $mainServices = Users::find($id)->mainServices()->get(['*']);
        return $this->sendResponse($mainServices, 'Main services updated successfully');

    }
}
