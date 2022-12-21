<?php

namespace App\Models\touristBookings;

use App\Models\BaseModel\BaseModel;
use App\Models\Payments\payments;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class touristBooking extends BaseModel
{
    protected $table='tourist_bookings';
    protected $guarded=['uuid'];

    /*A booking has to be made to a specific tour Operator*/
    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }

//    one booking has belongs to one blog
    public function tourOperatorsBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }

    public function payments()
    {
        return $this->hasMany(payments::class);
    }

    public function getStatusLabelAttribute()
    {
        $status=$this->status;
        switch ($status)
        {
            case 0:
                return '<span class="badge badge-warning">Unchecked</span>';
                break;
            case 1:
                return '<span class="badge badge-success">Checked</span>';
                break;
            default:
                return '<span class="badge badge-warning">Unchecked</span>';
                break;
        }
    }

    public function getemailAddressLabelAttribute()
    {
        $email=$this->email_address;
        return $email;
    }

    public function getTotalNumberOfPaymentsLabelAttribute()
    {
        $total_number_of_payments=payments::query()->where('tourist_bookings_id',$this->id)->count();
        return $total_number_of_payments;
    }

    public function getCheckedNumberOfPaymentsLabelAttribute()
    {
        $checked_booking_payments=payments::query()->where('tourist_bookings_id',$this->id)->where('status','=',1)->count();
        return $checked_booking_payments;
    }

    public function getUncheckedNumberOfPaymentsLabelAttribute()
    {
        $unchecked_number_of_payments=payments::query()->where('tourist_bookings_id',$this->id)->where('status','=',0)->count();
        return $unchecked_number_of_payments;
    }
    public function getAmountPaidLabelAttribute()
    {
        $amount_paid=payments::query()->where('status','=',1)->where('tourist_bookings_id',$this->id)->sum('amount');
        return $amount_paid;
    }

    public function getNumberOfDaysLabelAttribute()
    {
        $tourist_bookings=touristBooking::find($this->id);
        $start_date=$tourist_bookings->start_date;
        $end_date=$tourist_bookings->end_date;
        $datetime1=new \DateTime($start_date);
        $datetime2=new \DateTime($end_date);
        $interval=$datetime1->diff($datetime2);
        return $interval->format('%d');
    }

    public function getAmountToBePaidLocalLabelAttribute()
    {
        $tour_operator_blogs=tourOperatorsBlogs::find($this->tourOperatorsBlogs->id);
        $tour_bill=$tour_operator_blogs->visit_cost_local;
        $tourist_bookings=touristBooking::find($this->id);
        $total_travellers=$tourist_bookings->number_of_tourists;
        $days=$this->getNumberOfDaysLabelAttribute();
        $amount=$tour_bill * $total_travellers * $days;
        return $amount;
    }
    public function getAmountToBePaidForeignerLabelAttribute()
    {
        $tour_operator_blogs=tourOperatorsBlogs::find($this->tourOperatorsBlogs->id);
        $tour_bill=$tour_operator_blogs->visit_cost_foreigner;
        $tourist_bookings=touristBooking::find($this->id);
        $total_travellers=$tourist_bookings->number_of_tourists;
        $days=$this->getNumberOfDaysLabelAttribute();
        $amount=$tour_bill * $total_travellers * $days;
        return $amount;
    }
    public function getReserveAmountToBePaidLocalLabelAttribute()
    {
        $tour_operator_blogs=tourOperatorsBlogs::find($this->tourOperatorsBlogs->id);
        $reserve_percent=$tour_operator_blogs->guarantee_percentage;
        $reserve_amount=$this->getAmountToBePaidLocalLabelAttribute() * $reserve_percent;
        return $reserve_amount;
    }

    public function getReserveAmountToBePaidForeignerLabelAttribute()
    {
        $tour_operator_blogs=tourOperatorsBlogs::find($this->tourOperatorsBlogs->id);
        $reserve_percent=$tour_operator_blogs->guarantee_percentage;
        $reserve_amount=$this->getAmountToBePaidForeignerLabelAttribute() * $reserve_percent/100;
        return $reserve_amount;
    }

    public function getBookedTimeLabelAttribute()
    {
        $date=date('jS M Y, H:m:s',strtotime($this->created_at));
        return $date;
    }

}
