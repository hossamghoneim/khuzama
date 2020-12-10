<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reports Permission
        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'logs_show',
            'group' => 'logs'
        ]);


        // Items Permission
        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'items_show',
            'group' => 'items'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'items_create',
            'group' => 'items'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'items_edit',
            'group' => 'items'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'items_delete',
            'group' => 'items'
        ]);

        // Mixes Permission
        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'mixes_show',
            'group' => 'mixes'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'mixes_create',
            'group' => 'mixes'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'mixes_edit',
            'group' => 'mixes'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'mixes_delete',
            'group' => 'mixes'
        ]);

        // Components Permission
        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'components_show',
            'group' => 'components'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'components_create',
            'group' => 'components'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'components_edit',
            'group' => 'components'
        ]);

        \Spatie\Permission\Models\Permission::create([
            'guard_name' => 'web',
            'name' => 'components_delete',
            'group' => 'components'
        ]);


    }
}
