<?php
/**
 * Created by PhpStorm.
 * User: fgsin
 * Date: 15/10/2015
 * Time: 15:34
 */

namespace SdcProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectMemberValidator extends LaravelValidator
{

    protected $rules = [
        'project_id' => 'required',
        'user_id' => 'required | unique:project_members'
    ];
}