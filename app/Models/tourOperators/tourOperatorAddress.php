<?php

namespace App\Models\tourOperators;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Model;

class tourOperatorAddress extends BaseModel
{
    protected $table='tour_operator_addresses';
    protected $guarded=['uuid'];

    //relation for tourOperatorAddress to a tourOperator
    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }
}
