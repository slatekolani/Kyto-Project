<?php

namespace App\Models\tourOperatorBlogs;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Model;

class tourOperatorBlogService extends BaseModel
{
    protected $table='tour_operator_blog_services';
    protected $guarded=['uuid'];

//    Relation for tourOperatorBlogsService to tourOperatorBlogs
    public function tourOperatorsBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }

    public function getServiceImageLabelAttribute()
    {
        return url('public/BlogImages/serviceImages/'.$this->service_image);
    }
}
