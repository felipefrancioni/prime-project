<?php

    namespace SdcProject\Transformers;


    use League\Fractal\TransformerAbstract;
    use SdcProject\Entities\ProjectMember;
    use SdcProject\Entities\User;

    class ProjectMembersTransformer extends TransformerAbstract {

        protected $defaultIncludes = [
            'user'
        ];

        public function transform(ProjectMember $member) {
            return [
                'project_id' => $member->project_id
            ];
        }

        public function includeUser(ProjectMember $projectMember) {
            return $this->item($projectMember->member,new MemberTransformer());
        }
    }