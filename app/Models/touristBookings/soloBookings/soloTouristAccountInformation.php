<?php

namespace App\Models\touristBookings\soloBookings;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Model;

class soloTouristAccountInformation extends BaseModel
{
    protected $table='solo_tourist_account_information';
    protected $guarded=['uuid'];

    public function soloBookings()
    {
        return $this->belongsTo(soloBookings::class);
    }
}
