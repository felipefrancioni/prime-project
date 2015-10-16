<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:34
 */

namespace SdcProject\Validators;


use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator {

    protected $rules = [
        'name' => 'required|max:60',
        'responsible' => 'required|max:60',
        'email' => 'required|max:100|email',
        'phone' => 'required|max:20',
        'address' => 'required|max:255',
        'obs' => 'max:255',
    ];
}