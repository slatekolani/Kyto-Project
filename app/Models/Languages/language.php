<?php

namespace App\Models\Languages;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorProfile\tourOperatorProfile;

class language extends BaseModel
{
    protected $table='languages';
    protected $guarded=['uuid'];

    public function tourOperatorProfile()
    {
        return $this->belongsToMany(tourOperatorProfile::class);
    }
    public function getNationLanguageFlagLabelAttribute()
    {
        return url('public/Languages/'.$this->nation_language_flag);
    }

    public function getStatusLabelAttribute()
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
                return '<span class="badge badge-info">Unidentified</span>';
                break;
        }
    }
}
