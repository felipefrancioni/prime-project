<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use SdcProject\Http\Requests;
use SdcProject\Repositories\ProjectTaskRepository;
use SdcProject\Services\ProjectTaskService;

class ProjectTaskController extends Controller {
    private $projectTaskRepository;
    private $projectTaskService;

    /**
     * @param ProjectTaskRepository $projectTaskRepository
     * @param ProjectTaskService $projectTaskService
     */
    public function __construct(ProjectTaskRepository $projectTaskRepository, ProjectTaskService $projectTaskService) {
        $this->projectTaskRepository = $projectTaskRepository;
        $this->projectTaskService = $projectTaskService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->projectTaskRepository->with([
            'project'
        ])->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return $this->projectTaskService->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            return $this->projectTaskRepository->with([
                'project'
            ])->find($id);
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $idTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idTask) {
        try {
            return $this->projectTaskService->update($request->all(), $idTask);
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        } catch (QueryException $ex2) {
            return [
                'error' => true,
                'message' => $ex2->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            return $this->projectTaskRepository->delete($id);
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        } catch (QueryException $ex2) {
            return [
                'error' => true,
                'message' => $ex2->getMessage()
            ];
        }
    }
}
