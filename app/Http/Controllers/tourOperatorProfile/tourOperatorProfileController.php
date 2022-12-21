<?php

namespace App\Http\Controllers\tourOperatorProfile;

use App\Http\Controllers\Controller;
use App\Http\Controllers\specialCare\specialCareController;
use App\Models\Languages\language;
use App\Models\specialCare\tourOperatorSpecialCare;
use App\Models\touristAttraction\touristAttraction;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperatorProfile\tourOperatorProfile;
use App\Models\tourOperators\tourOperatorAddress;
use App\Models\tourOperators\tourOperators;
use App\Models\transportService\transportService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class tourOperatorProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $tour_operator_addresses=tourOperatorAddress::query()->where('tour_operators_id',$tour_operator->id)->get();
        $tour_operator_account=tourOperatorAccounts::query()->where('tour_operators_id',$tour_operator->id)->get();
        return view('tourOperatorProfile.get_tour_operator_profile')
            ->with('tour_operator_addresses',$tour_operator_addresses)
            ->with('tour_operator_account',$tour_operator_account)
            ->with('tour_operator',$tour_operator);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tour_operators_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operators_id)->first();
        $special_care=tourOperatorSpecialCare::where('status','=',1)->pluck('special_care','id');
        $transport_service=transportService::where('status','=',1)->pluck('transport_name','id');
        $tourist_attraction=touristAttraction::where('status','=',1)->pluck('attraction_name','id');
        $language=language::where('status','=',1)->pluck('language_name','id');
        return view('tourOperatorProfile.create')
            ->with('language',$language)
            ->with('tourist_attraction',$tourist_attraction)
            ->with('special_care',$special_care)
            ->with('transport_service',$transport_service)
            ->with('tour_operator',$tour_operator);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();
        $tour_operator_profile=new tourOperatorProfile();
        $tour_operator_profile->about_company=$request->input('about_company');
        $tour_operator_profile->company_core_values=$request->input('company_core_values');
        $tour_operator_profile->company_experience=$request->input('company_experience');
        $tour_operator_profile->tour_operators_id=$request->input('tour_operators_id');
        if($request->hasFile('company_team_image'))
        {
            $file=$request->file('company_team_image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/TeamImage/Images/',$filename);
            $tour_operator_profile->company_team_image=$filename;
        }
        $tour_operator_profile->save();
        $tour_operator_profile->getSpecialCare($input,$tour_operator_profile);
        $tour_operator_profile->getLanguage($input,$tour_operator_profile);
        $tour_operator_profile->getTransport($input,$tour_operator_profile);
        $tour_operator_profile->gettouristAttraction($input,$tour_operator_profile);
        return redirect()->route('tourOperator.index',$tour_operator_profile->uuid)->withFlashSuccess('Company profile created successfully,please wait to be verified to use the service');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $tour_operator_profile=tourOperatorProfile::query()->where('tour_operators_id',$tour_operator->id)->first();
        $tourist_attraction=touristAttraction::all()->pluck('attraction_name','id');
        $tourist_attraction_ids=DB::table('tour_operator_profile_tourist_attraction')->where('tour_operator_profile_id',$tour_operator->id)->pluck('tourist_attraction_id');
        $special_care=tourOperatorSpecialCare::all()->pluck('special_care','id');
        $special_care_ids=DB::table('tour_operator_profile_tour_operator_special_care')->where('tour_operator_profile_id',$tour_operator->id)->pluck('tour_operator_special_care_id');
        $transport_service=transportService::all()->pluck('transport_name');
        $transport_service_ids=DB::table('tour_operator_profile_transport_service')->where('tour_operator_profile_id',$tour_operator->id)->pluck('transport_service_id');
        return view('tourOperatorProfile.edit')
            ->with('transport_service',$transport_service)
            ->with('transport_service_ids',$transport_service_ids)
            ->with('special_care',$special_care)
            ->with('special_care_ids',$special_care_ids)
            ->with('tourist_attraction',$tourist_attraction)
            ->with('tourist_attraction_ids',$tourist_attraction_ids)
            ->with('tour_operator',$tour_operator)
            ->with('tour_operator_profile',$tour_operator_profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tour_operator_profile_uuid)
    {
        $input=$request->all();
        $tour_operator_profile=tourOperatorProfile::query()->where('uuid',$tour_operator_profile_uuid)->first();
        $tour_operator_profile->about_company=$request->input('about_company');
        $tour_operator_profile->company_core_values=$request->input('company_core_values');
        $tour_operator_profile->company_experience=$request->input('company_experience');
        $tour_operator_profile->tour_operators_id=$request->input('tour_operators_id');
        if($request->hasFile('company_team_image'))
        {
            $file=$request->file('company_team_image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/TeamImage/Images/',$filename);
            $tour_operator_profile->company_team_image=$filename;
        }
        $tour_operator_profile->save();
        $tour_operator_profile->getSpecialCare($input,$tour_operator_profile);
        $tour_operator_profile->getLanguage($input,$tour_operator_profile);
        $tour_operator_profile->getTransport($input,$tour_operator_profile);
        $tour_operator_profile->gettouristAttraction($input,$tour_operator_profile);
        return redirect()->route('tourOperator.index',$tour_operator_profile->uuid)->withFlashSuccess('Company profile information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
