<?php
    /**
     * Created by PhpStorm.
     * User: fgsin
     * Date: 15/03/2016
     * Time: 17:32
     */

    namespace SdcProject\Presenters;

    use Prettus\Repository\Presenter\FractalPresenter;
    use SdcProject\Transformers\ProjectFileTransformer;

    class ProjectFilePresenter extends FractalPresenter {

        /**
         * Transformer
         *
         * @return \League\Fractal\TransformerAbstract
         */
        public function getTransformer() {
            return new ProjectFileTransformer();
        }
    }