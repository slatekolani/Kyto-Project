<?php

namespace App\Models\tourOperatorAccounts;

use App\Models\BaseModel\BaseModel;
use App\Models\paymentGateways\paymentGateways;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class tourOperatorAccounts extends BaseModel
{
    protected $table='tour_operator_accounts';
    protected $guarded=['uuid'];


    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }

    public function paymentGateways()
    {
        return $this->hasMany(paymentGateways::class,'payment_gateway');
    }

    public function getStatusLabelAttribute()
    {
        $status=$this->status;
        switch ($status)
        {
            case 0:
                return '<span class="badge badge-warning">Inactive</span>';
                break;
            case 1:
                return '<span class="badge badge-success">Active</span>';
                break;
            default:
                return '<span class="badge badge-info">Inactive</span>';
                break;
        }
    }
}
