<?php

namespace App\Models\tourType;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;

class tourTypes extends BaseModel
{
    protected $table='tour_types';
    protected $guarded=['uuid'];

//    The tour type can belong to several blog topic of a tour operator
    public function tourOperatorsBlogs()
    {
        return $this->belongsToMany(tourOperatorsBlogs::class);
    }

    public function gettourTypeStatusLabelAttribute()
    {
        $status=$this->status;
        switch($status)
        {
            case 0:
                return '<span class="badge badge-light">Inactive</span>';
                break;
            case 1:
                return '<span class="badge badge-success">Active</span>';
                break;
            default:
                return '<span class="badge badge-warning">Unidentified</span>';
                break;
        }
    }

}
