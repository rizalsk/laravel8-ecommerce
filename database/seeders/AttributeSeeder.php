<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Attribute::insert(
            ['name'=>'Model'],
            ['name'=>'Color'],
            ['name'=>'Size']
        );
    }
}
