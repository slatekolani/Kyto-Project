<?php

namespace App\Models\tourOperatorBlogs;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorProfile\tourOperatorProfile;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class tour_operator_blog_trip_requirement extends BaseModel
{
    protected $table='blog_trip_requirements';
    protected $guarded=['uuid'];

//    These trip requirements are for the specific tour operator
    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }
//    At some points these trip requirements may be needed in a tour operator profile
    public function tourOperatorProfile()
    {
        return $this->belongsTo(tourOperatorProfile::class);
    }
//    These trip requirements are for a certain blog with a topic of a certain attraction
    public function tourOperatorsBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }
}
