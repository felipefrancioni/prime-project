<?php

namespace SdcProject\Repositories;


use Prettus\Repository\Eloquent\BaseRepository;
use SdcProject\Entities\User;
use SdcProject\Presenters\UserPresenter;

class UserRepositoryEloquent extends BaseRepository implements UserRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return User::class;
    }

    public function presenter() {
        return UserPresenter::class;
    }
}