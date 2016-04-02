<?php

namespace SdcProject\Transformers;


use League\Fractal\TransformerAbstract;
use SdcProject\Entities\ProjectMember;
use SdcProject\Entities\User;

class ProjectMembersTransformer extends TransformerAbstract {
    public function transform(ProjectMember $member) {
        return [
            'member_id' => $member->user->id,
            'name' => $member->user->name,
        ];
    }
}