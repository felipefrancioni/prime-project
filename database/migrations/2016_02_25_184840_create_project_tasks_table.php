<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTasksTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->unsignedInteger('project_id', false);
            $table->foreign('project_id')->references('id')->on('projects');
            $table->date('start_date');
            $table->date('due_date');
            $table->string('status', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('project_tasks');
    }
}