<?php

namespace App\Models\Auth\Attribute;

use App\Models\Payments\payments;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use function GuzzleHttp\Psr7\str;

trait UserAttribute
{
    /**
     * Set the user's email.
     *
     * @param  string  $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim(preg_replace('/\s+/', '', $value)));
    }

    /**
     * Set the user's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucwords(trim($value));
    }


    public function setMiddlenameAttribute($value)
    {
        $this->attributes['middlename'] = ucwords(trim($value));
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucwords(trim($value));
    }


    public function setFullnameAttribute()
    {
        return  ucfirst($this->firstname) . " " . ucfirst($this->middlename) . ' ' .  ucfirst($this->lastname);
    }

    public function getFullnameAttribute() {
        return ucfirst($this->firstname) . " " . ucfirst($this->middlename) . ' ' .  ucfirst($this->lastname);
    }

    public function getCreatedAtFormattedAttribute()
    {
        return  Carbon::parse($this->created_at)->format('d-M-Y');
    }

    public function getLastLoginFormattedAttribute()
    {
        return  Carbon::parse($this->last_login)->format('d-M-Y');
    }



    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->isactive == true;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed == 1;
    }



    /* Active status label*/
    public function getActiveStatusLabelAttribute()
    {
        if ($this->isactive == 1) {
            return "<span class='badge badge-pill badge-success' data-toggle='tooltip' data-html='true' title='" . trans('label.active') . "'>" . trans('label.active') . "</span>";
        } else {
            return "<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-html='true' title='" . trans('label.inactive') . "'>" . trans('label.inactive') . "</span>";
        }
    }

    /*Get Roles of the users*/

    public function getRoleLabelAttribute() {
        $roles = [];
        if ($this->roles()->count() > 0) {
            foreach ($this->roles as $role) {
                array_push($roles, $role->name);
            }
            return implode(", ", $roles);
        } else {
            return '<span class="tag tag-danger">'. trans('label.none') . '</span>';
        }
    }

    /*Workflow resource name*/
    public function getResourceNameAttribute()
    {
        return $this->getFullnameAttribute();
    }

    /*Auditable name for audit*/
    public function getAuditableNameAttribute()
    {
       return  $this->getFullnameAttribute();
    }
    public function hasRole($role_id)
    {
        $check=$this->roles()->where('role_id',$role_id)->count();
        if($check==1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function getUserTourBookings()
    {
        $tourist_booking=touristBooking::query()->where('users_id',$this->id)->get();
        return $tourist_booking;
    }
    public function getUserSoloTourBookings()
    {
        $solo_booking=soloBookings::query()->where('users_id',$this->id)->get();
        return $solo_booking;
    }

    public function getDays($tourist_booking_id)
    {
        $tourist_booking = touristBooking::find($tourist_booking_id);
        $startDate=$tourist_booking->start_date;
        $endDate=$tourist_booking->end_date;
        $datetime1=new \DateTime($startDate);
        $datetime2=new \DateTime($endDate);
        $interval=$datetime1->diff($datetime2);
        return $interval->format('%d');
    }

    public function getDaysForSoloTrip($solo_booking_id)
    {
        $solo_booking = soloBookings::find($solo_booking_id);
        $startDate=$solo_booking->start_date;
        $endDate=$solo_booking->end_date;
        $datetime1=new \DateTime($startDate);
        $datetime2=new \DateTime($endDate);
        $interval=$datetime1->diff($datetime2);
        return $interval->format('%d');
    }


//     get guarantee percentage from the database
      public function getGuaranteePercentage($tourist_booking_id)
      {
          $tour_operator_blogs=tourOperatorsBlogs::find($tourist_booking_id);
          $guarantee_amount=$tour_operator_blogs->guarantee_percentage;
          return $guarantee_amount;
      }

//      display Guarantee percentage to be paid by the user

        public function getDisplayGuaranteePercent($tourist_booking)
        {
            $guarantee_percent=$this->getGuaranteePercentage($tourist_booking->tour_operators_blogs_id);

            return $guarantee_percent;
        }


    //get number of days to be displayed
    public function getNumberOfDays($tourist_booking)
    {
        $days = $this->getDays($tourist_booking->id);
        return $days;
    }

    public function getNumberOfDaysForSoloTrip($solo_booking)
    {
        $days=$this->getDaysForSoloTrip($solo_booking->id);
        return $days;
    }

//    get the bill from the database for locals

    public function getTourBill($tourist_booking_id)
    {
        $tour_bill=tourOperatorsBlogs::find($tourist_booking_id);
        $Amount=$tour_bill->visit_cost_local;
        return $Amount;
    }

//    get the bill for the foreigners
    public function getTourBillForeigners($tourist_booking_id)
    {
        $foreigner_tour_bill=tourOperatorsBlogs::find($tourist_booking_id);
        $amount=$foreigner_tour_bill->visit_cost_foreigner;
        return $amount;
    }

//    Displayable bill form the database

    public function getDisplayTourBill($tourist_booking)
    {
        $amount=$this->getTourBill($tourist_booking->tour_operators_blogs_id);
        return $amount;
    }

//    Displayable bill for the foreigners from the database
    public function getDisplayTourBillForeigners($tourist_booking)
    {
        $amount=$this->getTourBillForeigners($tourist_booking->tour_operators_blogs_id);
        return $amount;
    }

//    get the number of travellers from the database
    public function getNumberOfTravellers($tourist_booking_id)
    {
        $number_of_travellers=touristBooking::find($tourist_booking_id);
        $total=$number_of_travellers->number_of_tourists;
        return $total;
    }

//    Display the number of travellers from the database

    public function getDisplayNumberOfTravellers($tourist_booking)
    {
        $number_of_travellers=$this->getNumberOfTravellers($tourist_booking->id);
        return $number_of_travellers;
    }

    //        get guarantee amount to be paid
    public function getGuaranteeAmountToBePayedLocal($tourist_booking_id)
    {
        $percentage=$this->getDisplayGuaranteePercent($tourist_booking_id)/100;
        $days=$this->getNumberOfDays($tourist_booking_id);
        $tour_bill=$this->getDisplayTourBill($tourist_booking_id);
        $number_of_travellers=$this->getDisplayNumberOfTravellers($tourist_booking_id);
        $amount=$percentage * $days * $tour_bill * $number_of_travellers;
        return $amount;
    }

    public function getGuaranteeAmountToBePayedForeigner($tourist_booking_id)
    {
        $percentage=$this->getDisplayGuaranteePercent($tourist_booking_id)/100;
        $days=$this->getNumberOfDays($tourist_booking_id);
        $tour_bill_foreigner=$this->getDisplayTourBillForeigners($tourist_booking_id);
        $number_of_travellers=$this->getDisplayNumberOfTravellers($tourist_booking_id);
        $amount=$percentage * $days * $tour_bill_foreigner * $number_of_travellers;
        return $amount;

    }

    public function getAmountPaid($tourist_booking)
    {
        $payments=payments::query()->where('tourist_bookings_id',$tourist_booking->id)->where('status','=',1)->sum('amount');
        return $payments;
    }
    public function getAmountPaidNonVerifiedAndVerified($tourist_booking)
    {
        $payments=payments::query()->where('tourist_bookings_id',$tourist_booking->id)->sum('amount');
        return $payments;
    }
    public function getNumberOfTransactions($tourist_booking)
    {
        $total_number_of_transactions=payments::query()->where('tourist_bookings_id',$tourist_booking->id)->count('amount');
        return $total_number_of_transactions;
    }

    public function getTripCostForeigner($tourist_booking_id)
    {
        $days=$this->getNumberOfDays($tourist_booking_id);
        $tour_bill_foreigner=$this->getDisplayTourBillForeigners($tourist_booking_id);
        $number_of_travellers=$this->getDisplayNumberOfTravellers($tourist_booking_id);
        $amount= $days * $tour_bill_foreigner * $number_of_travellers;
        return $amount;
    }

    public function getTripCostLocal($tourist_booking_id)
    {
        $days=$this->getNumberOfDays($tourist_booking_id);
        $tour_bill_local=$this->getDisplayTourBill($tourist_booking_id);
        $number_of_travellers=$this->getDisplayNumberOfTravellers($tourist_booking_id);
        $amount= $days * $tour_bill_local * $number_of_travellers;
        return $amount;
    }

    public function getNumberOfCompanies()
    {
        $tour_operator_companies=tourOperators::query()->where('users_id',$this->id)->count();
        return $tour_operator_companies;
    }
    public function getVerifiedCompanies()
    {
        $tour_operator_companies_verified=tourOperators::query()->where('status','=',1)->where('users_id',$this->id)->count();
        return $tour_operator_companies_verified;
    }
    public function getUnverifiedCompanies()
    {
        $tour_operator_companies_unverified=tourOperators::query()->where('status','=',0)->where('users_id',$this->id)->count();
        return $tour_operator_companies_unverified;
    }
}
