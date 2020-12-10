<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $super_admin = \Spatie\Permission\Models\Role::create([
            'guard_name' => 'web',
            'name' => 'super_admin',
        ]);

        $super_admin->givePermissionTo(\Spatie\Permission\Models\Permission::all()
            ->where('guard_name','web')->pluck('name')->toArray());

    }
}
