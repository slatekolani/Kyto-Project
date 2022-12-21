<?php

namespace App\Http\Controllers\touristBookings\soloBookings;

use App\Http\Controllers\Controller;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\soloBookings\soloBookingTripPals;
use Illuminate\Http\Request;

class soloBookingTripPalsController extends Controller
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
        $solo_bookings=soloBookings::query()->where('uuid',$solo_bookings_id)->first();
        return view('touristBookings.soloBookings.addTripPals')
            ->with('solo_bookings',$solo_bookings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $solo_booking_trip_pals=new soloBookingTripPals();
        $solo_booking_trip_pals->tourist_name=$request->input('tourist_name');
        $solo_booking_trip_pals->phone_number=$request->input('phone_number');
        $solo_booking_trip_pals->email_address=$request->input('email_address');
        $solo_booking_trip_pals->solo_bookings_id=$request->input('solo_bookings_id');
        $solo_booking_trip_pals->save();
        return redirect()->route('soloBookingTripPals.show',$solo_booking_trip_pals->soloBookings->uuid)->withFlashSuccess('Trip pal added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($solo_bookings_id)
    {
        $solo_bookings=soloBookings::query()->where('uuid',$solo_bookings_id)->first();
        $solo_booking_trip_pals=soloBookingTripPals::query()->where('solo_bookings_id',$solo_bookings->id)->get();
        return view('touristBookings.soloBookings.showTripPals')
            ->with('solo_bookings',$solo_bookings)
            ->with('solo_booking_trip_pals',$solo_booking_trip_pals);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
