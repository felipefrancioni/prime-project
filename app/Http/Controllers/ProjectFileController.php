<?php

namespace SdcProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use SdcProject\Http\Requests;
use SdcProject\Services\ProjectService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProjectFileController extends Controller {

    private $projectService;

    /**
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService) {
        $this->projectService = $projectService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $data['file'] = $file;
            $data['name'] = $request->name;
            $data['description'] = $request->description;
            $data['extension'] = $extension;
            $data['project_id'] = $request->project_id;
            $this->projectService->createFile($data);
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
     * Remove the specified resource from storage.
     *
     * @param $projectId
     * @param $fileId
     * @return array
     */
    public function destroy($projectId, $fileId) {
        try {
            $this->projectService->removeFile($projectId, $fileId);
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

}
