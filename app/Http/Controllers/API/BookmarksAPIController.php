<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBookmarksAPIRequest;
use App\Http\Requests\API\UpdateBookmarksAPIRequest;
use App\Models\Bookmarks;
use App\Models\Users;
use App\Repositories\BookmarksRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class BookmarksController
 * @package App\Http\Controllers\API
 */
class BookmarksAPIController extends AppBaseController
{
    /** @var  BookmarksRepository */
    private $bookmarksRepository;

    public function __construct(BookmarksRepository $bookmarksRepo)
    {
        $this->bookmarksRepository = $bookmarksRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookmarks/user/{user_id}/",
     *      summary="Get a listing of the Bookmarks.",
     *      tags={"Bookmarks"},
     *      description="Get all Bookmarks",
     *      produces={"application/json"},
     *     @SWG\Parameter(
     *          name="user_id",
     *          description="id of users",
     *          type="integer",
     *          required=false,
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
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Bookmarks")
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
//        $this->bookmarksRepository->pushCriteria(new RequestCriteria($request));
//        $this->bookmarksRepository->pushCriteria(new LimitOffsetCriteria($request));
        if (isset($request->user_id)) {
            $bookmarks = $this->bookmarksRepository->findByField([['user_id', $request->user_id]]);
            foreach ($bookmarks as $bookmark){

                $bookmark['follower'] = Users::find($bookmark['follower_id']);
                unset($bookmark['follower_id']);
            }
            return $this->sendResponse($bookmarks->toArray(), 'Bookmarks retrieved successfully');
        } else {
            return $this->sendError('Users not found');
        }

    }

    /**
     * @param CreateBookmarksAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/bookmarks",
     *      summary="Store a newly created Bookmarks in storage",
     *      tags={"Bookmarks"},
     *      description="Store Bookmarks",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Bookmarks that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Bookmarks")
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
     *                  ref="#/definitions/Bookmarks"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBookmarksAPIRequest $request)
    {
        $input = $request->all();

        $bookmarks = $this->bookmarksRepository->create($input);

        return $this->sendResponse($bookmarks->toArray(), 'Bookmarks saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/bookmarks/{id}",
     *      summary="Display the specified Bookmarks",
     *      tags={"Bookmarks"},
     *      description="Get Bookmarks",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Bookmarks",
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
     *                  ref="#/definitions/Bookmarks"
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
        /** @var Bookmarks $bookmarks */
        $bookmarks = $this->bookmarksRepository->findWithoutFail($id);

        if (empty($bookmarks)) {
            return $this->sendError('Bookmarks not found');
        }

        return $this->sendResponse($bookmarks->toArray(), 'Bookmarks retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBookmarksAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/bookmarks/{id}",
     *      summary="Update the specified Bookmarks in storage",
     *      tags={"Bookmarks"},
     *      description="Update Bookmarks",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Bookmarks",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Bookmarks that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Bookmarks")
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
     *                  ref="#/definitions/Bookmarks"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBookmarksAPIRequest $request)
    {
        $input = $request->all();

        /** @var Bookmarks $bookmarks */
        $bookmarks = $this->bookmarksRepository->findWithoutFail($id);

        if (empty($bookmarks)) {
            return $this->sendError('Bookmarks not found');
        }

        $bookmarks = $this->bookmarksRepository->update($input, $id);

        return $this->sendResponse($bookmarks->toArray(), 'Bookmarks updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/bookmarks/{id}",
     *      summary="Remove the specified Bookmarks from storage",
     *      tags={"Bookmarks"},
     *      description="Delete Bookmarks",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Bookmarks",
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
        /** @var Bookmarks $bookmarks */
        $bookmarks = $this->bookmarksRepository->findWithoutFail($id);

        if (empty($bookmarks)) {
            return $this->sendError('Bookmarks not found');
        }

        $bookmarks->delete();

        return $this->sendResponse($id, 'Bookmarks deleted successfully');
    }


}
