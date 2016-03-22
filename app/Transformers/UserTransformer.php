<?php

namespace SdcProject\Transformers;


use League\Fractal\TransformerAbstract;
use SdcProject\Entities\User;

class UserTransformer extends TransformerAbstract {

    public function transform(User $user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            //'password' => $user->password,
            //'remember_token' => $user->remember_token
        ];
    }
}