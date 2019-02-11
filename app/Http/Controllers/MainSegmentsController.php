<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMainSegmentsRequest;
use App\Http\Requests\UpdateMainSegmentsRequest;
use App\Repositories\MainSegmentsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MainSegmentsController extends AppBaseController
{
    /** @var  MainSegmentsRepository */
    private $mainSegmentsRepository;

    public function __construct(MainSegmentsRepository $mainSegmentsRepo)
    {
        $this->mainSegmentsRepository = $mainSegmentsRepo;
    }

    /**
     * Display a listing of the MainSegments.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->mainSegmentsRepository->pushCriteria(new RequestCriteria($request));
        $mainSegments = $this->mainSegmentsRepository->all();

        return view('main_segments.index')
            ->with('mainSegments', $mainSegments);
    }

    /**
     * Show the form for creating a new MainSegments.
     *
     * @return Response
     */
    public function create()
    {
        return view('main_segments.create');
    }

    /**
     * Store a newly created MainSegments in storage.
     *
     * @param CreateMainSegmentsRequest $request
     *
     * @return Response
     */
    public function store(CreateMainSegmentsRequest $request)
    {
        $input = $request->all();

        $mainSegments = $this->mainSegmentsRepository->create($input);

        Flash::success('Main Segments saved successfully.');

        return redirect(route('mainSegments.index'));
    }

    /**
     * Display the specified MainSegments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mainSegments = $this->mainSegmentsRepository->findWithoutFail($id);

        if (empty($mainSegments)) {
            Flash::error('Main Segments not found');

            return redirect(route('mainSegments.index'));
        }

        return view('main_segments.show')->with('mainSegments', $mainSegments);
    }

    /**
     * Show the form for editing the specified MainSegments.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mainSegments = $this->mainSegmentsRepository->findWithoutFail($id);

        if (empty($mainSegments)) {
            Flash::error('Main Segments not found');

            return redirect(route('mainSegments.index'));
        }

        return view('main_segments.edit')->with('mainSegments', $mainSegments);
    }

    /**
     * Update the specified MainSegments in storage.
     *
     * @param  int              $id
     * @param UpdateMainSegmentsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMainSegmentsRequest $request)
    {
        $mainSegments = $this->mainSegmentsRepository->findWithoutFail($id);

        if (empty($mainSegments)) {
            Flash::error('Main Segments not found');

            return redirect(route('mainSegments.index'));
        }

        $mainSegments = $this->mainSegmentsRepository->update($request->all(), $id);

        Flash::success('Main Segments updated successfully.');

        return redirect(route('mainSegments.index'));
    }

    /**
     * Remove the specified MainSegments from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mainSegments = $this->mainSegmentsRepository->findWithoutFail($id);

        if (empty($mainSegments)) {
            Flash::error('Main Segments not found');

            return redirect(route('mainSegments.index'));
        }

        $this->mainSegmentsRepository->delete($id);

        Flash::success('Main Segments deleted successfully.');

        return redirect(route('mainSegments.index'));
    }
}
