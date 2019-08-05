<?php

use Illuminate\Database\Seeder;

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
            [
                'name'          =>  'Автор неизвестен',
                'surname'       =>  'Автор неизвестен',
                'patronymic'    =>  'Автор неизвестен',
                'mobile_number' =>  'None',
                'work_number'   =>  'None',
                'position'      =>  'None',
                'email'         =>  'autor@unknown.com',
                'password'      =>  bcrypt(Str::random(16)),
            ],
            [
                'name'          =>  'Автор',
                'surname'       =>  'Автор',
                'patronymic'    =>  'Автор',
                'mobile_number' =>  '123',
                'work_number'   =>  '321',
                'position'      =>  'кек',
                'email'         =>  'autor@known.com',
                'password'      =>  bcrypt('123123'),
            ],
        ];

        DB::table('users')->insert($data);
    }
}
