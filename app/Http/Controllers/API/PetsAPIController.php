<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePetsAPIRequest;
use App\Http\Requests\API\UpdatePetsAPIRequest;
use App\Models\Pets;
use App\Repositories\PetsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PetsController
 * @package App\Http\Controllers\API
 */

class PetsAPIController extends AppBaseController
{
    /** @var  PetsRepository */
    private $petsRepository;

    public function __construct(PetsRepository $petsRepo)
    {
        $this->petsRepository = $petsRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/pets",
     *      summary="Get a listing of the Pets.",
     *      tags={"Pets"},
     *      description="Get all Pets",
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
     *                  @SWG\Items(ref="#/definitions/Pets")
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
        $this->petsRepository->pushCriteria(new RequestCriteria($request));
        $this->petsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pets = $this->petsRepository->all();

        return $this->sendResponse($pets->toArray(), 'Pets retrieved successfully');
    }

    /**
     * @param CreatePetsAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/pets",
     *      summary="Store a newly created Pets in storage",
     *      tags={"Pets"},
     *      description="Store Pets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Pets that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Pets")
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
     *                  ref="#/definitions/Pets"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePetsAPIRequest $request)
    {
        $input = $request->all();

        $pets = $this->petsRepository->create($input);

        return $this->sendResponse($pets->toArray(), 'Pets saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/pets/{id}",
     *      summary="Display the specified Pets",
     *      tags={"Pets"},
     *      description="Get Pets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Pets",
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
     *                  ref="#/definitions/Pets"
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
        /** @var Pets $pets */
        $pets = $this->petsRepository->findWithoutFail($id);

        if (empty($pets)) {
            return $this->sendError('Pets not found');
        }

        return $this->sendResponse($pets->toArray(), 'Pets retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePetsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/pets/{id}",
     *      summary="Update the specified Pets in storage",
     *      tags={"Pets"},
     *      description="Update Pets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Pets",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Pets that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Pets")
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
     *                  ref="#/definitions/Pets"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePetsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Pets $pets */
        $pets = $this->petsRepository->findWithoutFail($id);

        if (empty($pets)) {
            return $this->sendError('Pets not found');
        }

        $pets = $this->petsRepository->update($input, $id);

        return $this->sendResponse($pets->toArray(), 'Pets updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/pets/{id}",
     *      summary="Remove the specified Pets from storage",
     *      tags={"Pets"},
     *      description="Delete Pets",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Pets",
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
        /** @var Pets $pets */
        $pets = $this->petsRepository->findWithoutFail($id);

        if (empty($pets)) {
            return $this->sendError('Pets not found');
        }

        $pets->delete();

        return $this->sendResponse($id, 'Pets deleted successfully');
    }
}
