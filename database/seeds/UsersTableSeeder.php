<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User();
        $user->email = "admin@shtorm-its.ru";
        $user->login = "admin";
        $user->password = bcrypt('123456');
        $user->first_name = "Неизвестен";
        $user->sur_name = "Неизвестен";
        $user->last_name = "Неизвестен";
        $user->office_id = 1;
        $user->department_id = 1;
        $user->position = "Неизвестен";
        $user->save();
        
        $user->assignRole('grant admin');

        // $data = [
        //     'email' => 'admin@shtorm-its.ru',
        //     'login' => 'admin',
        //     'password' => bcrypt('123456'),
        //     'first_name' => 'Неизвестен',
        //     'sur_name' => 'Неизвестен',
        //     'last_name' => 'Неизвестен',
        //     'region_id' => '1',
        //     'office_id' => '1',
        //     'department_id' => '1',
        //     'position' => 'Неизвестен',
        // ];



        // DB::table('users')->insert($data);
    }
}
