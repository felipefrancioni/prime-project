<?php

namespace SdcProject\Presenters;


use Prettus\Repository\Presenter\FractalPresenter;
use SdcProject\Transformers\ProjectTasksTransformer;

class ProjectTasksPresenter extends FractalPresenter {

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer() {
        return new ProjectTasksTransformer();
    }
}