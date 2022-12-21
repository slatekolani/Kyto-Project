<?php

namespace App\Models\tourOperatorRating;

use App\Models\Auth\User;
use App\Models\BaseModel\BaseModel;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class tourOperatorRating extends BaseModel
{
    protected $table='tour_operator_ratings';
    protected $guarded=['uuid'];

//    rating belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class,'users_id');
    }
//    ratings belongs to a one tour Operator
    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }
}
