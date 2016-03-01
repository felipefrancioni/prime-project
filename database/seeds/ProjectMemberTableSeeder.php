<?php

use Illuminate\Database\Seeder;
use SdcProject\Entities\ProjectMember;

class ProjectMemberTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        ProjectMember::truncate();
        factory(ProjectMember::class, 4)->create();
    }
}
