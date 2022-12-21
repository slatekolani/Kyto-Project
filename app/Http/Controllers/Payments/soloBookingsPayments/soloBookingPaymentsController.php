<?php

namespace App\Http\Controllers\Payments\soloBookingsPayments;

use App\Http\Controllers\Controller;
use App\Models\Payments\soloBookingPayments\soloBookingPayments;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use Illuminate\Http\Request;

class soloBookingPaymentsController extends Controller
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
        $tour_operator_accounts=tourOperatorAccounts::query()->where('tour_operators_id',$solo_bookings->tourOperators->id)->get();
        return view('Payments.soloPayments.create')
            ->with('solo_bookings',$solo_bookings)
            ->with('tour_operator_accounts',$tour_operator_accounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $solo_booking_payments=new soloBookingPayments();
        $solo_booking_payments->account_name=$request->input('account_name');
        $solo_booking_payments->amount=$request->input('amount');
        $solo_booking_payments->reference=$request->input('reference');
        $solo_booking_payments->payment_gateway=$request->input('payment_gateway');
        $solo_booking_payments->tour_operators_id=$request->input('tour_operators_id');
        $solo_booking_payments->solo_bookings_id=$request->input('solo_bookings_id');
        $solo_booking_payments->save();
        return redirect()->route('soloBookingsPayments.show',$solo_booking_payments->soloBookings->uuid)->withFlashSuccess('Payment information submitted successfully');
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
        $solo_booking_payments=soloBookingPayments::query()->where('solo_bookings_id',$solo_booking->id)->get();
        return view('Payments.soloPayments.showSoloPayments')
            ->with('solo_booking_payments',$solo_booking_payments)
            ->with('solo_booking',$solo_booking);
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
