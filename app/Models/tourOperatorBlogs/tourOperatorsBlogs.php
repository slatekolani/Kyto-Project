<?php

namespace App\Models\tourOperatorBlogs;

use App\Models\Auth\User;
use App\Models\BaseModel\BaseModel;
use App\Models\Home\homePage;
use App\Models\specialCare\tourOperatorSpecialCare;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperators\tourOperators;
use App\Models\tourType\tourTypes;
use App\Models\transportService\transportService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tourOperatorsBlogs extends BaseModel
{
    protected $table='tour_operators_blogs';
    protected $guarded=['uuid'];


//    relation that the blogs posted belongs to a tour Operator
    public function tourOperators()
    {
        return $this->belongsTo(tourOperators::class);
    }

//    relation for tourOperatorsBlogs to many tourOperatorBlogsServices

    public function tourOperatorBlogService()
    {
        return $this->hasMany(tourOperatorBlogService::class);
    }

//    relation for blogs posted possess many honey points content in it.
    public function tourOperatorBlogHoneyPoints()
    {
        return $this->hasMany(tourOperatorBlogHoneyPoints::class);
    }
    /* Blogs to be displayed to the home page*/
    public function homePage()
    {
        return $this->hasMany(homePage::class);
    }

    /*A blog posted is possessed by a user*/
    public  function User()
    {
        return $this->belongsTo(User::class,'users_id');
    }


//    Blog contains many bookings
    public function touristBooking()
    {
        return $this->hasMany(touristBooking::class);
    }

    public function soloBookings()
    {
        return $this->hasMany(soloBookings::class);
    }
//    get the rates value for the tourOperator
    public function getRatingAverageAttribute()
    {
        $tour_operator=tourOperators::find($this->tour_operators_id);
        $total_rates=$tour_operator->tourOperatorRating->count();
        $average_rates=$total_rates/5;
        return $average_rates;
    }

    public function getBlogTopicImageLabelAttribute()
    {
        return url('public/BlogImages/topicImages/'.$this->blog_topic_image);
    }

//    A specific blog has many cost inclusive cost list
    public function tour_operator_blog_cost_inclusive()
    {
        return $this->hasMany(tour_operator_blog_cost_inclusive::class);
    }

//    A specific blog with a certain topic has many exclusive cost list
    public function tour_operator_blog_cost_exclusive()
    {
        return $this->hasMany(tour_operator_blog_cost_exclusive::class);
    }

//    All trip requirements re for a specific blog topic (attraction area)
    public function tour_operator_blog_trip_requirement()
    {
        return $this->hasMany(tour_operator_blog_trip_requirement::class);
    }


    public function getButtonActionsAttribute()
    {

        $status=$this->status;
        switch ($status)
        {
            case 0:
                $btn='<a href="'.route('tourOperatorBlogs.edit',$this->uuid).'"><button class="btn btn-primary btn-sm">Edit</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogs.delete',$this->uuid).'"><button class="btn btn-danger btn-sm">Delete</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogServices.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Services</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogHoneyPoints.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Honey-Points</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogCostInclusive.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Cost Inclusives</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogCostExclusive.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Cost Exclusives</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogTripRequirement.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Trip Requirement</button></a>';
                return $btn;
                break;

            case 1:
                $btn='<a href="'.route('tourOperatorBlogs.edit',$this->uuid).'"><button class="btn btn-primary btn-sm">Edit</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogs.delete',$this->uuid).'"><button class="btn btn-danger btn-sm">Delete</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogServices.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Services</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogHoneyPoints.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Honey-Points</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogCostInclusive.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Cost Inclusives</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogCostExclusive.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Cost Exclusives</button></a>';
                $btn=$btn.'<a href="'.route('tourOperatorBlogTripRequirement.index',$this->uuid).'"><button class="btn btn-primary btn-sm">Trip Requirement</button></a>';
                return $btn;
                break;
        }
    }

//    relation between the blog and the  attention they serve to the special needy in a specific blog topic area. The table naming wasnt cool till it was defined into this relation
    public function tourOperatorSpecialCare()
    {
        return $this->belongsToMany(tourOperatorSpecialCare::class,'tour_operator_blog_tour_operator_special_care','tour_operator_blog_id','tour_operator_special_care_id');
    }
// The transport is being saved into the pivot table.
    public function getSpecialCare(array $input,Model $tour_operator_blogs)
    {
        $tour_operator_blogs_special_care_array=[];
        foreach($input as $key => $value)
        {
            switch($key)
            {
                case 'special_care':
                    $tour_operator_blogs_special_care_array=$value;
                    break;
            }
        }
        $tour_operator_blogs->tourOperatorSpecialCare()->sync($tour_operator_blogs_special_care_array);
    }
//    The relation between the transport offered in a specific blog of a certain topic
    public function transportService()
    {
        return $this->belongsToMany(transportService::class,'blog_transport_service','blog_id','transport_service_id');
    }

    public function getTransportOffered(array $input,Model $tour_operator_blogs)
    {
        $tour_operator_blogs_transport_offered_array=[];
        foreach ($input as $key => $value)
        {
            switch ($key)
            {
                case 'transport_offered':
                    $tour_operator_blogs_transport_offered_array=$value;
                    break;
            }
        }
        $tour_operator_blogs->transportService()->sync($tour_operator_blogs_transport_offered_array);
    }

//    The blog topic attraction area is offered in several tour types
    public function tourTypes()
    {
        return $this->belongsToMany(tourTypes::class,'tour_type_tour_operator_blog','tour_operator_blog_id','tour_type_id');
    }

//    The tour types are saved for a specific blog topic attraction area
    public function gettourTypes(array $input, Model $tour_operator_blogs)
    {
        $tour_operator_blogs_tour_types=[];
        foreach($input as $key => $value)
        {
            switch ($key)
            {
                case 'tour_type_name':
                    $tour_operator_blogs_tour_types=$value;
                    break;
            }
        }
        $tour_operator_blogs->tourTypes()->sync($tour_operator_blogs_tour_types);
    }

    public function gettourTypesLabelAttribute()
    {
        $tour_type_id=DB::table('tour_type_tour_operator_blog')->where('tour_operator_blog_id',$this->id)->pluck('tour_type_id');
        $tour_types=tourTypes::whereIn('id',$tour_type_id)->get();
        $label=[];
        foreach($tour_types as $tour_type)
        {
            array_push($label,$tour_type->tour_type_name);
        }
        return implode("~",$label);

    }
    public function getTransportOfferedLabelAttribute()
    {
        $transport_offered_id=DB::table('blog_transport_service')->where('blog_id',$this->id)->pluck('transport_service_id');
        $transport_offers=transportService::whereIn('id',$transport_offered_id)->get();
        $transports=[];
        foreach ($transport_offers as $transport_offer)
        {
            array_push($transports,$transport_offer->transport_name);
        }
        return implode("~",$transports);
    }

    public function getSpecialCareLabelAttribute()
    {
        $special_care_id=DB::table('tour_operator_blog_tour_operator_special_care')->where('tour_operator_blog_id',$this->id)->pluck('tour_operator_special_care_id');
        $special_cares=tourOperatorSpecialCare::whereIn('id',$special_care_id)->get();
        $special_care_label=[];
        foreach($special_cares as $special_care)
        {
            array_push($special_care_label,$special_care->special_care);
        }
        return implode("~",$special_care_label);
    }

}
