<?php

namespace App\Http\Controllers\touristBookings\soloBookings;

use App\Http\Controllers\Controller;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\soloBookings\SoloTripAmount;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SoloTripAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($solo_booking_id)
    {
        $solo_booking=soloBookings::query()->where('uuid',$solo_booking_id)->first();
        $solo_trip_amount=SoloTripAmount::query()->where('solo_bookings_id',$solo_booking->id)->first();
        return view('touristBookings.SoloBookings.SoloTripAmount.index')
            ->with('solo_trip_amount',$solo_trip_amount)
            ->with('solo_booking',$solo_booking);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($solo_booking_id)
    {
        $solo_booking=soloBookings::query()->where('uuid',$solo_booking_id)->first();
        return view('touristBookings.SoloBookings.SoloTripAmount.setTripAmount')
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
        $solo_trip_amount=new SoloTripAmount();
        $solo_trip_amount->amount_to_be_paid=$request->input('amount_to_be_paid');
        $solo_trip_amount->solo_bookings_id=$request->input('solo_bookings_id');
        $solo_trip_amount->save();
        return redirect()->route('SoloTripAmount.index',$solo_trip_amount->soloBookings->uuid)->withFlashSuccess('Trip Amount set successfully');
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
    public function edit($solo_trip_amount_id)
    {
        $solo_trip_amount=SoloTripAmount::query()->where('uuid',$solo_trip_amount_id)->first();
        return view('touristBookings.SoloBookings.SoloTripAmount.edit')
            ->with('solo_trip_amount',$solo_trip_amount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $solo_trip_amount_id)
    {
        $solo_trip_amount=SoloTripAmount::query()->where('uuid',$solo_trip_amount_id)->first();
        $solo_trip_amount->amount_to_be_paid=$request->input('amount_to_be_paid');
        $solo_trip_amount->save();
        return redirect()->route('SoloTripAmount.index',$solo_trip_amount->soloBookings->uuid)->withFlashSuccess('Trip Amount Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoloTripAmount $soloTripAmount)
    {
        $soloTripAmount->delete();
        return back()->withFlashSuccess('Trip Amount deleted successfully');
    }
    public function get_solo_trip_amount($solo_booking_id)
    {
        $solo_booking=soloBookings::find($solo_booking_id);
        $solo_trip_amount=SoloTripAmount::query()->orderBy('amount_to_be_paid')->where('solo_bookings_id',$solo_booking->id)->get();
        return DataTables::of($solo_trip_amount)
            ->addIndexColumn()
            ->addColumn('date_of_setting_amount',function ($solo_trip_amount)
            {
                return date('jS M Y', strtotime($solo_trip_amount->created_at));
            })
            ->addColumn('amount_to_be_paid',function($solo_trip_amount)
            {
                return number_format($solo_trip_amount->amount_to_be_paid);
            })

            ->addColumn('action',function($solo_trip_amount)
            {
                $btn='<a href="'.route('SoloTripAmount.edit',$solo_trip_amount->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('SoloTripAmount.delete',$solo_trip_amount->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
