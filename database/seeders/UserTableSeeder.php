<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::truncate();
        // \App\Models\User::factory(10)->create();
        $admins = \App\Models\User::factory(2)->isAdmin()
        ->sequence(function ($sequence){
            $count = $sequence->index;
            $attr = [
                'name' => 'admin'.($count < 1 ? '' : $count),
                'email' => 'admin'.($count < 1 ? '' : $count).'@mail.com'
            ];
            return $attr;
        })
        ->create();
        $user = \App\Models\User::factory(3)
            ->sequence(function ($sequence){
                $count = $sequence->index;
                $attr = [
                    'name' => 'user'.($count < 1 ? '' : $count),
                    'email' => 'user'.($count < 1 ? '' : $count).'@mail.com'
                ];
                return $attr;
            })
            ->create();
        $users = \App\Models\User::factory(10)->create();
    }
}
