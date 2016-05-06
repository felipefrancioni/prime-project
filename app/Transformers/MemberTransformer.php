<?php

    namespace SdcProject\Transformers;

    use League\Fractal\TransformerAbstract;
    use SdcProject\Entities\User;

    class MemberTransformer extends TransformerAbstract {

        public function transform(User $user) {
            return [
                'user_id' => $user->id,
                'name' => $user->name
            ];
        }

    }