<?php


    namespace SdcProject\Services;

    use Illuminate\Filesystem\Filesystem;
    use LucaDegasperi\OAuth2Server\Facades\Authorizer;
    use Prettus\Validator\Contracts\ValidatorInterface;
    use Prettus\Validator\Exceptions\ValidatorException;
    use SdcProject\Repositories\ProjectFileRepository;
    use SdcProject\Repositories\ProjectRepository;
    use SdcProject\Validators\ProjectFileValidator;
    use Illuminate\Contracts\Filesystem\Factory as Storage;

    class ProjectFileService {

        protected $projectFileRepository;
        protected $projectRepository;
        protected $projectService;
        protected $projectFileValidator;
        protected $projectMemberRepository;
        private $fileSystem;
        private $storage;


        /**
         * ProjectFileService constructor.
         * @param ProjectFileRepository $projectFileRepository
         * @param ProjectRepository $projectRepository
         * @param ProjectService $projectService
         * @param ProjectFileValidator $projectFileValidator
         * @param Filesystem $fileSystem
         * @param Storage $storage
         */
        public function __construct(ProjectFileRepository $projectFileRepository,
                                    ProjectRepository $projectRepository,
                                    ProjectService $projectService,
                                    ProjectFileValidator $projectFileValidator,
                                    Filesystem $fileSystem,
                                    Storage $storage) {

            $this->projectFileRepository = $projectFileRepository;
            $this->projectRepository = $projectRepository;
            $this->projectFileValidator = $projectFileValidator;
            $this->fileSystem = $fileSystem;
            $this->storage = $storage;
            $this->projectService = $projectService;
        }

        public function create(array $data) {
            try {
                $this->projectFileValidator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
                $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
                $projectFile = $project->files()->create($data);

                $this->storage->put($projectFile->id . '.' . $data['extension'], $this->fileSystem->get($data['file']));

                return $projectFile;
            } catch (ValidatorException $e) {
                return [
                    'error' => true,
                    'message' => $e->getMessageBag()
                ];
            }
        }

        public function update(array $data, $id) {
            try {
                $this->projectFileValidator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
                return $this->projectFileRepository->update($data, $id);
            } catch (ValidatorException $e) {
                return [
                    'error' => true,
                    'message' => $e->getMessageBag()
                ];
            }
        }

        public function delete($id) {
            $projectFile = $this->projectFileRepository->skipPresenter()->find($id);
            if ($this->storage->exists($projectFile->id . '.' . $projectFile->extension)) {
                $this->storage->delete($projectFile->id . '.' . $projectFile->extension);
                $projectFile->delete();
            }
        }

        public function getFilePath($id) {
            $projectFile = $this->projectFileRepository->skipPresenter()->find($id);
            return $this->getBaseUrl($projectFile);
        }

        public function getFileName($fileId) {
            $projectFile = $this->projectFileRepository->skipPresenter()->find($fileId);
            return $projectFile->getFileName();
        }

        private function getBaseUrl($projectFile) {
            switch ($this->storage->getDefaultDriver()) {
                case 'local':
                    return $this->storage->getDriver()->getAdapter()->getPathPrefix() . '/' . $projectFile->getFileName();
            }
        }

        public function checkProjectOwner($projectFileId) {
            $userId = Authorizer::getResourceOwnerId();
            $projectId = $this->projectFileRepository->skipPresenter()->find($projectFileId)->project_id;
            return $this->projectService->isOwner($projectId, $userId);
        }

        public function checkProjectMember($projectFileId) {
            $userId = Authorizer::getResourceOwnerId();
            $projectId = $this->projectFileRepository->skipPresenter()->find($projectFileId)->project_id;
            return $this->projectService->hasMember($projectId, $userId);
        }

        public function checkProjectPermissions($projectFileId) {
            if ($this->checkProjectOwner($projectFileId) or $this->checkProjectMember($projectFileId)) {
                return true;
            }
            return false;
        }

    }