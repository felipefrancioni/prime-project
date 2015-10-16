<?php

namespace SdcProject\Repositories;


use Prettus\Repository\Eloquent\BaseRepository;
use SdcProject\Entities\Client;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model() {
        return Client::class;
    }
}