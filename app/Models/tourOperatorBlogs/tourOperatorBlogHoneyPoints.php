<?php

namespace App\Models\tourOperatorBlogs;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Model;

class tourOperatorBlogHoneyPoints extends BaseModel
{
    protected $table='blog_honey_points';
    protected $guarded=['uuid'];

//    relating the honey points posted belongs to a blog created by a tour Operator
    public function tourOperatorBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }

    public function getHoneyPointImageLabelAttribute()
    {
        return url('public/BlogImages/honeyPointsImages/'.$this->honey_point_image);
    }
}
