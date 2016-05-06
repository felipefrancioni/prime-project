<?php

    namespace SdcProject\Transformers;

    use League\Fractal\TransformerAbstract;
    use LucaDegasperi\OAuth2Server\Facades\Authorizer;
    use SdcProject\Entities\Project;

    class ProjectTransformer extends TransformerAbstract {

        protected $defaultIncludes = [
            'client',
            'owner',
            'members'
        ];

        public function transform(Project $project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'client_id' => $project->client_id,
                'owner_id' => $project->owner_id,
                'description' => $project->description,
                'progress' => $project->progress,
                'status' => $project->status,
                'due_date' => $project->due_date,
                'isMember' => $project->owner_id != Authorizer::getResourceOwnerId()
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

    }