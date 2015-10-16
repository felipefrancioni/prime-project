<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Http\Request;
use SdcProject\Http\Requests;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Services\ProjectService;

class ProjectController extends Controller {

    private $projectRepository;
    private $projectService;

    /**
     * @param ProjectRepository $projectRepository
     * @param ProjectService $projectService
     */
    public function __construct(ProjectRepository $projectRepository, ProjectService $projectService) {
        $this->projectRepository = $projectRepository;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->projectRepository->with([
            'owner',
            'client'
        ])->all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return $this->projectService->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return $this->projectRepository->with([
            'owner',
            'client'
        ])->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        return $this->projectService->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->projectRepository->delete($id);
    }
}
