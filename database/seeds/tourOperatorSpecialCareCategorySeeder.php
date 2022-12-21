<?php

use Illuminate\Database\Seeder;

class tourOperatorSpecialCareCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exists= \App\Models\specialCare\tourOperatorSpecialCare::query()->count();
        if($exists==0)
        {
            $special_care= \App\Models\specialCare\tourOperatorSpecialCare::query()->firstOrCreate(['id'=>'1'],['special_care'=>'Hand-capped']);
            $special_care= \App\Models\specialCare\tourOperatorSpecialCare::query()->firstOrCreate(['id'=>'2'],['special_care'=>'Blind']);
        }
    }
}
