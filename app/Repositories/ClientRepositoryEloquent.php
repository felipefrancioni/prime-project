<?php

    namespace SdcProject\Repositories;


    use Prettus\Repository\Eloquent\BaseRepository;
    use SdcProject\Entities\Client;
    use SdcProject\Presenters\ClientPresenter;

    class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

        protected $fieldSearchable = [
            'name',
            'email'
        ];

        /**
         * Specify Model class name
         *
         * @return string
         */
        public function model() {
            return Client::class;
        }

        public function presenter() {
            return ClientPresenter::class;
        }

        public function boot() {
            $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        }
    }