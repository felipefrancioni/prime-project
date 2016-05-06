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
use SdcProject\Repositories\ProjectMemberRepository;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Validators\ProjectMemberValidator;


class ProjectMemberService
{

    protected $projectMemberRepository;
    protected $projectRepository;
    protected $projectMemberValidator;


    /**
     * ProjectMemberService constructor.
     * @param ProjectMemberRepository $projectMemberRepository
     * @param ProjectMemberValidator $projectMemberValidator
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectMemberRepository $projectMemberRepository,
                                ProjectMemberValidator $projectMemberValidator,
                                ProjectRepository $projectRepository)
    {
        $this->projectMemberRepository = $projectMemberRepository;
        $this->projectMemberValidator = $projectMemberValidator;
        $this->projectRepository = $projectRepository;
    }

    public function create(array $data)
    {
        try {
            $this->projectMemberValidator->with($data)->passesOrFail();
            return $this->projectMemberRepository->create($data);
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


    public function delete($projectId, $memberId)
    {
        $project = $this->projectRepository->skipPresenter()->find($projectId);
        return $project->projectMembers()->detach($memberId);
    }
}