<?php

namespace SdcProject\Transformers;


use League\Fractal\TransformerAbstract;
use SdcProject\Entities\ProjectTask;

class ProjectTasksTransformer extends TransformerAbstract {
    public function transform(ProjectTask $projectTask) {
        return [
            'id' => $projectTask->id,
            'name' => $projectTask->name,
            'project_id' => $projectTask->project_id,
            'start_date' => $projectTask->start_date,
            'due_date' => $projectTask->due_date,
            'status' => $projectTask->status
        ];
    }
}