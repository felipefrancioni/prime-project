<?php

namespace SdcProject\Repositories;


use Prettus\Repository\Eloquent\BaseRepository;
use SdcProject\Entities\Project;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Project::class;
    }
}