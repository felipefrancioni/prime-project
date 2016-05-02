<?php

namespace SdcProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use SdcProject\Presenters\ProjectNotesPresenter;
use SdcProject\Entities\ProjectNote;

/**
 * Class ProjectNoteRepositoryEloquent
 * @package namespace SdcProject\Repositories;
 */
class ProjectNoteRepositoryEloquent extends BaseRepository implements ProjectNoteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectNote::class;
    }

    public function presenter()
    {
        return ProjectNotesPresenter::class;
    }

}
