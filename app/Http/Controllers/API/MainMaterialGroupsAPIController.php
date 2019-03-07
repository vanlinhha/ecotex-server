<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMainMaterialGroupsAPIRequest;
use App\Http\Requests\API\UpdateMainMaterialGroupsAPIRequest;
use App\Models\MainMaterialGroups;
use App\Models\Users;
use App\Repositories\MainMaterialGroupsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainMaterialGroupsController
 * @package App\Http\Controllers\API
 */

class MainMaterialGroupsAPIController extends AppBaseController
{
    /** @var  MainMaterialGroupsRepository */
    private $mainMaterialGroupsRepository;

    public function __construct(MainMaterialGroupsRepository $mainMaterialGroupsRepo)
    {
        $this->mainMaterialGroupsRepository = $mainMaterialGroupsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/mainMaterialGroups",
     *      summary="Get a listing of the MainMaterialGroups.",
     *      tags={"MainMaterialGroups"},
     *      description="Get all MainMaterialGroups",
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
     *                  @SWG\Items(ref="#/definitions/MainMaterialGroups")
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
        $this->mainMaterialGroupsRepository->pushCriteria(new RequestCriteria($request));
        $this->mainMaterialGroupsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainMaterialGroups = $this->mainMaterialGroupsRepository->all();

        return $this->sendResponse($mainMaterialGroups->toArray(), 'Main Material Groups retrieved successfully');
    }

    /**
     * @param CreateMainMaterialGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/mainMaterialGroups",
     *      summary="Store a newly created MainMaterialGroups in storage",
     *      tags={"MainMaterialGroups"},
     *      description="Store MainMaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainMaterialGroups that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainMaterialGroups")
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
     *                  ref="#/definitions/MainMaterialGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMainMaterialGroupsAPIRequest $request)
    {
        $input = $request->all();

        $mainMaterialGroups = $this->mainMaterialGroupsRepository->create($input);

        return $this->sendResponse($mainMaterialGroups->toArray(), 'Main Material Groups saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/mainMaterialGroups/{id}",
     *      summary="Display the specified MainMaterialGroups",
     *      tags={"MainMaterialGroups"},
     *      description="Get MainMaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainMaterialGroups",
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
     *                  ref="#/definitions/MainMaterialGroups"
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
        /** @var MainMaterialGroups $mainMaterialGroups */
        $mainMaterialGroups = $this->mainMaterialGroupsRepository->findWithoutFail($id);

        if (empty($mainMaterialGroups)) {
            return $this->sendError('Main Material Groups not found');
        }

        return $this->sendResponse($mainMaterialGroups->toArray(), 'Main Material Groups retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMainMaterialGroupsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/mainMaterialGroups/{id}",
     *      summary="Update the specified MainMaterialGroups in storage",
     *      tags={"MainMaterialGroups"},
     *      description="Update MainMaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainMaterialGroups",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainMaterialGroups that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainMaterialGroups")
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
     *                  ref="#/definitions/MainMaterialGroups"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMainMaterialGroupsAPIRequest $request)
    {
        $input = $request->all();

        /** @var MainMaterialGroups $mainMaterialGroups */
        $mainMaterialGroups = $this->mainMaterialGroupsRepository->findWithoutFail($id);

        if (empty($mainMaterialGroups)) {
            return $this->sendError('Main Material Groups not found');
        }

        $mainMaterialGroups = $this->mainMaterialGroupsRepository->update($input, $id);

        return $this->sendResponse($mainMaterialGroups->toArray(), 'MainMaterialGroups updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/mainMaterialGroups/{id}",
     *      summary="Remove the specified MainMaterialGroups from storage",
     *      tags={"MainMaterialGroups"},
     *      description="Delete MainMaterialGroups",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainMaterialGroups",
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
        /** @var MainMaterialGroups $mainMaterialGroups */
        $mainMaterialGroups = $this->mainMaterialGroupsRepository->findWithoutFail($id);

        if (empty($mainMaterialGroups)) {
            return $this->sendError('Main Material Groups not found');
        }

        $mainMaterialGroups->delete();

        return $this->sendResponse($id, 'Main Material Groups deleted successfully');
    }

    public function updateMainMaterialGroups($id, Request $request)
    {
        foreach ($request->main_material_groups as $item) {
            if (($item['id'] == 'null' || $item['id'] == null) && $item['_destroy'] == true) {
                continue;
            }
            if ($item['id'] == 'null' || $item['id'] == null) {
                $this->mainMaterialGroupsRepository->create($item);
            }

            elseif (isset($item['_destroy']) && ($item['_destroy'] == true)) {
                $mainMaterialGroups = $this->mainMaterialGroupsRepository->findWithoutFail($item['id']);
                if (empty($mainMaterialGroups)) {
                    return $this->sendError('Main material groups not found');
                }
                $mainMaterialGroups->delete();
            }
            else{

                $this->mainMaterialGroupsRepository->update($item, $item['id']);
            }
        }
        $mainMaterialGroups = Users::find($id)->mainMaterialGroups()->get(['*']);
        return $this->sendResponse($mainMaterialGroups, 'Main material groups updated successfully');

    }
}
