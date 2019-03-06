<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMaterialGroupsAPIRequest;
use App\Http\Requests\API\UpdateMaterialGroupsAPIRequest;
use App\Models\MaterialGroups;
use App\Models\Users;
use App\Repositories\MaterialGroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MaterialGroupsController
 * @package App\Http\Controllers\API
 */

class MaterialGroupsAPIController extends AppBaseController
{
    /** @var  MaterialGroupsRepository */
    private $materialGroupsRepository;

    public function __construct(MaterialGroupsRepository $materialGroupsRepo)
    {
        $this->materialGroupsRepository = $materialGroupsRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/material_groups",
     *      summary="Get a listing of the MaterialGroups.",
     *      tags={"MaterialGroups"},
     *      description="Get all MaterialGroups",
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
     *                  @SWG\Items(ref="#/definitions/MaterialGroups")
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
        $this->materialGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->materialGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $materialGroups = $this->materialGroupsRepository->all();

        return $this->sendResponse($materialGroups->toArray(), 'Material Groups retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/material_groups",
     *      summary="Store a newly created MaterialGroups in storage",
     *      tags={"MaterialGroups"},
     *      description="Store MaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MaterialGroups that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MaterialGroups")
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
     *                  ref="#/definitions/MaterialGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMaterialGroupsAPIRequest $request)
    {
        $input = $request->all();

        $materialGroups = $this->materialGroupsRepository->create($input);

        return $this->sendResponse($materialGroups->toArray(), 'Material Groups saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/material_groups/{id}",
     *      summary="Display the specified MaterialGroups",
     *      tags={"MaterialGroups"},
     *      description="Get MaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MaterialGroups",
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
     *                  ref="#/definitions/MaterialGroups"
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
        /** @var MaterialGroups $materialGroups */
        $materialGroups = $this->materialGroupsRepository->findWithoutFail($id);

        if (empty($materialGroups)) {
            return $this->sendError('Material Groups not found');
        }

        return $this->sendResponse($materialGroups->toArray(), 'Material Groups retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMaterialGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/material_groups/{id}",
     *      summary="Update the specified MaterialGroups in storage",
     *      tags={"MaterialGroups"},
     *      description="Update MaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MaterialGroups",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MaterialGroups that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MaterialGroups")
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
     *                  ref="#/definitions/MaterialGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMaterialGroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var MaterialGroups $materialGroups */
        $materialGroups = $this->materialGroupsRepository->findWithoutFail($id);

        if (empty($materialGroups)) {
            return $this->sendError('Material Groups not found');
        }

        $materialGroups = $this->materialGroupsRepository->update($input, $id);

        return $this->sendResponse($materialGroups->toArray(), 'MaterialGroups updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/material_groups/{id}",
     *      summary="Remove the specified MaterialGroups from storage",
     *      tags={"MaterialGroups"},
     *      description="Delete MaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MaterialGroups",
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
        /** @var MaterialGroups $materialGroups */
        $materialGroups = $this->materialGroupsRepository->findWithoutFail($id);

        if (empty($materialGroups)) {
            return $this->sendError('Material Groups not found');
        }

        $materialGroups->delete();

        return $this->sendResponse($id, 'Material Groups deleted successfully');
    }

    public function updateMainMaterialGroups($id, Request $request)
    {
        foreach ($request->main_material_groups as $item) {
            if ($item['id'] == 'null' || $item['id'] == null) {
                $this->materialGroupsRepository->create($item);
            }

            elseif (isset($item['_destroy']) && ($item['_destroy'] == true)) {

                $mainMaterialGroups = $this->materialGroupsRepository->findWithoutFail($item['id']);

                if (empty($mainMaterialGroups)) {
                    return $this->sendError('Main material groups not found');
                }
                $mainMaterialGroups->delete();
            }
            else{

                $this->materialGroupsRepository->update($item, $item['id']);
            }
        }
        $mainMaterialGroups = Users::find($id)->mainMaterialGroups()->get(['*']);
        return $this->sendResponse($mainMaterialGroups, 'Main material groups updated successfully');

    }
}
