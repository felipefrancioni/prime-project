<?php

    namespace SdcProject\Http\Controllers;

    use Illuminate\Http\Request;
    use SdcProject\Http\Requests;
    use SdcProject\Repositories\ProjectFileRepository;
    use SdcProject\Services\ProjectFileService;
    use Illuminate\Contracts\Filesystem\Factory as Storage;


    class ProjectFileController extends Controller {

        private $projectFileService;
        private $projectFileRepository;
        private $storage;

        /**
         * @param ProjectFileService $projectFileService
         * @param ProjectFileRepository $projectFileRepository
         */
        public function __construct(ProjectFileService $projectFileService, ProjectFileRepository $projectFileRepository, Storage $storage) {
            $this->projectFileService = $projectFileService;
            $this->projectFileRepository = $projectFileRepository;
            $this->storage = $storage;
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


        public function showFile($projectId, $fileId) {
            $model = $this->projectFileRepository->skipPresenter()->find($fileId);
            $filePath = $this->projectFileService->getFilePath($fileId);
            $fileContent = file_get_contents($filePath);
            $file64 = base64_encode($fileContent);
            return [
                'file' => $file64,
                'size' => filesize($filePath),
                'name' => $this->projectFileService->getFileName($fileId),
                'mime_type' => $this->storage->mimeType($model->getFileName())
            ];
        }

        public function show($projectId, $fileId) {
            return $this->projectFileRepository->find($fileId);
        }

        public function update(Request $request, $projectId, $fileId) {
            return $this->projectFileService->update($request->all(), $fileId);
        }

        public function destroy($projectId, $fileId) {
            return $this->projectFileService->delete($fileId);

        }

    }
