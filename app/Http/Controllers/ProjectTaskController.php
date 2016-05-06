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
         * @param $projectId
         * @return \Illuminate\Http\Response
         */
        public function index($projectId) {
            return $this->projectTaskRepository->findWhere(['project_id' => $projectId]);
        }


        /**
         * @param Request $request
         * @param $projectId
         * @return array
         */
        public function store(Request $request, $projectId) {
            $data = $request->all();
            $data['project_id'] = $projectId;
            return $this->projectTaskService->create($data);
        }


        public function show($projectId, $taskId) {
            return $this->projectTaskRepository->find($taskId);
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
            $data = $request->all();
            $data['project_id'] = $projectId;
            return $this->projectTaskService->update($data, $taskId);
        }

        
        public function destroy($projectId, $taskId) {
            $this->projectTaskService->delete($projectId, $taskId);
        }
    }
