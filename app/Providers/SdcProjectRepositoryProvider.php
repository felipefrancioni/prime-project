<?php

namespace SdcProject\Providers;

use Illuminate\Support\ServiceProvider;
use SdcProject\Repositories\ClientRepository;
use SdcProject\Repositories\ClientRepositoryEloquent;
use SdcProject\Repositories\ProjectMemberRepository;
use SdcProject\Repositories\ProjectMemberRepositoryEloquent;
use SdcProject\Repositories\ProjectNoteRepository;
use SdcProject\Repositories\ProjectNoteRepositoryEloquent;
use SdcProject\Repositories\ProjectRepository;
use SdcProject\Repositories\ProjectRepositoryEloquent;
use SdcProject\Repositories\ProjectTaskRepository;
use SdcProject\Repositories\ProjectTaskRepositoryEloquent;
use SdcProject\Repositories\UserRepository;
use SdcProject\Repositories\UserRepositoryEloquent;

class SdcProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientRepository::class, ClientRepositoryEloquent::class);
        $this->app->bind(ProjectRepository::class, ProjectRepositoryEloquent::class);
        $this->app->bind(ProjectTaskRepository::class, ProjectTaskRepositoryEloquent::class);
        $this->app->bind(ProjectMemberRepository::class, ProjectMemberRepositoryEloquent::class);
        $this->app->bind(ProjectNoteRepository::class, ProjectNoteRepositoryEloquent::class);
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
    }
}
