<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMainProductGroupsAPIRequest;
use App\Http\Requests\API\UpdateMainProductGroupsAPIRequest;
use App\Models\MainProductGroups;
use App\Repositories\MainProductGroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainProductGroupsController
 * @package App\Http\Controllers\API
 */

class MainProductGroupsAPIController extends AppBaseController
{
    /** @var  MainProductGroupsRepository */
    private $mainProductGroupsRepository;

    public function __construct(MainProductGroupsRepository $mainProductGroupsRepo)
    {
        $this->mainProductGroupsRepository = $mainProductGroupsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_product_groups",
     *      summary="Get a listing of the MainProductGroups.",
     *      tags={"MainProductGroups"},
     *      description="Get all MainProductGroups",
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
     *                  @SWG\Items(ref="#/definitions/MainProductGroups")
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
        $this->mainProductGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->mainProductGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainProductGroups = $this->mainProductGroupsRepository->all();

        return $this->sendResponse($mainProductGroups->toArray(), 'Main Product Groups retrieved successfully');
    }

    /**
     * @param CreateMainProductGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/main_product_groups",
     *      summary="Store a newly created MainProductGroups in storage",
     *      tags={"MainProductGroups"},
     *      description="Store MainProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainProductGroups that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainProductGroups")
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
     *                  ref="#/definitions/MainProductGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMainProductGroupsAPIRequest $request)
    {
        $input = $request->all();

        $mainProductGroups = $this->mainProductGroupsRepository->create($input);

        return $this->sendResponse($mainProductGroups->toArray(), 'Main Product Groups saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_product_groups/{id}",
     *      summary="Display the specified MainProductGroups",
     *      tags={"MainProductGroups"},
     *      description="Get MainProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainProductGroups",
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
     *                  ref="#/definitions/MainProductGroups"
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
        /** @var MainProductGroups $mainProductGroups */
        $mainProductGroups = $this->mainProductGroupsRepository->findWithoutFail($id);

        if (empty($mainProductGroups)) {
            return $this->sendError('Main Product Groups not found');
        }

        return $this->sendResponse($mainProductGroups->toArray(), 'Main Product Groups retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMainProductGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/main_product_groups/{id}",
     *      summary="Update the specified MainProductGroups in storage",
     *      tags={"MainProductGroups"},
     *      description="Update MainProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainProductGroups",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainProductGroups that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainProductGroups")
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
     *                  ref="#/definitions/MainProductGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMainProductGroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var MainProductGroups $mainProductGroups */
        $mainProductGroups = $this->mainProductGroupsRepository->findWithoutFail($id);

        if (empty($mainProductGroups)) {
            return $this->sendError('Main Product Groups not found');
        }

        $mainProductGroups = $this->mainProductGroupsRepository->update($input, $id);

        return $this->sendResponse($mainProductGroups->toArray(), 'MainProductGroups updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/main_product_groups/{id}",
     *      summary="Remove the specified MainProductGroups from storage",
     *      tags={"MainProductGroups"},
     *      description="Delete MainProductGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainProductGroups",
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
        /** @var MainProductGroups $mainProductGroups */
        $mainProductGroups = $this->mainProductGroupsRepository->findWithoutFail($id);

        if (empty($mainProductGroups)) {
            return $this->sendError('Main Product Groups not found');
        }

        $mainProductGroups->delete();

        return $this->sendResponse($id, 'Main Product Groups deleted successfully');
    }
}
