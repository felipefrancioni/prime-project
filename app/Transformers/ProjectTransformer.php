<?php

    namespace SdcProject\Transformers;

    use League\Fractal\TransformerAbstract;
    use LucaDegasperi\OAuth2Server\Facades\Authorizer;
    use SdcProject\Entities\Project;

    class ProjectTransformer extends TransformerAbstract {

        protected $defaultIncludes = [
            'client',
            'owner',
            'members',
            'notes',
            'tasks',
            'files'
        ];

        public function transform(Project $project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'client_id' => $project->client_id,
                'owner_id' => $project->owner_id,
                'description' => $project->description,
                'progress' => intval($project->progress),
                'status' => intval($project->status),
                'due_date' => $project->due_date,
                'isMember' => $project->owner_id != Authorizer::getResourceOwnerId(),
                'tasks_count' => $project->projectTasks->count(),
                'tasks_opened' => $this->countTasksOpened($project)
            ];
        }

        public function includeOwner(Project $project) {
            return $this->item($project->owner, new UserTransformer());
        }

        public function includeClient(Project $project) {
            return $this->item($project->client, new ClientTransformer());
        }

        public function includeMembers(Project $project) {
            return $this->collection($project->projectMembers, new MemberTransformer());
        }

        public function includeNotes(Project $project) {
            return $this->collection($project->projectNotes, new ProjectNotesTransformer());
        }

        public function includeFiles(Project $project) {
            return $this->collection($project->files, new ProjectFileTransformer());
        }

        public function includeTasks(Project $project) {
            return $this->collection($project->projectTasks, new ProjectTasksTransformer());
        }

        public function countTasksOpened(Project $project) {
            $count = 0;
            foreach ($project->projectTasks as $task) {
                if ($task->status == 1) {
                    $count++;
                }
            }
            return $count;
        }

    }