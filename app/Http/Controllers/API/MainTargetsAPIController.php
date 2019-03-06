<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMainTargetsAPIRequest;
use App\Http\Requests\API\UpdateMainTargetsAPIRequest;
use App\Models\MainTargets;
use App\Models\Users;
use App\Repositories\MainTargetsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class MainTargetsController
 * @package App\Http\Controllers\API
 */

class MainTargetsAPIController extends AppBaseController
{
    /** @var  MainTargetsRepository */
    private $mainTargetsRepository;

    public function __construct(MainTargetsRepository $mainTargetsRepo)
    {
        $this->mainTargetsRepository = $mainTargetsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_targets",
     *      summary="Get a listing of the MainTargets.",
     *      tags={"MainTargets"},
     *      description="Get all MainTargets",
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
     *                  @SWG\Items(ref="#/definitions/MainTargets")
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
        $this->mainTargetsRepository->pushCriteria(new RequestCriteria($request));
        $this->mainTargetsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $mainTargets = $this->mainTargetsRepository->all();

        return $this->sendResponse($mainTargets->toArray(), 'Main Targets retrieved successfully');
    }

    /**
     * @param CreateMainTargetsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/main_targets",
     *      summary="Store a newly created MainTargets in storage",
     *      tags={"MainTargets"},
     *      description="Store MainTargets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainTargets that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainTargets")
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
     *                  ref="#/definitions/MainTargets"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateMainTargetsAPIRequest $request)
    {
        $input = $request->all();

        $mainTargets = $this->mainTargetsRepository->create($input);

        return $this->sendResponse($mainTargets->toArray(), 'Main Targets saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/main_targets/{id}",
     *      summary="Display the specified MainTargets",
     *      tags={"MainTargets"},
     *      description="Get MainTargets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainTargets",
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
     *                  ref="#/definitions/MainTargets"
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
        /** @var MainTargets $mainTargets */
        $mainTargets = $this->mainTargetsRepository->findWithoutFail($id);

        if (empty($mainTargets)) {
            return $this->sendError('Main Targets not found');
        }

        return $this->sendResponse($mainTargets->toArray(), 'Main Targets retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateMainTargetsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/main_targets/{id}",
     *      summary="Update the specified MainTargets in storage",
     *      tags={"MainTargets"},
     *      description="Update MainTargets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainTargets",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="MainTargets that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/MainTargets")
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
     *                  ref="#/definitions/MainTargets"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateMainTargetsAPIRequest $request)
    {
        $input = $request->all();

        /** @var MainTargets $mainTargets */
        $mainTargets = $this->mainTargetsRepository->findWithoutFail($id);

        if (empty($mainTargets)) {
            return $this->sendError('Main Targets not found');
        }

        $mainTargets = $this->mainTargetsRepository->update($input, $id);

        return $this->sendResponse($mainTargets->toArray(), 'MainTargets updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/main_targets/{id}",
     *      summary="Remove the specified MainTargets from storage",
     *      tags={"MainTargets"},
     *      description="Delete MainTargets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of MainTargets",
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
        /** @var MainTargets $mainTargets */
        $mainTargets = $this->mainTargetsRepository->findWithoutFail($id);

        if (empty($mainTargets)) {
            return $this->sendError('Main Targets not found');
        }

        $mainTargets->delete();

        return $this->sendResponse($id, 'Main Targets deleted successfully');
    }


    public function updateMainTargets($id, Request $request)
    {
        foreach ($request->main_targets as $item) {
            if ($item['id'] == 'null' || $item['id'] == null) {
                $this->mainTargetsRepository->create($item);
            }

            elseif (isset($item['_destroy']) && ($item['_destroy'] == true)) {

                $mainTargets = $this->mainTargetsRepository->findWithoutFail($item['id']);

                if (empty($mainTargets)) {
                    return $this->sendError('Main targets not found');
                }
                $mainTargets->delete();
            }
            else{

                $this->mainTargetsRepository->update($item, $item['id']);
            }
        }
        $mainTargets = Users::find($id)->mainTargets()->get(['*']);
        return $this->sendResponse($mainTargets, 'Main targets updated successfully');

    }
}
