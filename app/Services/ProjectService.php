<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:11
 */

namespace SdcProject\Services;


use League\Fractal\Manager;
use Prettus\Repository\Presenter\FractalPresenter;
use Prettus\Validator\Exceptions\ValidatorException;
use SdcProject\Presenters\ProjectMembersPresenter;
use SdcProject\Presenters\ProjectPresenter;
use SdcProject\Presenters\UserPresenter;
use SdcProject\Repositories\ProjectMemberRepository;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Transformers\ProjectMembersTransformer;
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

    public function showMembers($projectId) {
        $project = $this->projectRepository->skipPresenter()->find($projectId);
        return $project->projectMembers()->get();
    }

    public function addMember($idProject, array $data) {
        $project = $this->projectRepository->skipPresenter()->find($idProject);
        return $project->projectMembers()->attach($data);
    }

    public function removeMember($idProject, $idMember) {
        $project = $this->projectRepository->skipPresenter()->find($idProject);
        return $project->projectMembers()->detach($idMember);
    }

    public function isMember($idProject, $idMember) {
        $project = $this->projectRepository->skipPresenter()->find($idProject);
        return $project->projectMembers()->find($idMember);
    }

    public function isOwner($projectId, $userId) {
        $project = $this->projectRepository->skipPresenter()->find($projectId);
        return $project->owner()->find($userId);
    }


}