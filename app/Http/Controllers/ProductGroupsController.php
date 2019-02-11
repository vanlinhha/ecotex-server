<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductGroupsRequest;
use App\Http\Requests\UpdateProductGroupsRequest;
use App\Repositories\ProductGroupsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ProductGroupsController extends AppBaseController
{
    /** @var  ProductGroupsRepository */
    private $productGroupsRepository;

    public function __construct(ProductGroupsRepository $productGroupsRepo)
    {
        $this->productGroupsRepository = $productGroupsRepo;
    }

    /**
     * Display a listing of the ProductGroups.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->productGroupsRepository->pushCriteria(new RequestCriteria($request));
        $productGroups = $this->productGroupsRepository->all();

        return view('product_groups.index')
            ->with('productGroups', $productGroups);
    }

    /**
     * Show the form for creating a new ProductGroups.
     *
     * @return Response
     */
    public function create()
    {
        return view('product_groups.create');
    }

    /**
     * Store a newly created ProductGroups in storage.
     *
     * @param CreateProductGroupsRequest $request
     *
     * @return Response
     */
    public function store(CreateProductGroupsRequest $request)
    {
        $input = $request->all();

        $productGroups = $this->productGroupsRepository->create($input);

        Flash::success('Product Groups saved successfully.');

        return redirect(route('productGroups.index'));
    }

    /**
     * Display the specified ProductGroups.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productGroups = $this->productGroupsRepository->findWithoutFail($id);

        if (empty($productGroups)) {
            Flash::error('Product Groups not found');

            return redirect(route('productGroups.index'));
        }

        return view('product_groups.show')->with('productGroups', $productGroups);
    }

    /**
     * Show the form for editing the specified ProductGroups.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productGroups = $this->productGroupsRepository->findWithoutFail($id);

        if (empty($productGroups)) {
            Flash::error('Product Groups not found');

            return redirect(route('productGroups.index'));
        }

        return view('product_groups.edit')->with('productGroups', $productGroups);
    }

    /**
     * Update the specified ProductGroups in storage.
     *
     * @param  int              $id
     * @param UpdateProductGroupsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductGroupsRequest $request)
    {
        $productGroups = $this->productGroupsRepository->findWithoutFail($id);

        if (empty($productGroups)) {
            Flash::error('Product Groups not found');

            return redirect(route('productGroups.index'));
        }

        $productGroups = $this->productGroupsRepository->update($request->all(), $id);

        Flash::success('Product Groups updated successfully.');

        return redirect(route('productGroups.index'));
    }

    /**
     * Remove the specified ProductGroups from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productGroups = $this->productGroupsRepository->findWithoutFail($id);

        if (empty($productGroups)) {
            Flash::error('Product Groups not found');

            return redirect(route('productGroups.index'));
        }

        $this->productGroupsRepository->delete($id);

        Flash::success('Product Groups deleted successfully.');

        return redirect(route('productGroups.index'));
    }
}
