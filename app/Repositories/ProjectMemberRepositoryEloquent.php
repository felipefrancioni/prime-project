<?php

namespace SdcProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use SdcProject\Presenters\ProjectMembersPresenter;
use SdcProject\Entities\ProjectMember;

/**
 * Class ProjectMemberRepositoryEloquent
 * @package namespace SdcProject\Repositories;
 */
class ProjectMemberRepositoryEloquent extends BaseRepository implements ProjectMemberRepository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return ProjectMember::class;
    }

    public function presenter() {
        return ProjectMembersPresenter::class;
    }

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

}
