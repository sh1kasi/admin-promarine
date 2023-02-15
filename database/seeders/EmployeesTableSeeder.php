<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['user_id' => '2', 'Role' => 'Permanent'],
            ['user_id' => '3', 'Role' => 'Permanent'],
            ['user_id' => '4', 'Role' => 'Permanent'],
            ['user_id' => '5', 'Role' => 'Permanent'],
            ['user_id' => '6', 'Role' => 'Permanent'],
            ['user_id' => '7', 'Role' => 'Permanent'],
            ['user_id' => '8', 'Role' => 'Helper'],
        ];

        Employee::insert($data);

    }
}
