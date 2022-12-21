<?php

namespace App\Models\touristBookings\soloBookings;

use App\Models\BaseModel\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class soloBookingTripPals extends BaseModel
{
    protected $table='solo_booking_trip_pals';
    protected $guarded=['uuid'];

    public function soloBookings()
    {
        return $this->belongsTo(soloBookings::class);
    }

}
