<?php
    /**
     * Created by PhpStorm.
     * User: fgsin
     * Date: 15/10/2015
     * Time: 15:11
     */

    namespace SdcProject\Services;

    use Illuminate\Database\QueryException;
    use Prettus\Validator\Exceptions\ValidatorException;
    use SdcProject\Repositories\ProjectRepository;
    use SdcProject\Repositories\ProjectTaskRepository;
    use SdcProject\Validators\ProjectTaskValidator;


    class ProjectTaskService {

        protected $projectTaskRepository;
        protected $projectTaskValidator;
        /**
         * @var ProjectRepository
         */
        private $projectRepository;

        /**
         * @param ProjectRepository $projectRepository
         * @param ProjectTaskRepository $projectTaskRepository
         * @param ProjectTaskValidator $projectTaskValidator
         */
        public function __construct(ProjectRepository $projectRepository, ProjectTaskRepository $projectTaskRepository, ProjectTaskValidator $projectTaskValidator) {
            $this->projectTaskRepository = $projectTaskRepository;
            $this->projectTaskValidator = $projectTaskValidator;
            $this->projectRepository = $projectRepository;
        }

        public function create(array $data) {
            try {
                $this->projectTaskValidator->with($data)->passesOrFail();
                $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
                $projectTask = $project->projectTasks()->create($data);
                return $projectTask;
            } catch (QueryException $e) {
                return [
                    'error' => true,
                    'message' => $e->getMessage()
                ];
            } catch (ValidatorException $e) {
                return [
                    'error' => true,
                    'message' => $e->getMessageBag()
                ];
            }
        }

        function update(array $data, $taskId) {
            try {
                $this->projectTaskValidator->with($data)->passesOrFail();
                return $this->projectTaskRepository->update($data, $taskId);
            } catch (ValidatorException $e) {
                return [
                    'error' => true,
                    'message' => $e->getMessageBag()
                ];
            }
        }

        public function delete($projectId, $taskId) {
            $task = $this->projectTaskRepository->findWhere([
                'project_id' => $projectId,
                'id' => $taskId
            ]);
            if (count($task) > 0) {
                $this->projectTaskRepository->delete($taskId);
            } else {
                throw new \Exception("A task que voce quer excluir nao existe para o projeto selecionado.");
            }

        }
    }