<?php

namespace App\Models\transportService;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorProfile\tourOperatorProfile;

class transportService extends BaseModel
{
    protected $table='transport_services';
    protected $guarded=['uuid'];

//    relation btn the tourOperatorProfile for the tour Operator and the transport they provide during safari
    public function tourOperatorProfile()
    {
        return $this->belongsToMany(tourOperatorProfile::class);
    }

    public function gettransportStatusLabelAttribute()
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
