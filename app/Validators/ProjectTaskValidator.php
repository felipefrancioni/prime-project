<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:34
 */

namespace SdcProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator {

    protected $rules = [
        'name' => 'required|max:60',
        'start_date' => 'date',
        'due_date' => 'date',
        'status' => 'required|max:20'
    ];
}