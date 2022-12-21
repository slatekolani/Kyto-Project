<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\paymentGateways\paymentGateways;
use App\Models\Payments\payments;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperators\tourOperators;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class paymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tourist_booking_id)
    {
        $tourist_booking=touristBooking::query()->where('uuid',$tourist_booking_id)->first();
        return view('payments.index')
            ->with('tourist_booking',$tourist_booking);
    }
    public function recent_payments_index($tourist_booking_id)
    {
        $tourist_booking=touristBooking::query()->where('uuid',$tourist_booking_id)->first();
        return view('payments.RecentPayments.index')
            ->with('tourist_booking',$tourist_booking);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tour_operator_id)
    {
        $tourist_booking=touristBooking::query()->where('uuid',$tour_operator_id)->first();
        $tour_operator_accounts=tourOperatorAccounts::query()->where('tour_operators_id',$tourist_booking->tourOperators->id)->get();
        return view('Payments.create')
            ->with('tour_operator_accounts',$tour_operator_accounts)
            ->with('tourist_booking',$tourist_booking);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payments=new payments();
        $payments->account_name=$request->input('account_name');
        $payments->amount=$request->input('amount');
        $payments->reference=$request->input('reference');
        $payments->payment_gateway=$request->input('payment_gateway');
        $payments->tour_operators_id=$request->input('tour_operators_id');
        $payments->tourist_bookings_id=$request->input('tourist_bookings_id');
        $payments->save();
        return redirect()->route('payments.show',$payments->touristBookings->uuid)->withFlashSuccess('Payment Information submitted successfully. Wait for the payment to be verified');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tourist_booking_id)
    {
        $tourist_booking=touristBooking::query()->where('uuid',$tourist_booking_id)->first();
        $booking_payments=payments::query()->where('tourist_bookings_id',$tourist_booking->id)->get();
        return view('Payments.show')
            ->with('tourist_booking',$tourist_booking)
            ->with('booking_payments',$booking_payments);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($payment_id)
    {
        $payment=payments::query()->where('uuid',$payment_id)->first();
        return view('payments.edit')
            ->with('payment',$payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $payment_id)
    {
        $payments=payments::query()->where('uuid',$payment_id)->first();
        $payments->account_name=$request->input('account_name');
        $payments->amount=$request->input('amount');
        $payments->reference=$request->input('reference');
        $payments->payment_gateway=$request->input('payment_gateway');
        $payments->tour_operators_id=$request->input('tour_operators_id');
//        $payments->tourist_bookings_id=$request->input('tourist_bookings_id');
        $payments->save();
        return redirect()->route('payments.index',$payments->touristBookings->uuid)->withFlashSuccess('Payment data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(payments $booking_payments)
    {
        $booking_payments->delete();
        return redirect()->route('payments.index',$booking_payments->touristBookings->uuid)->withFlashSuccess('Payment terminated successfully');
    }

    public function changePaymentStatus(Request $request)
    {
        $booking_payments= payments::find($request->id);
        $status = $request->status;
        switch ($status)
        {
            case 0 :
                $booking_payments->status = 1;
                break;
            case 1:
                $booking_payments->status = 0;
                break;
        }
        $booking_payments->save();
    }

    public function get_payments($tourist_booking_id)
    {
        $tourist_booking=touristBooking::query()->where('uuid',$tourist_booking_id)->first();
        $booking_payments=payments::query()->orderBy('account_name')->where('tourist_bookings_id',$tourist_booking->id)->get();
        return DataTables::of($booking_payments)
            ->addIndexColumn()
            ->addColumn('account_name',function($booking_payments)
            {
                return $booking_payments->account_name;
            })
            ->addColumn('amount',function ($booking_payments)
            {
                return $booking_payments->amount;
            })
            ->addColumn('reference',function ($booking_payments)
            {
                return $booking_payments->reference;
            })

            ->addColumn('payment_gateway',function ($booking_payments)
            {
                return paymentGateways::find($booking_payments->payment_gateway)->payment_gateway_name;
            })
            ->addColumn('status',function($booking_payments)
            {
                return $booking_payments->status;
            })
            ->addColumn('actions',function ($booking_payments)
            {
                $btn='<label class="switch{{$booking_payments->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('action_status',function ($booking_payments)
            {
                if($booking_payments->status==0)
                {
                    return '<span class="badge badge-warning">Pending</span>';
                }
                else
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
            })

            ->addColumn('buttons',function ($booking_payments)
            {
                $btn='<a href="'.route('payments.edit',$booking_payments->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('payments.delete',$booking_payments->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['buttons','status','actions','action_status'])
            ->make(true);
    }
    public function get_recent_payments($tourist_booking_id)
    {
        $tourist_booking=touristBooking::query()->where('uuid',$tourist_booking_id)->first();
        $booking_payments=payments::query()->orderBy('account_name')->where('tourist_bookings_id',$tourist_booking->id)->whereBetween('created_at',[carbon::now()->startOfWeek(),carbon::now()->endOfWeek()])->get();
        return DataTables::of($booking_payments)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($booking_payments)
            {
                return $booking_payments->touristBookings->tourist_name;
            })
            ->addColumn('phone_number',function ($booking_payments)
            {
                return $booking_payments->touristBookings->phone_number;
            })
            ->addColumn('email_address',function ($booking_payments)
            {
                return $booking_payments->touristBookings->email_address;
            })
            ->addColumn('date_of_booking',function ($booking_payments)
            {
                return date('jS M Y , H:m:s',strtotime($booking_payments->touristBookings->created_at));
            })
            ->addColumn('account_name',function($booking_payments)
            {
                return $booking_payments->account_name;
            })
            ->addColumn('amount',function ($booking_payments)
            {
                return $booking_payments->amount;
            })
            ->addColumn('reference',function ($booking_payments)
            {
                return $booking_payments->reference;
            })

            ->addColumn('payment_gateway',function ($booking_payments)
            {
                return paymentGateways::find($booking_payments->payment_gateway)->payment_gateway_name;
            })
            ->addColumn('status',function($booking_payments)
            {
                return $booking_payments->status;
            })
            ->addColumn('actions',function ($booking_payments)
            {
                $btn='<label class="switch{{$booking_payments->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('action_status',function ($booking_payments)
            {
                if($booking_payments->status==0)
                {
                    return '<span class="badge badge-warning">Pending</span>';
                }
                else
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
            })

            ->addColumn('buttons',function ($booking_payments)
            {
                $btn='<a href="'.route('payments.edit',$booking_payments->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('payments.delete',$booking_payments->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['buttons','status','actions','action_status','tourist_name','phone_number','email_address'])
            ->make(true);
    }
}
