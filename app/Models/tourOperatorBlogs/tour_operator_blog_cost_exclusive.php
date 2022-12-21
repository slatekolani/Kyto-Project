<?php

namespace App\Models\tourOperatorBlogs;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorProfile\tourOperatorProfile;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class tour_operator_blog_cost_exclusive extends BaseModel
{
    protected $table='blog_cost_exclusives';
    protected $guarded=['uuid'];

//    all exclusive costs in a specific blog(Blog topic either national park) belongs to a tour operator
    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }

//   all exclusive cost might some time be included into the tour operator profile information
    public function tourOperatorProfile()
    {
        return $this->belongsTo(tourOperatorProfile::class);
    }

//    all exclusive costs belong to a specific blog with a certain topic on the national reserve
    public function tourOperatorsBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }

}
