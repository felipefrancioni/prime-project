<?php

    namespace SdcProject\Http\Controllers;

    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use LucaDegasperi\OAuth2Server\Facades\Authorizer;
    use SdcProject\Http\Requests;
    use SdcProject\Repositories\ProjectRepository;
    use SdcProject\Services\ProjectService;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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

            $this->middleware('check-project-owner', ['except' => ['index', 'store', 'show']]);
            $this->middleware('check-project-permission', ['except' => ['index', 'store', 'update', 'destroy']]);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request) {
            return $this->projectRepository->findOwner(Authorizer::getResourceOwnerId(), $request->query->get('limit'));
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
            try {
                return $this->projectRepository->find($id);
            } catch (NotFoundHttpException $ex) {
                return [
                    'error' => true,
                    'message' => $ex->getMessage()
                ];
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
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id) {
            try {
                return $this->projectService->update($request->all(), $id);
            } catch (ModelNotFoundException $ex) {
                return [
                    'error' => true,
                    'message' => $ex->getMessage()
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
                $this->projectRepository->delete($id);
            } catch (ModelNotFoundException $ex) {
                return [
                    'error' => true,
                    'message' => $ex->getMessage()
                ];
            }

        }
    }
