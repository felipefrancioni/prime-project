<?php

    namespace SdcProject\Http\Controllers;

    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Prettus\Validator\Exceptions\ValidatorException;
    use SdcProject\Http\Requests;
    use SdcProject\Repositories\ProjectMemberRepository;
    use SdcProject\Repositories\ProjectRepository;
    use SdcProject\Repositories\ProjectTaskRepository;
    use SdcProject\Services\ProjectMemberService;
    use SdcProject\Services\ProjectTaskService;

    class ProjectMemberController extends Controller {
        private $projectMemberRepository;
        private $projectMemberService;


        /**
         * ProjectMemberController constructor.
         * @param ProjectMemberRepository $projectMemberRepository
         * @param ProjectMemberService $projectMemberService
         */
        public function __construct(ProjectMemberRepository $projectMemberRepository, ProjectMemberService $projectMemberService) {
            $this->projectMemberRepository = $projectMemberRepository;
            $this->projectMemberService = $projectMemberService;

            $this->middleware('check-project-owner', ['except' => ['index', 'show']]);
            $this->middleware('check-project-permission', ['except' => ['store', 'destroy']]);
        }

        /**
         * Display a listing of the resource.
         *
         * @param $projectId
         * @return \Illuminate\Http\Response
         */
        public function index($projectId) {
            return $this->projectMemberRepository->findWhere(['project_id' => $projectId]);
        }


        /**
         * @param Request $request
         * @param $projectId
         * @return array
         */
        public function store(Request $request, $projectId) {
            $data = $request->all();
            $data['project_id'] = $projectId;
            return $this->projectMemberService->create($data);
        }


        public function show($projectId, $memberId) {
            $result = $this->projectMemberRepository->findWhere(['project_id' => $projectId, 'user_id' => $memberId]);
            if(isset($result['data']) && count($result['data']) == 1) {
                $result = [
                    'data' => $result['data'][0]
                ];
            }
            return $result;
        }

        public function destroy($projectId, $memberId) {
            $this->projectMemberService->delete($projectId, $memberId);
        }
    }
