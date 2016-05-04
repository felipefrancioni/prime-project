<?php

    namespace SdcProject\Http\Controllers;

    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use SdcProject\Http\Requests;
    use SdcProject\Repositories\ProjectFileRepository;
    use SdcProject\Services\ProjectFileService;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


    class ProjectFileController extends Controller {

        private $projectFileService;
        private $projectFileRepository;

        /**
         * @param ProjectFileService $projectFileService
         * @param ProjectFileRepository $projectFileRepository
         */
        public function __construct(ProjectFileService $projectFileService, ProjectFileRepository $projectFileRepository) {
            $this->projectFileService = $projectFileService;
            $this->projectFileRepository = $projectFileRepository;
        }

        public function index($projectId) {
            return $this->projectFileRepository->findWhere(['project_id' => $projectId]);
        }

        public function store(Request $request) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            $data['file'] = $file;
            $data['extension'] = $extension;
            $data['name'] = $request->name;
            $data['project_id'] = $request->project_id;
            $data['description'] = $request->description;

            return $this->projectFileService->create($data);
        }


        public function showFile($fileId) {
            if (!$this->projectFileService->checkProjectPermissions($fileId)) {
                return ['error' => 'Access forbidden!'];
            }
            $filePath = $this->projectFileService->getFilePath($fileId);
            $fileContent = file_get_contents($filePath);
            $file64 = base64_encode($fileContent);
            return [
                'file' => $file64,
                'size' => filesize($filePath),
                'name' => $this->projectFileService->getFileName($fileId)
            ];
        }

        public function show($fileId) {
            if (!$this->projectFileService->checkProjectPermissions($fileId)) {
                return ['error' => 'Access forbidden!'];
            }
            return $this->projectFileRepository->find($fileId);
        }

        public function update(Request $request, $fileId) {
            if (!$this->projectFileService->checkProjectOwner($fileId)) {
                return ['error' => 'Access forbidden!'];
            }
            return $this->projectFileService->update($request->all(), $fileId);
        }

        public function destroy($fileId) {
            if (!$this->projectFileService->checkProjectOwner($fileId)) {
                return ['error' => 'Access forbidden!'];
            }
            return $this->projectFileService->delete($fileId);

        }

    }
