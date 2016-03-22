<?php

use Illuminate\Database\Seeder;
use SdcProject\Entities\User;

class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::truncate();
        factory(\SdcProject\Entities\User::class)->create([
            'name' => 'Felipe',
            'email' => 'felipe@softdec.com',
            'password' => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);
        factory(\SdcProject\Entities\User::class, 10)->create();
    }
}
