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
use SdcProject\Validators\ProjectMemberValidator;


class ProjectMemberService
{

    protected $projectMemberRepository;
    protected $projectMemberValidator;


    /**
     * ProjectMemberService constructor.
     * @param ProjectMemberRepository $projectMemberRepository
     * @param ProjectMemberValidator $projectMemberValidator
     */
    public function __construct(ProjectMemberRepository $projectMemberRepository, ProjectMemberValidator $projectMemberValidator)
    {
        $this->projectMemberRepository = $projectMemberRepository;
        $this->projectMemberValidator = $projectMemberValidator;
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


    public function delete($id)
    {
        $projectMember = $this->projectMemberRepository->skipPresenter()->find($id);
        return $projectMember->delete();
    }
}