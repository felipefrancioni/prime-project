<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use SdcProject\Http\Requests;
use SdcProject\Presenters\ProjectPresenter;
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->projectRepository->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
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
     * @param Request $request
     * @param $idProject
     * @return array
     */
    public function storeNewMember(Request $request, $idProject) {
        try {
            //            if (!$this->checkProjectPermissions($id)) {
            //                return ['error' => 'Access forbidden!'];
            //            }
            return $this->projectService->addMember($idProject, $request->all());
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        } catch (QueryException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            //            if (!$this->checkProjectPermissions($id)) {
            //                return ['error' => 'Access forbidden!'];
            //            }
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
     * This function display the members of project.
     * @param $id
     * @return array|mixed
     */
    public function showMembers($id) {
        try {
            //            if (!$this->checkProjectPermissions($id)) {
            //                return ['error' => 'Access forbidden!'];
            //            }
            return $this->projectService->showMembers($id);//showMembers($id);
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
            if (!$this->checkProjectOwner($id)) {
                return ['error' => 'Access forbidden!'];
            }
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
            if (!$this->checkProjectPermissions($id)) {
                return ['error' => 'Access forbidden!'];
            }
            return $this->projectRepository->delete($id);
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }

    }

    public function destroyMember($idProject, $idMember) {
        try {
            if (!$this->checkProjectPermissions($idProject)) {
                return ['error' => 'Access forbidden!'];
            }
            return $this->projectService->removeMember($idProject, $idMember);
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }

    }

    public function isMember($idProject, $idMember) {
        try {
            $member = $this->projectService->isMember($idProject, $idMember);
            return $member ? 'true' : 'false';
        } catch (ModelNotFoundException $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }

    }


    private function checkProjectOwner($projectId) {
        return $this->projectService->isOwner($projectId, Authorizer::getResourceOwnerId());
    }

    private function checkProjectMember($projectId) {
        return $this->projectService->isMember($projectId, Authorizer::getResourceOwnerId());
    }

    private function checkProjectPermissions($projectId) {
        return $this->checkProjectMember($projectId) || $this->checkProjectOwner($projectId);
    }


}
