<?php

namespace SdcProject\Presenters;


use Prettus\Repository\Presenter\FractalPresenter;
use SdcProject\Transformers\ProjectNotesTransformer;

class ProjectNotesPresenter extends FractalPresenter
{

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectNotesTransformer();
    }
}