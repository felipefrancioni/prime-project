<?php

    namespace SdcProject\Transformers;


    use League\Fractal\TransformerAbstract;
    use SdcProject\Entities\ProjectMember;

    class ProjectMembersTransformer extends TransformerAbstract {

        protected $defaultIncludes = [
            'user'
        ];

        public function transform(ProjectMember $projectMember) {
            return [
                'project_id' => $projectMember->project_id
            ];
        }

        public function includeUser(ProjectMember $projectMember) {
            return $this->item($projectMember->user, new MemberTransformer());
        }
    }