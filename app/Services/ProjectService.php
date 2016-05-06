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
            $userId = Authorizer::getResourceOwnerId();
            return $this->projectRepository->isOwner($projectId, $userId);
        }

        public function checkProjectMember($projectId) {
            $userId = Authorizer::getResourceOwnerId();
            return $this->projectRepository->hasMember($projectId, $userId);
        }

        public function checkProjectPermissions($projectId) {
            if ($this->checkProjectOwner($projectId) || $this->checkProjectMember($projectId)) {
                return true;
            }
            return false;
        }
    }