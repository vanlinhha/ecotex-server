<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttachedFilesAPIRequest;
use App\Http\Requests\API\UpdateAttachedFilesAPIRequest;
use App\Models\AttachedFiles;
use App\Repositories\AttachedFilesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class AttachedFilesController
 * @package App\Http\Controllers\API
 */

class AttachedFilesAPIController extends AppBaseController
{
    /** @var  AttachedFilesRepository */
    private $attachedFilesRepository;

    public function __construct(AttachedFilesRepository $attachedFilesRepo)
    {
        $this->attachedFilesRepository = $attachedFilesRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/attachedFiles",
     *      summary="Get a listing of the AttachedFiles.",
     *      tags={"AttachedFiles"},
     *      description="Get all AttachedFiles",
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
     *                  @SWG\Items(ref="#/definitions/AttachedFiles")
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
        $this->attachedFilesRepository->pushCriteria(new RequestCriteria($request));
        $this->attachedFilesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $attachedFiles = $this->attachedFilesRepository->all();

        return $this->sendResponse($attachedFiles->toArray(), 'Attached Files retrieved successfully');
    }

    /**
     * @param CreateAttachedFilesAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/attachedFiles",
     *      summary="Store a newly created AttachedFiles in storage",
     *      tags={"AttachedFiles"},
     *      description="Store AttachedFiles",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttachedFiles that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttachedFiles")
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
     *                  ref="#/definitions/AttachedFiles"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAttachedFilesAPIRequest $request)
    {
        $input = $request->all();

        $attachedFiles = $this->attachedFilesRepository->create($input);

        return $this->sendResponse($attachedFiles->toArray(), 'Attached Files saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/attachedFiles/{id}",
     *      summary="Display the specified AttachedFiles",
     *      tags={"AttachedFiles"},
     *      description="Get AttachedFiles",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttachedFiles",
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
     *                  ref="#/definitions/AttachedFiles"
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
        /** @var AttachedFiles $attachedFiles */
        $attachedFiles = $this->attachedFilesRepository->findWithoutFail($id);

        if (empty($attachedFiles)) {
            return $this->sendError('Attached Files not found');
        }

        return $this->sendResponse($attachedFiles->toArray(), 'Attached Files retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAttachedFilesAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/attachedFiles/{id}",
     *      summary="Update the specified AttachedFiles in storage",
     *      tags={"AttachedFiles"},
     *      description="Update AttachedFiles",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttachedFiles",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttachedFiles that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttachedFiles")
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
     *                  ref="#/definitions/AttachedFiles"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAttachedFilesAPIRequest $request)
    {
        $input = $request->all();

        /** @var AttachedFiles $attachedFiles */
        $attachedFiles = $this->attachedFilesRepository->findWithoutFail($id);

        if (empty($attachedFiles)) {
            return $this->sendError('Attached Files not found');
        }

        $attachedFiles = $this->attachedFilesRepository->update($input, $id);

        return $this->sendResponse($attachedFiles->toArray(), 'AttachedFiles updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/attachedFiles/{id}",
     *      summary="Remove the specified AttachedFiles from storage",
     *      tags={"AttachedFiles"},
     *      description="Delete AttachedFiles",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttachedFiles",
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
        /** @var AttachedFiles $attachedFiles */
        $attachedFiles = $this->attachedFilesRepository->findWithoutFail($id);

        if (empty($attachedFiles)) {
            return $this->sendError('Attached Files not found');
        }

        $attachedFiles->delete();

        return $this->sendResponse($id, 'Attached Files deleted successfully');
    }
}
