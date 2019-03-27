<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResponsesAPIRequest;
use App\Http\Requests\API\UpdateResponsesAPIRequest;
use App\Models\Responses;
use App\Repositories\ResponsesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use JWTAuth;

/**
 * Class ResponsesController
 * @package App\Http\Controllers\API
 */
class ResponsesAPIController extends AppBaseController
{
    /** @var  ResponsesRepository */
    private $responsesRepository;

    public function __construct(ResponsesRepository $responsesRepo)
    {
        $this->responsesRepository = $responsesRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/responses",
     *      summary="Get a listing of the Responses.",
     *      tags={"Responses"},
     *      description="Get all Responses",
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
     *                  @SWG\Items(ref="#/definitions/Responses")
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
        $this->responsesRepository->pushCriteria(new RequestCriteria($request));
        $this->responsesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $responses = $this->responsesRepository->all();

        foreach ($responses as $response) {
            $productPost                   = $response->product_post()->first();
            $attachedFiles                 = $productPost->attachedFiles()->get();
            $productPost['attached_files'] = $attachedFiles;
            $attachedImages                = $productPost->attachedImages()->get();
            $productPost['images']         = $attachedImages;
            $productPost['creator']        = $productPost->creator()->select('id', 'first_name', 'last_name', 'company_name')->first();
            $response['product_post']      = $productPost;
        }

        return $this->sendResponse($responses->toArray(), 'Responses retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/responses",
     *      summary="Store a newly created Responses in storage",
     *      tags={"Responses"},
     *      description="Store Responses",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Responses that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Responses")
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
     *                  ref="#/definitions/Responses"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateResponsesAPIRequest $request)
    {
        $input = $request->all();

        $responses = $this->responsesRepository->create($input);

        $productPost                   = $responses->product_post()->first();
        $attachedFiles                 = $productPost->attachedFiles()->get();
        $productPost['attached_files'] = $attachedFiles;
        $attachedImages                = $productPost->attachedImages()->get();
        $productPost['images']         = $attachedImages;
        $productPost['creator']        = $productPost->creator()->select('id', 'first_name', 'last_name', 'company_name')->first();
        $responses['product_post']     = $productPost;


        return $this->sendResponse($responses->toArray(), 'Responses saved successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/responses/{id}",
     *      summary="Display the specified Responses",
     *      tags={"Responses"},
     *      description="Get Responses",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Responses",
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
     *                  ref="#/definitions/Responses"
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
        /** @var Responses $responses */
        $responses = $this->responsesRepository->findWithoutFail($id);

        if (empty($responses)) {
            return $this->sendError('Responses not found');
        }

        $productPost                   = $responses->product_post()->first();
        $attachedFiles                 = $productPost->attachedFiles()->get();
        $productPost['attached_files'] = $attachedFiles;
        $attachedImages                = $productPost->attachedImages()->get();
        $productPost['images']         = $attachedImages;
        $productPost['creator']        = $productPost->creator()->select('id', 'first_name', 'last_name', 'company_name')->first();
        $responses['product_post']     = $productPost;

        return $this->sendResponse($responses->toArray(), 'Responses retrieved successfully');
    }

    /**
     *
     * @SWG\Put(
     *      path="/responses/{id}",
     *      summary="Update the specified Responses in storage",
     *      tags={"Responses"},
     *      description="Update Responses",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Responses",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Responses that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Responses")
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
     *                  ref="#/definitions/Responses"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateResponsesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Responses $responses */
        $responses = $this->responsesRepository->findWithoutFail($id);

        if (empty($responses)) {
            return $this->sendError('Responses not found');
        }

        $responses = $this->responsesRepository->update($input, $id);

        return $this->sendResponse($responses->toArray(), 'Responses updated successfully');
    }

    /**
     *
     * @SWG\Delete(
     *      path="/responses/{id}",
     *      summary="Remove the specified Responses from storage",
     *      tags={"Responses"},
     *      description="Delete Responses",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Responses",
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
        /** @var Responses $responses */
        $responses = $this->responsesRepository->findWithoutFail($id);

        if (empty($responses)) {
            return $this->sendError('Responses not found');
        }

        $responses->delete();

        return $this->sendResponse($id, 'Responses deleted successfully');
    }

    /**
     *
     * @SWG\Get(
     *      path="/response_user",
     *      summary="Display the specified Responses",
     *      tags={"Responses"},
     *      description="Get Responses",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Responses",
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
     *                  ref="#/definitions/Responses"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getUserResponses()
    {
        /** @var Responses $responses */

        $responses = $this->responsesRepository->findWhere(['owner_id' => JWTAuth::parseToken()->authenticate()->id]);

        if (empty($responses)) {
            return $this->sendError('Responses not found');
        }

        foreach ($responses as $response) {
            $productPost                   = $response->product_post()->first();
            $attachedFiles                 = $productPost->attachedFiles()->get();
            $productPost['attached_files'] = $attachedFiles;
            $attachedImages                = $productPost->attachedImages()->get();
            $productPost['images']         = $attachedImages;
            $productPost['creator']        = $productPost->creator()->select('id', 'first_name', 'last_name', 'company_name')->first();
            $response['product_post']      = $productPost;
        }

        return $this->sendResponse($responses->toArray(), 'Responses retrieved successfully');
    }
}
