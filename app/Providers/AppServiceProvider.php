<?php

    namespace SdcProject\Providers;

    use Illuminate\Support\Facades\Event;
    use Illuminate\Support\ServiceProvider;
    use SdcProject\Entities\ProjectTask;
    use SdcProject\Events\TaskWasIncluded;

    class AppServiceProvider extends ServiceProvider {
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot() {
            ProjectTask::created(function ($task) {
                Event::fire(new TaskWasIncluded($task));
            });
        }

        /**
         * Register any application services.
         *
         * @return void
         */
        public function register() {
            //
        }
    }
