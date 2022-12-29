<?php

namespace App\Http\Controllers\Payments\soloBookingsPayments;

use App\Http\Controllers\Controller;
use App\Models\paymentGateways\paymentGateways;
use App\Models\Payments\soloBookingPayments\soloBookingPayments;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperators\tourOperators;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use function foo\func;

class soloBookingPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($solo_booking_id)
    {
        $solo_booking=soloBookings::query()->where('uuid',$solo_booking_id)->first();
        $solo_booking_payments=soloBookingPayments::query()->where('solo_bookings_id',$solo_booking->id)->first();
        return view('Payments.soloPayments.index')
            ->with('solo_booking',$solo_booking)
            ->with('solo_booking_payments',$solo_booking_payments);
    }

    public function recentSoloTripPaymentsIndex($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('Payments.soloPayments.RecentSoloPayments.index')
            ->with('tour_operator',$tour_operator)
            ->with('solo_booking',$solo_booking);
    }

    public function verifiedSoloTripPaymentsIndex($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('Payments.soloPayments.VerifiedSoloTripPayments.index')
            ->with('tour_operator',$tour_operator)
            ->with('solo_booking',$solo_booking);
    }

    public function unverifiedSoloTripPaymentsIndex($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('Payments.soloPayments.UnverifiedSoloTripPayments.index')
            ->with('tour_operator',$tour_operator)
            ->with('solo_booking',$solo_booking);
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
        return redirect()->route('soloBookingPayments.show',$solo_booking_payments->soloBookings->uuid)->withFlashSuccess('Payment information submitted successfully');
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
    public function edit($solo_booking_payment_id)
    {
        $solo_booking_payment=soloBookingPayments::query()->where('uuid',$solo_booking_payment_id)->first();
        return view('Payments.soloPayments.edit')
            ->with('solo_booking_payment',$solo_booking_payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $solo_booking_payment_id)
    {
        $solo_booking_payment=soloBookingPayments::query()->where('uuid',$solo_booking_payment_id)->first();
        $solo_booking_payment->account_name=$request->input('account_name');
        $solo_booking_payment->amount=$request->input('amount');
        $solo_booking_payment->reference=$request->input('reference');
        $solo_booking_payment->payment_gateway=$request->input('payment_gateway');
        $solo_booking_payment->tour_operators_id=$request->input('tour_operators_id');
        $solo_booking_payment->save();
        return redirect()->route('soloBookingPayments.index',$solo_booking_payment->soloBookings->uuid)->withFlashSuccess('Trip Payment Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(soloBookingPayments $solo_booking_payment)
    {
       $solo_booking_payment->delete();
       return back()->withFlashSuccess('Trip payment deleted successfully');
    }

    public function changePaymentStatus(Request $request)
    {
        $solo_booking_payment=soloBookingPayments::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $solo_booking_payment->status=1;
                break;
            case 1:
                $solo_booking_payment->status=0;
                break;
        }
        $solo_booking_payment->save();
    }

    public function get_solo_payments($solo_booking_id)
    {
        $solo_booking=soloBookings::query()->where('uuid',$solo_booking_id)->first();
        $solo_booking_payment=soloBookingPayments::query()->orderBy('account_name')->where('solo_bookings_id',$solo_booking->id)->get();
        return DataTables::of($solo_booking_payment)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->email_address;
            })
            ->addColumn('date_of_booking',function ($solo_booking_payment)
            {
                return date('jS M Y , H:m:s',strtotime($solo_booking_payment->soloBookings->created_at));
            })
            ->addColumn('account_name',function ($solo_booking_payment){
                return $solo_booking_payment->account_name;
            })
            ->addColumn('amount',function ($solo_booking_payment){
                return $solo_booking_payment->amount;
            })
            ->addColumn('reference',function ($solo_booking_payment){
                return $solo_booking_payment->reference;
            })
            ->addColumn('payment_gateway',function ($solo_booking_payment){
                return paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway_name;
            })
            ->addColumn('verify_payment',function($solo_booking_payment){
                $btn='<label class="switch{{$solo_booking_payment->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->status==1)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-warning">Pending</span>';
                }
            })
            ->addColumn('action',function ($solo_booking_payment){
                $btn='<a href="'.route('soloBookingPayments.edit',$solo_booking_payment->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('soloBookingPayments.delete',$solo_booking_payment->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','verify_payment','payment_status'])
            ->make(true);

    }
    public function get_recent_solo_trip_payments($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking_payment=soloBookingPayments::query()->orderBy('account_name')->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get();
        return DataTables::of($solo_booking_payment)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->email_address;
            })
            ->addColumn('date_of_booking',function ($solo_booking_payment)
            {
                return date('jS M Y , H:m:s',strtotime($solo_booking_payment->soloBookings->created_at));
            })
            ->addColumn('account_name',function ($solo_booking_payment){
                return $solo_booking_payment->account_name;
            })
            ->addColumn('amount',function ($solo_booking_payment){
                return $solo_booking_payment->amount;
            })
            ->addColumn('reference',function ($solo_booking_payment){
                return $solo_booking_payment->reference;
            })
            ->addColumn('payment_gateway',function ($solo_booking_payment){
                return paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway_name;
            })
            ->addColumn('verify_payment',function($solo_booking_payment){
                $btn='<label class="switch{{$solo_booking_payment->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->status==1)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-warning">Pending</span>';
                }
            })
            ->addColumn('action',function ($solo_booking_payment){
                $btn='<a href="'.route('soloBookingPayments.edit',$solo_booking_payment->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('soloBookingPayments.delete',$solo_booking_payment->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','verify_payment','payment_status'])
            ->make(true);
    }

    public function getVerifiedSoloTripPayments($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking_payment=soloBookingPayments::query()->orderBy('account_name')->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->get();
        return DataTables::of($solo_booking_payment)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->email_address;
            })
            ->addColumn('date_of_booking',function ($solo_booking_payment)
            {
                return date('jS M Y , H:m:s',strtotime($solo_booking_payment->soloBookings->created_at));
            })
            ->addColumn('account_name',function ($solo_booking_payment){
                return $solo_booking_payment->account_name;
            })
            ->addColumn('amount',function ($solo_booking_payment){
                return $solo_booking_payment->amount;
            })
            ->addColumn('reference',function ($solo_booking_payment){
                return $solo_booking_payment->reference;
            })
            ->addColumn('payment_gateway',function ($solo_booking_payment){
                return paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway_name;
            })
            ->addColumn('verify_payment',function($solo_booking_payment){
                $btn='<label class="switch{{$solo_booking_payment->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->status==1)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-warning">Pending</span>';
                }
            })
            ->addColumn('action',function ($solo_booking_payment){
                $btn='<a href="'.route('soloBookingPayments.edit',$solo_booking_payment->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('soloBookingPayments.delete',$solo_booking_payment->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','verify_payment','payment_status'])
            ->make(true);
    }

    public function getUnverifiedSoloTripPayments($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking_payment=soloBookingPayments::query()->orderBy('account_name')->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->get();
        return DataTables::of($solo_booking_payment)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking_payment)
            {
                return $solo_booking_payment->soloBookings->email_address;
            })
            ->addColumn('date_of_booking',function ($solo_booking_payment)
            {
                return date('jS M Y , H:m:s',strtotime($solo_booking_payment->soloBookings->created_at));
            })
            ->addColumn('account_name',function ($solo_booking_payment){
                return $solo_booking_payment->account_name;
            })
            ->addColumn('amount',function ($solo_booking_payment){
                return $solo_booking_payment->amount;
            })
            ->addColumn('reference',function ($solo_booking_payment){
                return $solo_booking_payment->reference;
            })
            ->addColumn('payment_gateway',function ($solo_booking_payment){
                return paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway_name;
            })
            ->addColumn('verify_payment',function($solo_booking_payment){
                $btn='<label class="switch{{$solo_booking_payment->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->status==1)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-warning">Pending</span>';
                }
            })
            ->addColumn('action',function ($solo_booking_payment){
                $btn='<a href="'.route('soloBookingPayments.edit',$solo_booking_payment->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('soloBookingPayments.delete',$solo_booking_payment->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','verify_payment','payment_status'])
            ->make(true);
    }
}
