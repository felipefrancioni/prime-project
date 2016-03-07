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
use SdcProject\Repositories\ProjectTaskRepository;
use SdcProject\Validators\ProjectTaskValidator;


class ProjectTaskService {

    protected $projectTaskRepository;
    protected $projectTaskValidator;

    /**
     * @param ProjectTaskRepository $projectTaskRepository
     * @param ProjectTaskValidator $projectTaskValidator
     */
    public function __construct(ProjectTaskRepository $projectTaskRepository, ProjectTaskValidator $projectTaskValidator) {
        $this->projectTaskRepository = $projectTaskRepository;
        $this->projectTaskValidator = $projectTaskValidator;
    }

    public function create(array $data) {
        try {
            $this->projectTaskValidator->with($data)->passesOrFail();
            return $this->projectTaskRepository->create($data);
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


    /**
     * @param array $data
     * @param $projectId
     * @param $taskId
     * @return array|mixed
     * @throws ValidatorException
     * @throws \Exception
     */
    public function update(array $data, $projectId, $taskId) {
        $this->projectTaskValidator->with($data)->passesOrFail();

        $task = $this->projectTaskRepository->findWhere([
            'project_id' => $projectId,
            'id' => $taskId
        ]);
        if (count($task) > 0) {
            return $this->projectTaskRepository->update($data, $taskId);
        }

        throw new \Exception("A Task que voce quer atualizar nao existe para o projeto selecionado.");

    }

    public function delete($projectId, $taskId) {
        $task = $this->projectTaskRepository->findWhere([
            'project_id' => $projectId,
            'id' => $taskId
        ]);
        if (count($task) > 0) {
            $this->projectTaskRepository->delete($taskId);
        } else {
            throw new \Exception("A Task que voce quer excluir nao existe para o projeto selecionado.");
        }
    }
}