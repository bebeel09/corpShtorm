<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions=[
            [
                'region_appellation'=>'Свердловская область'
            ],
            [
                'region_appellation'=>'Московская область'
            ],
        ];
    
        DB::table('regions')->insert($regions);
    }


}
