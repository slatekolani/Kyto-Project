<?php

namespace App\Models\tourOperators;

use App\Models\Auth\User;
use App\Models\BaseModel\BaseModel;
use App\Models\Payments\payments;
use App\Models\Payments\soloBookingPayments\soloBookingPayments;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperatorBlogs\tour_operator_blog_cost_exclusive;
use App\Models\tourOperatorBlogs\tour_operator_blog_cost_inclusive;
use App\Models\tourOperatorBlogs\tour_operator_blog_trip_requirement;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperatorProfile\tourOperatorProfile;
use App\Models\tourOperatorRating\tourOperatorRating;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;


class tourOperators extends BaseModel
{
    protected $table='tour_operators';
    protected $guarded=['uuid'];

    //relation for the tourOperators and their addresses
    public function tourOperatorAddress()
    {
        return $this->hasMany(tourOperatorAddress::class);
    }

    //relation for the tourOperator and their Profiles(tourOperatorProfile)

    public function tourOperatorProfile()
    {
        return $this->hasOne(tourOperatorProfile::class,'tour_operators_id');
    }

    //relation that the tour operator has many blogs posted
    public function tourOperatorsBlogs()
    {
        return $this->hasMany(tourOperatorsBlogs::class);
    }

//    relation that tour operators belongs to a user of a specific account
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    /*A tour Operator can have more than one booking request*/
    public function touristBooking()
    {
        return $this->hasMany(touristBooking::class);
    }

    public function soloBookings()
    {
        return $this->hasMany(soloBookings::class);
    }

    public function soloBookingPayments()
    {
        return $this->hasMany(soloBookingPayments::class);
    }

//    Tour Operator can have many ratings from tourists

    public function tourOperatorRating()
    {
        return $this->hasMany(tourOperatorRating::class);
    }

//    a tour operator is the one whom possesses this kind of cost inclusive
    public function tour_operator_blog_cost_inclusive()
    {
        return $this->hasMany(tour_operator_blog_cost_inclusive::class);
    }
//    a tour operator is the one whom posses this kind of cost exclusive
    public function tour_operator_blog_cost_exclusive()
    {
        return $this->hasMany(tour_operator_blog_cost_exclusive::class);
    }

//    a tour operatod id the one whom posses these trip requirements
    public function tour_operator_blog_trip_requirement()
    {
        return $this->hasMany(tour_operator_blog_trip_requirement::class);
    }

//function to get the company logo
    public function getLogolabelAttribute()
    {
        return url('public/logo_uploads/Logo/'.$this->logo);
    }
// function to get the status verification

    public function getStatusLabelAttribute()
    {
        $status=$this->status;
        switch($status)
        {
            case 0:
               return '<span class="badge badge-danger">Unchecked</span>';
               break;

            case 1:
                return '<span class="badge badge-success">Verified</span>';
                break;

            default:
                return '<span class="badge badge-danger">Compromised</span>';
                break;
        }
    }
//    function to get the button depending on the status being Unchecked or verified

    public function getButtonActionsAttribute()
    {

        $status=$this->status;
        switch ($status)
        {
            case 0:
                $btn='<a href="'.route('tourOperatorProfile.index',$this->uuid).'"><button class="btn btn-danger btn-sm">Profile</button></a>';
                $btn=$btn.'<a href="'.route('tourOperator.delete',$this->uuid).'"><button class="btn btn-danger btn-sm">Delete</button></a>';
                return $btn;
                break;

            case 1:
                $btn='<a href="'.route('tourOperator.edit',$this->uuid).'"><button class="btn btn-primary btn-sm">Edit</button></a>';
                $btn=$btn.'<a href="'.route('tourOperator.delete',$this->uuid).'"><button class="btn btn-danger btn-sm">Delete</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorProfile.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Profile</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogs.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Blog</button></a>';
                $btn=$btn.'<a href="'.route('touristBookings.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Custom Bookings</button></a>';
                $btn=$btn.'<a href="'.route('soloBookings.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Solo Bookings</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorAccounts.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Account</button></a>';
                return $btn;
                break;
        }
    }

    public function payments()
    {
        return $this->hasMany(payments::class);
    }

    public function getBlogPostedLabelAttribute()
    {
        $number_of_blog_posted=tourOperatorsBlogs::query()->where('tour_operators_id',$this->id)->count();
        return $number_of_blog_posted;
    }
    public function getBlogPostedVerifiedLabelAttribute()
    {
       $number_of_blog_posted_verified=tourOperatorsBlogs::query()->where('status','=',1)->where('tour_operators_id',$this->id)->count();
       return $number_of_blog_posted_verified;
    }
    public function getBlogPostedUnverifiedLabelAttribute()
    {
        $number_of_blog_posted_unverified=tourOperatorsBlogs::query()->where('status','=',0)->where('tour_operators_id',$this->id)->count();
        return $number_of_blog_posted_unverified;
    }
    public function getTotalBookingsMadeLabelAttribute()
    {
        $total_bookings_made=touristBooking::query()->where('tour_operators_id',$this->id)->count();
        return $total_bookings_made;
    }

    public function getTotalBookingsVerifiedLabelAttribute()
    {
        $total_bookings_verified=touristBooking::query()->where('status','=',1)->where('tour_operators_id',$this->id)->count();
        return $total_bookings_verified;
    }
    public function getTotalBookingsUnverifiedLabelAttribute()
    {
        $total_booking_unverified=touristBooking::query()->where('status','=',0)->where('tour_operators_id',$this->id)->count();
        return $total_booking_unverified;
    }
    public function getDateOfJoiningLabelAttribute()
    {
        $date_of_joining=date('jS M Y, H:m:s',strtotime($this->created_at));
        return $date_of_joining;
    }
    public function getVerifiedTripsLabelAttribute()
    {
        $verified_trips=touristBooking::query()->where('status','=',1)->where('tour_operators_id',$this->id)->count();
        return $verified_trips;
    }
    public function getTotalSoloBookingsLabelAttribute()
    {
        $total_tourist_bookings=touristBooking::query()->where('tour_operators_id',$this->id)->count();
        return $total_tourist_bookings;
    }

    public function getUnverifiedTripsLabelAttribute()
    {
        $unverified_trips=touristBooking::query()->where('status','=',0)->where('tour_operators_id',$this->id)->count();
        return $unverified_trips;
    }
    public function getUncheckedTransactionsLabelAttribute()
    {
        $unchecked_transactions=payments::query()->where('status','=',0)->where('tour_operators_id',$this->id)->count();
        return $unchecked_transactions;
    }
    public function getCheckedTransactionsLabelAttribute()
    {
        $checked_transactions=payments::query()->where('status','=',1)->where('tour_operators_id',$this->id)->count();
        return $checked_transactions;
    }
    public function getUncheckedBlogLabelAttribute()
    {
        $unchecked_blogs=tourOperatorsBlogs::query()->where('status','=',0)->where('tour_operators_id',$this->id)->count();
        return $unchecked_blogs;
    }
    public function getCheckedBlogLabelAttribute()
    {
        $checked_blogs=tourOperatorsBlogs::query()->where('status','=',1)->where('tour_operators_id',$this->id)->count();
        return $checked_blogs;
    }
    public function getNumberOfAccountsLabelAttribute()
    {
        $number_of_account=tourOperatorAccounts::query()->where('tour_operators_id',$this->id)->count();
        return $number_of_account;
    }
    public function getNumberOfAccountsActiveLabelAttribute()
    {
        $number_of_active_accounts=tourOperatorAccounts::query()->where('status','=',1)->where('tour_operators_id',$this->id)->count();
        return $number_of_active_accounts;
    }
    public function getNumberOfInactiveAccountsLabelAttribute()
    {
        $number_of_inactive_accounts=tourOperatorAccounts::query()->where('status','=',0)->where('tour_operators_id',$this->id)->count();
        return $number_of_inactive_accounts;
    }
    public function getNumberOfCheckedTransactionsForSoloTripLabelAttribute()
    {
        $checked_transactions=soloBookingPayments::query()->where('tour_operators_id',$this->id)->where('status','=',1)->count();
        return $checked_transactions;
    }
    public function getNumberOfUncheckedTransactionsForSoloTripLabelAttribute()
    {
        $unchecked_transactions=soloBookingPayments::query()->where('tour_operators_id',$this->id)->where('status','=',0)->count();
        return $unchecked_transactions;
    }
}

