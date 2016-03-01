<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:11
 */

namespace SdcProject\Services;


use Prettus\Validator\Exceptions\ValidatorException;
use SdcProject\Repositories\ProjectMemberRepository;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Validators\ProjectValidator;

class ProjectService {

    protected $projectRepository;
    protected $projectValidator;
    protected $projectMemberRepository;

    /**
     * @param ProjectRepository $projectRepository
     * @param ProjectMemberRepository $projectMemberRepository
     * @param ProjectValidator $projectValidator
     */
    public function __construct(ProjectRepository $projectRepository, ProjectMemberRepository $projectMemberRepository, ProjectValidator $projectValidator) {
        $this->projectRepository = $projectRepository;
        $this->projectValidator = $projectValidator;
        $this->projectMemberRepository = $projectMemberRepository;
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

    public function addMember($idProject, array $data) {
        $project = $this->projectRepository->find($idProject);
        return $project->projectMembers()->attach($data);
    }

    public function removeMember($idProject, $idMember) {
        $project = $this->projectRepository->find($idProject);
        return $project->projectMembers()->detach($idMember);
    }

    public function isMember($idProject, $idMember) {
        $project = $this->projectRepository->find($idProject);
        return $project->projectMembers()->find($idMember);
    }


}