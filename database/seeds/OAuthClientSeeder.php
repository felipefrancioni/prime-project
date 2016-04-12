<?php

use Illuminate\Database\Seeder;

class OAuthClientSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \Illuminate\Support\Facades\DB::table('oauth_clients')->insert([
            'id' => 'appPrime01',
            'secret' => 'prime#prime',
            'name' => 'primeProject',
        ]);
    }
}
