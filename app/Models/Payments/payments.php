<?php

namespace App\Models\Payments;

use App\Models\BaseModel\BaseModel;
use App\Models\paymentGateways\paymentGateways;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class payments extends BaseModel
{
    protected $table='payments';
    protected $guarded=['uuid'];

    public function touristBookings()
    {
        return $this->belongsTo(touristBooking::class);
    }

    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }
//    Get the tourist data to display to payments section

}
