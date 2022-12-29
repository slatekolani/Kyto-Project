<?php

namespace App\Models\touristBookings\soloBookings;

use App\Models\BaseModel\BaseModel;

class SoloTripAmount extends BaseModel
{
    protected $table='solo_trip_amount';
    protected $guarded=['uuid'];

    public function soloBookings()
    {
        return $this->belongsTo(soloBookings::class);
    }
}
