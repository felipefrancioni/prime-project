<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:11
 */

namespace SdcProject\Services;

use Illuminate\Filesystem\Filesystem;
use Prettus\Validator\Exceptions\ValidatorException;
use SdcProject\Repositories\ProjectMemberRepository;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Validators\ProjectValidator;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService {

    protected $projectRepository;
    protected $projectValidator;
    protected $projectMemberRepository;
    /**
     * @var Filesystem
     */
    private $fileSystem;
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @param ProjectRepository $projectRepository
     * @param ProjectMemberRepository $projectMemberRepository
     * @param ProjectValidator $projectValidator
     * @param Filesystem $fileSystem
     * @param Storage $storage
     */
    public function __construct(ProjectRepository $projectRepository, ProjectMemberRepository $projectMemberRepository, ProjectValidator $projectValidator, Filesystem $fileSystem, Storage $storage) {
        $this->projectRepository = $projectRepository;
        $this->projectValidator = $projectValidator;
        $this->projectMemberRepository = $projectMemberRepository;
        $this->fileSystem = $fileSystem;
        $this->storage = $storage;
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
        return $this->projectMemberRepository->findWhere(['project_id' => $projectId]);
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

    public function createFile(array $data) {
        $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);
        $this->storage->put($projectFile->id . '.' . $data['extension'], $this->fileSystem->get($data['file']));
    }

    public function removeFile($projectId, $fileId) {
        $project = $this->projectRepository->skipPresenter()->find($projectId);
        $file = $project->files()->find($fileId);
        $project->files()->delete($fileId);
        if ($file) {
            $this->storage->delete($fileId . '.' . $file->extension);
        }
    }

}