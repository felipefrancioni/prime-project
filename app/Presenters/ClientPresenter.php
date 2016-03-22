<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/03/2016
 * Time: 17:32
 */

namespace SdcProject\Presenters;


use Prettus\Repository\Presenter\FractalPresenter;
use SdcProject\Transformers\ClientTransformer;

class ClientPresenter extends FractalPresenter {

    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer() {
        return new ClientTransformer();
    }
}