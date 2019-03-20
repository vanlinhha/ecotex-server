<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductPostsRequest;
use App\Http\Requests\UpdateProductPostsRequest;
use App\Repositories\ProductPostsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ProductPostsController extends AppBaseController
{
    /** @var  ProductPostsRepository */
    private $productPostsRepository;

    public function __construct(ProductPostsRepository $productPostsRepo)
    {
        $this->productPostsRepository = $productPostsRepo;
    }

    /**
     * Display a listing of the ProductPosts.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->productPostsRepository->pushCriteria(new RequestCriteria($request));
        $productPosts = $this->productPostsRepository->all();

        return view('product_posts.index')
            ->with('productPosts', $productPosts);
    }

    /**
     * Show the form for creating a new ProductPosts.
     *
     * @return Response
     */
    public function create()
    {
        return view('product_posts.create');
    }

    /**
     * Store a newly created ProductPosts in storage.
     *
     * @param CreateProductPostsRequest $request
     *
     * @return Response
     */
    public function store(CreateProductPostsRequest $request)
    {
        $input = $request->all();

        $productPosts = $this->productPostsRepository->create($input);

        Flash::success('Product Posts saved successfully.');

        return redirect(route('productPosts.index'));
    }

    /**
     * Display the specified ProductPosts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            Flash::error('Product Posts not found');

            return redirect(route('productPosts.index'));
        }

        return view('product_posts.show')->with('productPosts', $productPosts);
    }

    /**
     * Show the form for editing the specified ProductPosts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            Flash::error('Product Posts not found');

            return redirect(route('productPosts.index'));
        }

        return view('product_posts.edit')->with('productPosts', $productPosts);
    }

    /**
     * Update the specified ProductPosts in storage.
     *
     * @param  int              $id
     * @param UpdateProductPostsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductPostsRequest $request)
    {
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            Flash::error('Product Posts not found');

            return redirect(route('productPosts.index'));
        }

        $productPosts = $this->productPostsRepository->update($request->all(), $id);

        Flash::success('Product Posts updated successfully.');

        return redirect(route('productPosts.index'));
    }

    /**
     * Remove the specified ProductPosts from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productPosts = $this->productPostsRepository->findWithoutFail($id);

        if (empty($productPosts)) {
            Flash::error('Product Posts not found');

            return redirect(route('productPosts.index'));
        }

        $this->productPostsRepository->delete($id);

        Flash::success('Product Posts deleted successfully.');

        return redirect(route('productPosts.index'));
    }
}
