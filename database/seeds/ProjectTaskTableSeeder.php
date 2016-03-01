<?php

use Illuminate\Database\Seeder;
use SdcProject\Entities\ProjectTask;

class ProjectTaskTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        ProjectTask::truncate();
        factory(ProjectTask::class, 2)->create();
    }
}
