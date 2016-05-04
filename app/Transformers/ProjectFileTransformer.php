<?php

    namespace SdcProject\Transformers;

    use League\Fractal\TransformerAbstract;
    use SdcProject\Entities\ProjectFile;

    class ProjectFileTransformer extends TransformerAbstract {

        public function transform(ProjectFile $projectFile) {
            return [
                'id' => $projectFile->id,
                'project_id' => $projectFile->project_id,
                'name' => $projectFile->name,
                'description' => $projectFile->description,
                'extension' => $projectFile->extension
            ];
        }
    }