<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'admin', 'email' => 'admin00@gmail.com', 'role' => 'admin', 'password' => Hash::make('admin12345')],
            ['name' => 'sudiharjo', 'email' => null, 'role' => 'user', 'password' => Hash::make('sudiharjo12345')],
            ['name' => 'tasrip', 'email' => null, 'role' => 'user', 'password' => Hash::make('tasrip12345')],
            ['name' => 'katmiyanto', 'email' => null, 'role' => 'user', 'password' => Hash::make('katmiyanto12345')],
            ['name' => 'sigit', 'email' => null, 'role' => 'user', 'password' => Hash::make('sigit12345')],
            ['name' => 'agus', 'email' => null, 'role' => 'user', 'password' => Hash::make('agus12345')],
            ['name' => 'sujatmoko', 'email' => null, 'role' => 'user', 'password' => Hash::make('moko12345')],
            ['name' => 'kuprit', 'email' => null, 'role' => 'user', 'password' => Hash::make('kuprit12345')],
        ];

        User::insert($data);
    }
}
