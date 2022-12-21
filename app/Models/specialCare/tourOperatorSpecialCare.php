<?php

namespace App\Models\specialCare;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;

class tourOperatorSpecialCare extends BaseModel
{
    protected $table='tour_operator_special_care';
    protected $guarded=['uuid'];

//    a specific blog contains more than one special care a tour operator provide

    public function tourOperatorsBlogs()
    {
        return $this->belongsToMany(tourOperatorsBlogs::class);
    }

    public function getSpecialCareLabelAttribute()
    {
        $status=$this->status;
        switch ($status)
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
