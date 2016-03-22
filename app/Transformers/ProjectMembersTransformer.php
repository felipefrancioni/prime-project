<?php

namespace SdcProject\Transformers;


use League\Fractal\TransformerAbstract;
use SdcProject\Entities\User;

class ProjectMembersTransformer extends TransformerAbstract {
    public function transform(User $user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }
}