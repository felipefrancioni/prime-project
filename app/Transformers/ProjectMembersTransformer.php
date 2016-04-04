<?php

namespace SdcProject\Transformers;


use League\Fractal\TransformerAbstract;
use SdcProject\Entities\ProjectMember;

class ProjectMembersTransformer extends TransformerAbstract {
    public function transform(ProjectMember $member) {
        return [
            'id' => $member->User->id,
            'name' => $member->User->name,
            'email' => $member->User->email
        ];
    }
}