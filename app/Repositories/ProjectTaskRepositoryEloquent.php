<?php

    namespace SdcProject\Repositories;

    use Prettus\Repository\Eloquent\BaseRepository;
    use SdcProject\Presenters\ProjectTasksPresenter;
    use SdcProject\Entities\ProjectTask;

    /**
     * Class ProjectTaskRepositoryEloquent
     * @package namespace SdcProject\Repositories;
     */
    class ProjectTaskRepositoryEloquent extends BaseRepository implements ProjectTaskRepository {
        /**
         * Specify Model class name
         *
         * @return string
         */
        public function model() {
            return ProjectTask::class;
        }

        public function presenter() {
            return ProjectTasksPresenter::class;
        }

        public function boot() {
            $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        }


    }
