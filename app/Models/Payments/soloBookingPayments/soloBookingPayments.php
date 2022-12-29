<?php

namespace App\Models\Payments\soloBookingPayments;

use App\Models\BaseModel\BaseModel;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class soloBookingPayments extends BaseModel
{
    protected $table='solo_booking_payments';
    protected $guarded=['uuid'];

    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }

    public function soloBookings()
    {
        return $this->belongsTo(soloBookings::class);
    }

}
