<?php

namespace SdcProject\Transformers;


use League\Fractal\TransformerAbstract;
use SdcProject\Entities\ProjectNote;

class ProjectNotesTransformer extends TransformerAbstract
{
    public function transform(ProjectNote $projectNote)
    {
        return [
            'id' => $projectNote->id,
            'title' => $projectNote->title,
            'project_id' => $projectNote->project_id,
            'note' => $projectNote->note
        ];
    }
}