<?php

namespace App\Models\touristBookings\soloBookings;

use App\Models\BaseModel\BaseModel;
use App\Models\Payments\soloBookingPayments\soloBookingPayments;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Carbon\Carbon;

class soloBookings extends BaseModel
{
    protected $table='solo_bookings';
    protected $guarded=['uuid'];

    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }
    public function tourOperatorsBlogs()
    {
        return $this->belongsTo(tourOperatorsBlogs::class);
    }
    public function soloBookingPayments()
    {
        return $this->hasMany(soloBookingPayments::class);
    }
    public function soloBookingTripPals()
    {
        return $this->hasMany(soloBookingTripPals::class);
    }

    public function soloTouristAccountInformation()
    {
        return $this->hasMany(soloTouristAccountInformation::class);
    }

    public function SoloTripAmount()
    {
        return $this->belongsTo(SoloTripAmount::class);
    }

    public function getNumberOfDaysRemainedForSoloTripLabelAttribute()
    {
        $solo_booking=soloBookings::find($this->id);
        $start_date=$solo_booking->start_date;
        $today_date=Carbon::now();
        $datetime1=new \DateTime($start_date);
        $datetime2=new \DateTime($today_date);
        $interval=$datetime1->diff($datetime2);
        return $interval->format("%R%a days.");
    }
    public function getButtonActionsLabelAttribute()
    {
        $btn='<a href="'.route('soloBookingPayments.index',$this->uuid).'" class="btn btn-primary btn-sm">Payments</a>';
        $btn=$btn.'<a href="'.route('soloBookings.delete',$this->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
        $btn=$btn.'<a href="'.route('SoloTripAmount.index',$this->uuid).'" class="btn btn-primary btn-sm">Trip amount</a>';
        return $btn;
    }
    public function getNumberOfDaysForASoloTripLabelAttribute()
    {
        $solo_booking=soloBookings::find($this->id);
        $start_date=$solo_booking->start_date;
        $end_date=$solo_booking->end_date;
        $datetime1=new \DateTime($start_date);
        $datetime2=new \DateTime($end_date);
        $interval=$datetime1->diff($datetime2);
        return $interval->format("%d");
    }

    public function getCountDownNumberOfDaysForASoloTripLabelAttribute()
    {
        $solo_booking=soloBookings::find($this->id);
        $start_date=$solo_booking->start_date;
        $today_date=carbon::now();
        $datetime1=new \DateTime($start_date);
        $datetime2=new \DateTime($today_date);
        $interval=$datetime1->diff($datetime2);
        return $interval->format("%R%a");
    }

    public function getStatusLabelAttribute()
    {
        $status=$this->status;
        switch ($status)
        {
            case 0:
                return '<span class="badge badge-warning">Unconfirmed</span>';
                break;

            case 1:
                return '<span class="badge badge-success">Confirmed</span>';
                break;

            default:
                return '<span class="badge badge-danger">Error</span>';
                break;
        }
    }
    public function getVerifiedSoloBookingsLabelAttribute()
    {
        $verified_solo_booking=soloBookings::query()->where('tour_operators_id',$this->id)->where('status','=',1)->count();
        return $verified_solo_booking;
    }
    public function getUnverifiedSoloBookingsLabelAttribute()
    {
        $unverified_solo_bookings=soloBookings::query()->where('tour_operators_id',$this->id)->where('status','=',0)->count();
        return $unverified_solo_bookings;
    }
    public function getTotalSoloBookingsLabelAttribute()
    {
        $total_solo_bookings=soloBookings::query()->where('tour_operators_id',$this->id)->count();
        return $total_solo_bookings;
    }
    public function getNumberOfTransactionsLabelAttribute()
    {
        $total_solo_booking_transactions=soloBookingPayments::query()->where('solo_bookings_id',$this->id)->count();
        return $total_solo_booking_transactions;
    }
    public function getNumberOfCheckedTransactionsLabelAttribute()
    {
        $total_checked_transactions=soloBookingPayments::query()->where('solo_bookings_id',$this->id)->where('status','=',1)->count();
        return $total_checked_transactions;
    }
    public function getNumberOfUncheckedTransactionsLabelAttribute()
    {
        $total_unchecked_transactions=soloBookingPayments::query()->where('solo_bookings_id',$this->id)->where('status','=',0)->count();
        return $total_unchecked_transactions;
    }

    public function getAmountToBePaidLabelAttribute()
    {
        $solo_trip_amount=SoloTripAmount::query()->where('solo_bookings_id',$this->id)->pluck('amount_to_be_paid')->first();
        return $solo_trip_amount;
    }
    public function getSoloTripPaymentGuaranteePercentage($solo_bookings_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::find($solo_bookings_id);
        $solo_trip_payment_guarantee_percentage=$tour_operator_blog->guarantee_percentage;
        return $solo_trip_payment_guarantee_percentage;
    }
    public function getDisplayGuaranteePercent($solo_booking)
    {
        $solo_trip_payment_guarantee_percent=$this->getSoloTripPaymentGuaranteePercentage($solo_booking->tour_operators_blogs_id);
        return $solo_trip_payment_guarantee_percent;
    }
    public function getSoloTripReserveAmount($solo_booking)
    {
        $solo_trip_amount=$this->getAmountToBePaidLabelAttribute();
        $solo_trip_reserve_percentage=$this->getDisplayGuaranteePercent($solo_booking)/100;
        $reserve_amount=$solo_trip_amount*$solo_trip_reserve_percentage;
        return $reserve_amount;
    }
    public function getSoloTripAmountPaidByTripPalsLabelAttribute()
    {
        $solo_trip_amount_paid_by_trip_pals=soloBookingTripPals::query()->where('solo_bookings_id',$this->id)->sum('trip_amount');
        return $solo_trip_amount_paid_by_trip_pals;
    }
    public function getSoloTripAmountPaidLabelAttribute()
    {
        $solo_trip_amount_paid=soloBookingPayments::query()->where('solo_bookings_id',$this->id)->where('status','=',1)->sum('amount');
        return $solo_trip_amount_paid;
    }
    public function getSoloTripAmountVerifiedAndNonVerifiedPaidLabelAttribute()
    {
        $solo_trip_amount_verified_and_non_verified=soloBookingPayments::query()->where('solo_bookings_id',$this->id)->sum('amount');
        return $solo_trip_amount_verified_and_non_verified;
    }
    public function getNumberOfTransactionsMadeForSoloTripLabelAttribute()
    {
        $solo_trip_amount_paid=soloBookingPayments::query()->where('solo_bookings_id',$this->id)->count();
        return $solo_trip_amount_paid;
    }
    public function getSoloTripAmountLabelAttribute()
    {
        $solo_trip_amount=SoloTripAmount::query()->where('solo_bookings_id',$this->id)->sum('amount_to_be_paid');
        return $solo_trip_amount;
    }
    public function getNumberOfSoloTripAmountTransactionLabelAttribute()
    {
        $solo_trip_amount=SoloTripAmount::query()->where('solo_bookings_id',$this->id)->count();
        return $solo_trip_amount;
    }
}
