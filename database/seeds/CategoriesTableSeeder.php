<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'title'     => 'Новости',
                'slug'      => Str::slug('Новости'),
                'parent_id' => 0,
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}
