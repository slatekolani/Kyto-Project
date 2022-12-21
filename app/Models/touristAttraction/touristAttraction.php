<?php

namespace App\Models\touristAttraction;

use App\Models\BaseModel\BaseModel;
use App\Models\tourOperatorProfile\tourOperatorProfile;

class touristAttraction extends BaseModel
{
    protected $table='tourist_attractions';
    protected $guarded=['uuid'];

//    Relation between the tourOperatorProfile and the touristic attractions they operate.Pivot

    public function tourOperatorProfile()
    {
        return $this->belongsToMany(tourOperatorProfile::class);
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
                return '<span class="badge badge-warning">Unidentified</span>';
        }
    }
}
