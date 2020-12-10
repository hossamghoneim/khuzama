<?php

use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $com = (new \Rap2hpoutre\FastExcel\FastExcel())->import(storage_path('app/26.xlsx'), function ($line) {

            \App\Models\Component::create([
                'allergen' => $line['ALLERGEN'],
                'cas' => $line['CAS']
            ]);

        });

        \App\Models\Component::find(22)->update(['cas' => '31906-04-04']);
    }
}
