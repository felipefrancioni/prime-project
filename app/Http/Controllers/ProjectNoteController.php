<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use SdcProject\Http\Requests;
use SdcProject\Repositories\ProjectNoteRepository;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Services\ProjectNoteService;


class ProjectNoteController extends Controller
{
    private $projectNoteRepository;
    private $projectNoteService;
    private $projectRepository;

    /**
     * @param ProjectRepository $projectRepository
     * @param ProjectNoteRepository $projectNoteRepository
     * @param ProjectNoteService $projectNoteService
     */
    public function __construct(ProjectRepository $projectRepository, ProjectNoteRepository $projectNoteRepository, ProjectNoteService $projectNoteService)
    {
        $this->projectNoteRepository = $projectNoteRepository;
        $this->projectNoteService = $projectNoteService;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $projectId
     * @return \Illuminate\Http\Response
     */
    public function index($projectId)
    {
        try {
            return $this->projectNoteRepository->findWhere(['project_id' => $projectId]);
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
    public function store(Request $request)
    {
        return $this->projectNoteService->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param $projectId
     * @param $noteId
     * @return \Illuminate\Http\Response
     */
    public function show($projectId, $noteId)
    {
        try {
            $result = $this->projectNoteRepository->findWhere([
                'id' => $noteId,
                'project_id' => $projectId
            ]);
            if(isset($result['data']) && count($result['data']) == 1) {
                $result = [
                    'data' => $result['data'][0]
                ];
            }
            return $result;
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
     * @param $noteId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $projectId, $noteId)
    {
        try {
            return $this->projectNoteService->update($request->all(), $projectId, $noteId);
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
     * @param $noteId
     * @return array
     * @throws \Exception
     */
    public function destroy($projectId, $noteId)
    {
        try {
            return $this->projectNoteService->delete($projectId, $noteId);
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
