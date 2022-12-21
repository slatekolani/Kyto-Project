<?php

use Illuminate\Database\Seeder;

class tourTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exist= \App\Models\tourType\tourTypes::query()->count();
        if($exist==0)
        {
            $tour_type= \App\Models\tourType\tourTypes::query()->firstOrCreate(['id'=>'1'],['tour_type_name'=>'Escorted tour']);
            $tour_type= \App\Models\tourType\tourTypes::query()->firstOrCreate(['id'=>'2'],['tour_type_name'=>'Adventure tour']);
            $tour_type= \App\Models\tourType\tourTypes::query()->firstOrCreate(['id'=>'2'],['tour_type_name'=>'Safari tour']);
        }
    }
}
