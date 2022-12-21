<?php

use Illuminate\Database\Seeder;

class transportServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exists= \App\Models\transportService\transportService::query()->count();
        if($exists==0)
        {
            $transport_service= \App\Models\transportService\transportService::query()->firstOrCreate(['id'=>1],['transport_name'=>'Helicopter']);
            $transport_service= \App\Models\transportService\transportService::query()->firstOrCreate(['id'=>2],['transport_name'=>'Motorcycle']);
        }
    }
}
