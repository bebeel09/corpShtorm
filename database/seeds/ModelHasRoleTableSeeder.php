<?php

use Illuminate\Database\Seeder;

class ModelHasRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelHasRole=[
            [
                'role_id'=>'1',
                'model_type'=>'App\User',
                'model_id'=>'1',
            ]
        ];

        DB::table('model_has_roles')->insert($modelHasRole);
    }
}
