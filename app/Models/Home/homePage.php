<?php

namespace App\Models\Home;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use Illuminate\Database\Eloquent\Model;

class homePage extends BaseModel
{
    protected $table='home_page';
    protected $guarded=['uuid'];

    /*tour Operator Blogs to be displayed in the home page*/
    public function tourOperatorBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }
}
