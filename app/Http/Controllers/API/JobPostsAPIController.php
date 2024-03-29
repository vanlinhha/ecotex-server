<?php

namespace App\Http\Controllers\API;

use App\Models\JobPosts;
use App\Repositories\JobPostsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use JWTAuth;

/**
 * Class JobPostsController
 * @package App\Http\Controllers\API
 */

class JobPostsAPIController extends AppBaseController
{
    /** @var  JobPostsRepository */
    private $jobPostsRepository;

    public function __construct(JobPostsRepository $jobPostsRepo)
    {
        $this->jobPostsRepository = $jobPostsRepo;
    }

    /**
     *
     * @SWG\Get(
     *      path="/jobPosts",
     *      summary="Get a listing of the JobPosts.",
     *      tags={"JobPosts"},
     *      description="Get all JobPosts",
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
     *                  @SWG\Items(ref="#/definitions/JobPosts")
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
//        $this->jobPostsRepository->pushCriteria(new RequestCriteria($request));
//        $this->jobPostsRepository->pushCriteria(new LimitOffsetCriteria($request));

        $text_search   = $request->text_search ? $request->text_search : "";
        $list_post_IDS = $this->jobPostsRepository->findWhere([['title', 'like', "%" . $text_search . "%"]])->pluck('id')->all();

        if(isset($request->creator)){
            if ($request->creator == "me") {
                $post_IDs3     = $this->jobPostsRepository->findWhereIn('creator_id', [JWTAuth::parseToken()->authenticate()->id])->pluck('id')->all();
                $list_post_IDS = array_intersect($list_post_IDS, $post_IDs3);
            } elseif ($request->creator == "other") {
                $post_IDs4     = $this->jobPostsRepository->findWhereNotIn('creator_id', [JWTAuth::parseToken()->authenticate()->id])->pluck('id')->all();
                $list_post_IDS = array_intersect($list_post_IDS, $post_IDs4);
            }
        }

//        $jobPosts = $this->jobPostsRepository->all();
//        foreach ($jobPosts as $jobPost){
//            $jobPost['creator'] = $jobPost->creator()->select('id', 'first_name', 'last_name', 'company_name', 'avatar')->first();
//        }

        $limit     = is_null($request->limit) ? config('repository.pagination.limit', 10) : intval($request->limit);
        $order_by  = is_null($request->order_by) ? 'id' : $request->order_by;
        $direction = (is_null($request->direction) || $request->direction !== 'desc') ? 'asc' : $request->direction;

        $jobPosts = $this->jobPostsRepository->findWhereInAndPaginate('id', $list_post_IDS, $order_by, $direction, $limit, true, ['*']);

        foreach ($jobPosts as $jobPost) {
            $jobPost['creator'] = $jobPost->creator()->select('id', 'first_name', 'last_name', 'company_name', 'avatar')->first();
            unset($jobPost['creator_id']);
        }

        return $this->sendResponse($jobPosts->toArray(), 'Job Posts retrieved successfully');
    }

    /**
     *
     * @SWG\Post(
     *      path="/jobPosts",
     *      summary="Store a newly created JobPosts in storage",
     *      tags={"JobPosts"},
     *      description="Store JobPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobPosts that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobPosts")
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
     *                  ref="#/definitions/JobPosts"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $jobPosts = $this->jobPostsRepository->create($input);

        $jobPosts['creator'] = $jobPosts->creator()->select('id', 'first_name', 'last_name', 'company_name', 'avatar')->first();

        return $this->sendResponse($jobPosts->toArray(), 'Job Posts saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobPosts/{id}",
     *      summary="Display the specified JobPosts",
     *      tags={"JobPosts"},
     *      description="Get JobPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobPosts",
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
     *                  ref="#/definitions/JobPosts"
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
        /** @var JobPosts $jobPosts */
        $jobPosts = $this->jobPostsRepository->findWithoutFail($id);

        if (empty($jobPosts)) {
            return $this->sendError('Job Posts not found');
        }

        $jobPosts['creator'] = $jobPosts->creator()->select('id', 'first_name', 'last_name', 'company_name', 'avatar')->first();

        return $this->sendResponse($jobPosts->toArray(), 'Job Posts retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobPostsAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/jobPosts/{id}",
     *      summary="Update the specified JobPosts in storage",
     *      tags={"JobPosts"},
     *      description="Update JobPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobPosts",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobPosts that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobPosts")
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
     *                  ref="#/definitions/JobPosts"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, Request $request)
    {
        $input = $request->all();

        /** @var JobPosts $jobPosts */
        $jobPosts = $this->jobPostsRepository->findWithoutFail($id);

        if (empty($jobPosts)) {
            return $this->sendError('Job Posts not found');
        }

        $jobPosts = $this->jobPostsRepository->update($input, $id);
        $jobPosts['creator'] = $jobPosts->creator()->select('id', 'first_name', 'last_name', 'company_name', 'avatar')->first();

        return $this->sendResponse($jobPosts->toArray(), 'JobPosts updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/jobPosts/{id}",
     *      summary="Remove the specified JobPosts from storage",
     *      tags={"JobPosts"},
     *      description="Delete JobPosts",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobPosts",
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
        /** @var JobPosts $jobPosts */
        $jobPosts = $this->jobPostsRepository->findWithoutFail($id);

        if (empty($jobPosts)) {
            return $this->sendError('Job Posts not found');
        }

        $jobPosts->delete();

        return $this->sendResponse($id, 'Job Posts deleted successfully');
    }
}
