<?php
    /**
     * Created by PhpStorm.
     * User: fgsin
     * Date: 15/10/2015
     * Time: 15:34
     */

    namespace SdcProject\Validators;


    use Prettus\Validator\Contracts\ValidatorInterface;
    use Prettus\Validator\LaravelValidator;

    class ProjectFileValidator extends LaravelValidator {

        protected $rules = [
            ValidatorInterface::RULE_CREATE => [
                'name' => 'required',
                'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip',
                'description' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name' => 'required',
                'description' => 'required'
            ]

        ];
    }