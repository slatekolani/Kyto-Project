<?php

namespace App\Models\MemberNations;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Model;

class MemberNationality extends BaseModel
{
    protected $table='member_nationality';
    protected $guarded=['uuid'];

    public function getNationFlaglabelAttribute()
    {
        return url('public/nationFlags/'.$this->nation_flag);
    }

    public function getStatusLabelAttribute()
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
