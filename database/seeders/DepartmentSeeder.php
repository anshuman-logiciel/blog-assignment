<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'department_name' =>'General Management'
            ],
            [
                'department_name' =>'Marketing Department'
            ],
            [
                'department_name' =>'Operations Department'
            ],
            [
                'department_name' =>'Finance Department'
            ],
            [
                'department_name' =>'Sales Department'
            ],
            [
                'department_name' =>'Human Resource Department'
            ],
            [
                'department_name' =>'Purchase Department'
            ],
        ]);
    }
}

