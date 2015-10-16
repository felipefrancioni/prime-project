<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:34
 */

namespace SdcProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator {

    protected $rules = [
        'name' => 'required|max:60',
        'description' => 'required',
        'progress' => 'required|max:30',
        'status' => 'required|max:20',
        'due_date' => 'required|date'
    ];
}