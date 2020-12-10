<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        $user = \App\User::query()->create([

            'name' => env('NAME','Admin Demo'),
            'username' => 1001,
            'email' => env('USER_EMAIL','admin@demo.com'),
            'mobile' => '999999999',
                'password' => bcrypt(env('USER_PASSWORD','admin-demo')),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),

        ]);

        $user->assignRole('super_admin');

    }
}
