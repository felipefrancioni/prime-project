<?php

namespace SdcProject\Providers;

use Illuminate\Support\ServiceProvider;
use SdcProject\Repositories\ClientRepository;
use SdcProject\Repositories\ClientRepositoryEloquent;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Repositories\ProjectRepositoryEloquent;

class SdcProjectRepositoryProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(ClientRepository::class, ClientRepositoryEloquent::class);
        $this->app->bind(ProjectRepository::class, ProjectRepositoryEloquent::class);
    }
}
