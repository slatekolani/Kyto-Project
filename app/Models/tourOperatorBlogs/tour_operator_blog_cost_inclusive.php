<?php

namespace App\Models\tourOperatorBlogs;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorProfile\tourOperatorProfile;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class tour_operator_blog_cost_inclusive extends BaseModel
{
    protected $table='blog_cost_inclusive';
    protected $guarded=['uuid'];

//    all cost inclusive belongs to a specific tourOperator
    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }

//    all cost belongs to a specific posted blog
    public function tourOperatorsBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }

//    all costs inclusive belongs to a specific tour Operator Profile
    public function tourOperatorProfile()
    {
        return $this->belongsTo(tourOperatorProfile::class);
    }
}
