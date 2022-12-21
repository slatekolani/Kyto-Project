<?php

namespace App\Models\touristBookings\soloBookings;

use App\Models\BaseModel\BaseModel;
use App\Models\Payments\soloBookingPayments\soloBookingPayments;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Carbon\Carbon;

class soloBookings extends BaseModel
{
    protected $table='solo_bookings';
    protected $guarded=['uuid'];

    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }
    public function tourOperatorsBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }
    public function soloBookingPayments()
    {
        return $this->hasMany(soloBookingPayments::class);
    }
    public function soloBookingTripPals()
    {
        return $this->hasMany(soloBookingTripPals::class);
    }

    public function soloTouristAccountInformation()
    {
        return $this->hasMany(soloTouristAccountInformation::class);
    }
    public function getNumberOfSoloTripsLabelAttribute()
    {
        $solo_booking=soloBookings::find($this->id);
        $start_date=$solo_booking->start_date;
        $today_date=Carbon::now();
        $datetime1=new \DateTime($start_date);
        $datetime2=new \DateTime($today_date);
        $interval=$datetime1->diff($datetime2);
        return $interval->format('%d');
    }
}
