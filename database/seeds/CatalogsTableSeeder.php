<?php

use Illuminate\Database\Seeder;

class CatalogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catalogs = [
            [
                'title'     => 'Цены',
                'slug'      => Str::slug('Цены'),
                'parent_id' => 0,
            ],
            [
                'title'     => 'Каталоги',
                'slug'      => Str::slug('Каталоги'),
                'parent_id' => 0,
            ]
        ];

        DB::table('catalogs')->insert($catalogs);
    }
}
