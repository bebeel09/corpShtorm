<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments=[
            [
                'department_appellation'=>'IT'
            ],
            [
                'department_appellation'=>'Отдел кадров'
            ],
            [
                'department_appellation'=>'Отдел маркетинга'
            ],
            [
                'department_appellation'=>'Отдел логистики'
            ],
        ];

        DB::table('departments')->insert($departments);
    }
}
