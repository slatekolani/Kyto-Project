<?php

namespace App\Models\tourOperatorProfile;

use App\Models\BaseModel\BaseModel;
use App\Models\Languages\language;
use App\Models\specialCare\tourOperatorSpecialCare;
use App\Models\touristAttraction\touristAttraction;
use App\Models\tourOperatorBlogs\tour_operator_blog_cost_exclusive;
use App\Models\tourOperatorBlogs\tour_operator_blog_cost_inclusive;
use App\Models\tourOperatorBlogs\tour_operator_blog_trip_requirement;
use App\Models\tourOperators\tourOperators;
use App\Models\transportService\transportService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tourOperatorProfile extends BaseModel
{
    protected $table='tour_operator_profiles';
    protected $guarded=['uuid'];

    //relation for the profiles(tourOperatorProfiles) as for the tourOperators
    public function tourOperators()
    {
        return $this->hasOne(tourOperators::class);
    }

    //    relation for the tourOperator and the special care they provide. Pivot relation
    public function tourOperatorSpecialCare()
    {
        return $this->belongsToMany(tourOperatorSpecialCare::class);
    }

//    relation btn the transport offered by the tour Operator and the tour Operator Profiles

    public function transportService()
    {
        return $this->belongsToMany(transportService::class);
    }

//    relation between the tourist attractions and tourOperatorProfile

    public function touristAttraction()
    {
        return $this->belongsToMany(touristAttraction::class);
    }

//    A profile can access the blog costs at sometime
    public function tour_operator_blog_cost_inclusive()
    {
        return $this->hasMany(tour_operator_blog_cost_inclusive::class);
    }

//    A profile for a specific tour operator might use this information sometime
    public function tour_operator_blog_cost_exclusive()
    {
        return $this->hasMany(tour_operator_blog_cost_exclusive::class);
    }

//    A profile for a specific tour operator might sometime use this information
    public function tour_operator_blog_trip_requirement()
    {
        return $this->hasMany(tour_operator_blog_trip_requirement::class);
    }

    public function language()
    {
        return $this->belongsToMany(language::class,'language_tour_operator_profile','tour_operator_profile_id','language_id');
    }

    public function getLanguage(array $input, Model $tour_operator_profile)
    {

        $tour_operator_profile_language_array=[];
        foreach ($input as $key =>$value)
        {
            switch ($key)
            {
                case 'language_name':
                    $tour_operator_profile_language_array=$value;
                    break;
            }
        }
        $tour_operator_profile->language()->sync($tour_operator_profile_language_array);
    }

//    Function to extract the language data for a tour operator
        public function getLanguageLabelAttribute()
        {
            $language_ids=DB::table('language_tour_operator_profile')->where('tour_operator_profile_id',$this->id)->pluck('language_id');
            $languages=language::whereIn('id',$language_ids)->get();
            $language_label=[];
            foreach ($languages as $language)
            {
                array_push($language_label,$language->language_name);
            }
            return implode("~",$language_label);
        }
//    Function that will save the multiple inputs or array toward the pivot table. This is for tourOperatorProfile and special care they provide

    public function getSpecialCare(array $input,Model $tour_operator_profile)
    {
        $special_care_array=[];
        foreach ($input as $key =>$value)
        {
            switch($key){
                case 'special_care':
                    $special_care_array=$value;
                    break;
            }
        }
        $tour_operator_profile->tourOperatorSpecialCare()->sync($special_care_array);
    }
    public function getSpecialCareLabelAttribute()
    {
        $special_care_id=DB::table('tour_operator_profile_tour_operator_special_care')->where('tour_operator_profile_id',$this->id)->pluck('tour_operator_special_care_id');
        $special_cares=tourOperatorSpecialCare::whereIn('id',$special_care_id)->get();
        $special_cares_array=[];
        foreach($special_cares as $special_care)
        {
            array_push($special_cares_array,$special_care->special_care);
        }
        return implode("~",$special_cares_array);
    }

//    Function that will save the multiple inputs or array toward the pivot table.This is for tourOperatorProfile and the transport offering

    public function getTransport(array $input,Model $tour_operator_profile)
    {
        $transport_service_array=[];
        foreach ($input as $key =>$value)
        {
            switch($key)
            {
                case 'transport_name':
                    $transport_service_array=$value;
                    break;
            }
        }
        $tour_operator_profile->transportService()->sync($transport_service_array);
    }

//    Function that will save multiple inputs or array toward the pivot table. This is for tourOperatorProfiles and their operating tourist attraction areas

    public function gettouristAttraction(array $input,Model $tour_operator_profile)
    {
        $tourist_attraction_array=[];
        foreach($input as $key => $value)
        {
            switch($key)
            {
                case 'attraction_name':
                    $tourist_attraction_array=$value;
                    break;
            }
        }
        $tour_operator_profile->touristAttraction()->sync($tourist_attraction_array);
    }
    public function getTouristAttractionLabelAttribute()
    {
        $tourist_attraction_id=DB::table('tour_operator_profile_transport_service')->where('tour_operator_profile_id',$this->id)->pluck('transport_service_id');
        $tourist_attractions=touristAttraction::whereIn('id',$tourist_attraction_id)->get();
        $tourist_attraction_areas=[];
        foreach ($tourist_attractions as $tourist_attraction)
        {
            array_push($tourist_attraction_areas,$tourist_attraction->attraction_name);
        }
        return implode("~",$tourist_attraction_areas);
    }
}
