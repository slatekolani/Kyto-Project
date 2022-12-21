<?php

namespace App\Models\paymentGateways;

use App\Models\BaseModel\BaseModel;
use App\Models\Payments\payments;
use App\Models\tourOperators\tourOperators;
use Illuminate\Database\Eloquent\Model;

class paymentGateways extends BaseModel
{
    protected $table='payment_gateways';
    protected $guarded=['uuid'];

    public function getIconGatewaylabelAttribute()
    {
        return url('public/PaymentGatewayImages/images/'.$this->payment_gateway_image);
    }

    public function getStatusLabelAttribute()
    {
        $status=$this->status;
        switch ($status)
        {
            case 0:
                return '<span class="badge badge-info">Inactive Absent column</span>';
                break;
            case 1:
                return '<span class="badge badge-success">Active</span>';
                break;
            default:
                return '<span class="badge badge-info">Inactive</span>';
                break;
        }
    }


    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }
}
