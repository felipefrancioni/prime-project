<?php

    namespace SdcProject\Repositories;


    use Prettus\Repository\Eloquent\BaseRepository;
    use SdcProject\Entities\Project;
    use SdcProject\Presenters\ProjectPresenter;

    class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository {

        /**
         * Specify Model class name
         *
         * @return string
         */
        public function model() {
            return Project::class;
        }

        public function presenter() {
            return ProjectPresenter::class;
        }


        public function findWithOwnerAndMember($userId) {
            return $this->scopeQuery(function ($query) use ($userId) {
                return $query->select('projects.*')
                    ->leftJoin('project_members', 'project_members.project_id', '=', 'projects.id')
                    ->where('project_members.user_id', '=', $userId)
                    ->union($this->model->query()->getQuery()->where('owner_id', '=', $userId));
            })->all();
        }

        public function hasMember($projectId, $memberId) {
            $project = $this->skipPresenter()->find($projectId);
            foreach ($project->projectMembers as $member) {
                if ($member->id == $memberId) {
                    return true;
                }
            }
            return false;
        }

        public function isOwner($projectId, $userId) {
            if (count($this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
                return true;
            }
            return false;
        }
    }