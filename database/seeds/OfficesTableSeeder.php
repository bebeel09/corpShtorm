<?php

use Illuminate\Database\Seeder;

class OfficesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = [
            [
                'office_appellation' => 'Верхняя Пышма'
            ],
            [
                'office_appellation' => 'Нижний Новгород'
            ],
            [
                'office_appellation' => 'Новосибирск'
            ],
            [
                'office_appellation' => 'Пермь'
            ],
            [
                'office_appellation' => 'Екатеринбург'
            ],
            [
                'office_appellation' => 'Москва'
            ]
        ];

        DB::table('offices')->insert($offices);
    }
}
