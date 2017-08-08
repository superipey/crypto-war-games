<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $player = new \App\Players();
        $player->team = '-';
        $player->username = 'test';
        $player->password = 'test';
        $player->kelas = 'XII-RPL1';
        $player->save();
    }
}
