<?php

    namespace SdcProject\Transformers;


    use League\Fractal\TransformerAbstract;
    use SdcProject\Entities\ProjectMember;
    use SdcProject\Entities\User;

    class ProjectMembersTransformer extends TransformerAbstract {
        public function transform(User $member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email
            ];
        }
    }