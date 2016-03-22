<?php

namespace SdcProject\Transformers;

use League\Fractal\TransformerAbstract;
use SdcProject\Entities\Project;

class ProjectTransformer extends TransformerAbstract {

    protected $availableIncludes = [
        'owner',
        'client',
        'projectMembers'
    ];

    public function transform(Project $project) {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'description' => $project->description,
            'progress' => $project->progress,
            'status' => $project->status,
            'due_date' => $project->due_date
        ];
    }

    public function includeOwner(Project $project) {
        return $this->item($project->owner, new UserTransformer());
    }

    public function includeClient(Project $project) {
        return $this->item($project->client, new ClientTransformer());
    }

    public function includeProjectMembers(Project $project) {
        return $this->collection($project->projectMembers, new ProjectMembersTransformer());
    }

}