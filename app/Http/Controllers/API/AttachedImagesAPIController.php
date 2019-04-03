<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttachedImagesAPIRequest;
use App\Http\Requests\API\UpdateAttachedImagesAPIRequest;
use App\Models\AttachedImages;
use App\Repositories\AttachedImagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AttachedImagesController
 * @package App\Http\Controllers\API
 */

class AttachedImagesAPIController extends AppBaseController
{
    /** @var  AttachedImagesRepository */
    private $attachedImagesRepository;

    public function __construct(AttachedImagesRepository $attachedImagesRepo)
    {
        $this->attachedImagesRepository = $attachedImagesRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/attachedImages",
     *      summary="Get a listing of the AttachedImages.",
     *      tags={"AttachedImages"},
     *      description="Get all AttachedImages",
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
     *                  @SWG\Items(ref="#/definitions/AttachedImages")
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
        $this->attachedImagesRepository->pushCriteria(new RequestCriteria($request));
        $this->attachedImagesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $attachedImages = $this->attachedImagesRepository->all();

        return $this->sendResponse($attachedImages->toArray(), 'Attached Images retrieved successfully');
    }

    /**
     * @param CreateAttachedImagesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/attachedImages",
     *      summary="Store a newly created AttachedImages in storage",
     *      tags={"AttachedImages"},
     *      description="Store AttachedImages",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttachedImages that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttachedImages")
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
     *                  ref="#/definitions/AttachedImages"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAttachedImagesAPIRequest $request)
    {
        $input = $request->all();

        $attachedImages = $this->attachedImagesRepository->create($input);

        return $this->sendResponse($attachedImages->toArray(), 'Attached Images saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/attachedImages/{id}",
     *      summary="Display the specified AttachedImages",
     *      tags={"AttachedImages"},
     *      description="Get AttachedImages",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttachedImages",
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
     *                  ref="#/definitions/AttachedImages"
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
        /** @var AttachedImages $attachedImages */
        $attachedImages = $this->attachedImagesRepository->findWithoutFail($id);

        if (empty($attachedImages)) {
            return $this->sendError(__('Attached Images not found'));
        }

        return $this->sendResponse($attachedImages->toArray(), 'Attached Images retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAttachedImagesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/attachedImages/{id}",
     *      summary="Update the specified AttachedImages in storage",
     *      tags={"AttachedImages"},
     *      description="Update AttachedImages",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttachedImages",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttachedImages that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttachedImages")
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
     *                  ref="#/definitions/AttachedImages"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAttachedImagesAPIRequest $request)
    {
        $input = $request->all();

        /** @var AttachedImages $attachedImages */
        $attachedImages = $this->attachedImagesRepository->findWithoutFail($id);

        if (empty($attachedImages)) {
            return $this->sendError(__('Attached Images not found'));
        }

        $attachedImages = $this->attachedImagesRepository->update($input, $id);

        return $this->sendResponse($attachedImages->toArray(), 'AttachedImages updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/attachedImages/{id}",
     *      summary="Remove the specified AttachedImages from storage",
     *      tags={"AttachedImages"},
     *      description="Delete AttachedImages",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttachedImages",
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
        /** @var AttachedImages $attachedImages */
        $attachedImages = $this->attachedImagesRepository->findWithoutFail($id);

        if (empty($attachedImages)) {
            return $this->sendError(__('Attached Images not found'));
        }

        $attachedImages->delete();

        return $this->sendResponse($id, 'Attached Images deleted successfully');
    }
}
