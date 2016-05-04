<?php

    namespace SdcProject\Repositories;


    use Prettus\Repository\Eloquent\BaseRepository;
    use SdcProject\Entities\ProjectFile;
    use SdcProject\Presenters\ProjectFilePresenter;

    class ProjectFileRepositoryEloquent extends BaseRepository implements ProjectFileRepository {

        /**
         * Specify Model class name
         *
         * @return string
         */
        public function model() {
            return ProjectFile::class;
        }

        public function presenter() {
            return ProjectFilePresenter::class;
        }
    }