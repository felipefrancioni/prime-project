<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use SdcProject\Http\Requests;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Repositories\ProjectTaskRepository;
use SdcProject\Services\ProjectTaskService;

class ProjectTaskController extends Controller {
    private $projectTaskRepository;
    private $projectTaskService;
    private $projectRepository;

    /**
     * @param ProjectRepository $projectRepository
     * @param ProjectTaskRepository $projectTaskRepository
     * @param ProjectTaskService $projectTaskService
     */
    public function __construct(ProjectRepository $projectRepository, ProjectTaskRepository $projectTaskRepository, ProjectTaskService $projectTaskService) {
        $this->projectTaskRepository = $projectTaskRepository;
        $this->projectTaskService = $projectTaskService;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $projectId
     * @return \Illuminate\Http\Response
     */
    public function index($projectId) {
        try {
            $project = $this->projectRepository->find($projectId);
            return $project->projectTasks()->get([
                'id',
                'name',
                'start_date',
                'due_date',
                'status'
            ]);
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }
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
     * @param $projectId
     * @param $taskId
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($projectId, $taskId) {
        try {
            return $this->projectTaskRepository->findWhere([
                'id' => $taskId,
                'project_id' => $projectId
            ]);
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
     * @param $projectId
     * @param $taskId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId, $taskId) {
        try {
            return $this->projectTaskService->update($request->all(), $projectId, $taskId);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $projectId
     * @param $taskId
     * @return array
     * @throws \Exception
     */
    public function destroy($projectId, $taskId) {
        try {
            return $this->projectTaskService->delete($projectId, $taskId);
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
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
