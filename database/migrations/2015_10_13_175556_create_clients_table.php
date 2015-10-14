<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('responsible', 60);
            $table->string('email', 100);
            $table->string('phone', 20);
            $table->text('address');
            $table->text('obs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('clients');
    }
}
