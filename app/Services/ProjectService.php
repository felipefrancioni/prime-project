<?php
    /**
     * Created by PhpStorm.
     * User: fgsin
     * Date: 15/10/2015
     * Time: 15:11
     */

    namespace SdcProject\Services;

    use LucaDegasperi\OAuth2Server\Facades\Authorizer;
    use Prettus\Validator\Exceptions\ValidatorException;
    use SdcProject\Repositories\ProjectRepository;
    use SdcProject\Validators\ProjectValidator;

    class ProjectService {

        protected $projectRepository;
        protected $projectValidator;

        /**
         * @param ProjectRepository $projectRepository
         * @param ProjectValidator $projectValidator
         */
        public function __construct(ProjectRepository $projectRepository, ProjectValidator $projectValidator) {
            $this->projectRepository = $projectRepository;
            $this->projectValidator = $projectValidator;
        }

        public function create(array $data) {
            try {
                $this->projectValidator->with($data)->passesOrFail();
                return $this->projectRepository->create($data);
            } catch (ValidatorException $e) {
                return [
                    'error' => true,
                    'message' => $e->getMessageBag()
                ];
            }
        }

        public function update(array $data, $id) {
            try {
                $this->projectValidator->with($data)->passesOrFail();
                return $this->projectRepository->update($data, $id);
            } catch (ValidatorException $e) {
                return [
                    'error' => true,
                    'message' => $e->getMessageBag()
                ];
            }
        }


        public function checkProjectOwner($projectId) {
            return $this->isOwner($projectId, Authorizer::getResourceOwnerId());
        }

        public function checkProjectMember($projectId) {
            return $this->hasMember($projectId, Authorizer::getResourceOwnerId());
        }

        public function checkProjectPermissions($projectId) {
            return $this->checkProjectMember($projectId) || $this->checkProjectOwner($projectId);
        }

        public function hasMember($idProject, $idMember) {
            $project = $this->projectRepository->skipPresenter()->find($idProject);
            return $project->projectMembers()->find($idMember);
        }

        public function isOwner($projectId, $userId) {
            $project = $this->projectRepository->skipPresenter()->find($projectId);
            return $project->owner()->find($userId);
        }

    }