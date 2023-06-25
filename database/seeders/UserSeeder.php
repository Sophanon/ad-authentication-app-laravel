<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Not AD User
        User::updateOrCreate([
            'username' => 'admin'
        ], [
            'name' => 'admin',
            'email' => 'admin@cammob.com',
            'password' => 'password',
            'is_ad' => false
        ]);
        //AD User
        User::updateOrCreate([
            'username' => 'einstein'
        ], [
            'name' => 'AD User',
            'email' => 'ad_user@gmail.com',
            'password' => 'password',
            'is_ad' => true
        ]);
    }
}
