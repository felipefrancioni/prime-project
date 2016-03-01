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

    public function update(array $data, $id) {
        try {
            $this->projectTaskValidator->with($data)->passesOrFail();
            return $this->projectTaskRepository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }


}