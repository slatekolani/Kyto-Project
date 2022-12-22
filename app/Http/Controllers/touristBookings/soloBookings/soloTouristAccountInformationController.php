<?php

namespace App\Http\Controllers\touristBookings\soloBookings;

use App\Http\Controllers\Controller;
use App\Models\paymentGateways\paymentGateways;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\soloBookings\soloTouristAccountInformation;
use Illuminate\Http\Request;

class soloTouristAccountInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($solo_bookings_id)
    {
        $solo_booking=soloBookings::query()->where('uuid',$solo_bookings_id)->first();
        $payment_gateway=paymentGateways::where('status','=',1)->pluck('payment_gateway_name','id');
        return view('touristBookings.soloBookings.soloTouristAccountInformation.create')
            ->with('payment_gateway',$payment_gateway)
            ->with('solo_booking',$solo_booking);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $solo_tourist_account_information=new soloTouristAccountInformation();
        $solo_tourist_account_information->payment_gateway=$request->input('payment_gateway');
        $solo_tourist_account_information->account_name=$request->input('account_name');
        $solo_tourist_account_information->account_number=$request->input('account_number');
        $solo_tourist_account_information->solo_bookings_id=$request->input('solo_bookings_id');
        $solo_tourist_account_information->save();
        return redirect()->route('soloTouristAccountInformation.show',$solo_tourist_account_information->soloBookings->uuid)->withFlashSuccess('Account Information saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($solo_bookings_id)
    {
        $solo_booking=soloBookings::query()->where('uuid',$solo_bookings_id)->first();
        $solo_tourist_account_informations=soloTouristAccountInformation::query()->where('solo_bookings_id',$solo_booking->id)->get();
        return view('touristBookings.soloBookings.soloTouristAccountInformation.show')
            ->with('solo_tourist_account_informations',$solo_tourist_account_informations)
            ->with('solo_booking',$solo_booking);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($solo_tourist_account_information_id)
    {
        $payment_gateway=paymentGateways::all()->pluck('payment_gateway_name','id');
        $solo_tourist_account_information=soloTouristAccountInformation::query()->where('uuid',$solo_tourist_account_information_id)->first();
        return view('touristBookings.soloBookings.soloTouristAccountInformation.edit')
            ->with('payment_gateway',$payment_gateway)
            ->with('solo_tourist_account_information',$solo_tourist_account_information);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $solo_tourist_account_information_id)
    {
        $solo_tourist_account_information=soloTouristAccountInformation::query()->where('uuid',$solo_tourist_account_information_id)->first();
        $solo_tourist_account_information->payment_gateway=$request->input('payment_gateway');
        $solo_tourist_account_information->account_name=$request->input('account_name');
        $solo_tourist_account_information->account_number=$request->input('account_number');
        $solo_tourist_account_information->solo_bookings_id=$request->input('solo_bookings_id');
        $solo_tourist_account_information->save();
        return redirect()->route('soloTouristAccountInformation.show',$solo_tourist_account_information->soloBookings->uuid)->withFlashSuccess('Account Information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(soloTouristAccountInformation $tourist_account_information)
    {
        $tourist_account_information->delete();
        return redirect()->route('soloTouristAccountInformation.show',$tourist_account_information->soloBookings->uuid)->withFlashSuccess('Account Information deleted successfully');
    }
}
