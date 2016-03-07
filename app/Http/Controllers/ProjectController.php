<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
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
     * @param Request $request
     * @param $idProject
     * @return array
     */
    public function storeNewMember(Request $request, $idProject) {
        try {
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
            return $this->projectRepository->with([
                'owner',
                'client',
                'projectTasks'
            ])->find($id);
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
            return $this->projectService->showMembers($id);
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
}
