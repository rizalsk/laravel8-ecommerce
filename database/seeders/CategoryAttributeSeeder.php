<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\CategoryAttribute::insert(
            ['name'=>'Model'],
            ['name'=>'Color'],
            ['name'=>'Size']
        );
    }
}
