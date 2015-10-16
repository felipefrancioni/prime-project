<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('owner_id', false);
            $table->foreign('owner_id')->references('id')->on('users');
            $table->unsignedInteger('client_id', false);
            $table->foreign('client_id')->references('id')->on('clients');
            $table->string('name', 60);
            $table->text('description');
            $table->string('progress', 30);
            $table->string('status', 20);
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('projects');
    }
}
