<?php

namespace App\Http\Controllers\touristBookings\soloBookings;

use App\Http\Controllers\Controller;
use App\Models\MemberNations\MemberNationality;
use App\Models\touristAttraction\touristAttraction;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\soloBookings\SoloTripAmount;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use function foo\func;

class soloBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('touristBookings.SoloBookings.index')
            ->with('solo_booking',$solo_booking)
            ->with('tour_operator',$tour_operator);
    }
    public function verifiedTripsIndex($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('touristBookings.SoloBookings.VerifiedSoloTrips.index')
            ->with('solo_booking',$solo_booking)
            ->with('tour_operator',$tour_operator);
    }

    public function unverifiedTripsIndex($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('touristBookings.SoloBookings.UnverifiedSoloTrips.index')
            ->with('solo_booking',$solo_booking)
            ->with('tour_operator',$tour_operator);
    }

    public function recentTripsToBeConductedIndex($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('touristBookings.SoloBookings.RecentSoloTripsToBeConducted.index')
            ->with('solo_booking',$solo_booking)
            ->with('tour_operator',$tour_operator);
    }

    public function recentSoloTripsBookingsIndex($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $solo_booking=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('touristBookings.SoloBookings.RecentSoloTripBookings.index')
            ->with('solo_booking',$solo_booking)
            ->with('tour_operator',$tour_operator);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tour_operator_id)
    {
        $tour_operator_blogs=tourOperatorsBlogs::query()->where('uuid',$tour_operator_id)->first();
        $tour_operator_accounts=tourOperatorAccounts::query()->where('tour_operators_id',$tour_operator_blogs->tourOperators->id)->get();
        $nation=MemberNationality::query()->where('status','=',1)->pluck('nation_name','id');
        return view('touristBookings.soloBookings.create')
            ->with('nation',$nation)
            ->with('tour_operator_accounts',$tour_operator_accounts)
            ->with('tour_operator_blogs',$tour_operator_blogs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $solo_booking=new soloBookings();
        $solo_booking->tourist_name=$request->input('tourist_name');
        $solo_booking->phone_number=$request->input('phone_number');
        $solo_booking->email_address=$request->input('email_address');
        $solo_booking->tourist_nation=$request->input('tourist_nation');
        $solo_booking->number_of_tourists=$request->input('number_of_tourists');
        $solo_booking->start_date=$request->input('start_date');
        $solo_booking->end_date=$request->input('end_date');
        $solo_booking->tourist_request=$request->input('tourist_request');
        $solo_booking->trip_code=$request->input('trip_code');
        $solo_booking->group_travel_category=$request->input('group_travel_category');
        $solo_booking->tour_operators_id=$request->input('tour_operators_id');
        $solo_booking->tour_operators_blogs_id=$request->input('tour_operators_blogs_id');
        $solo_booking->users_id=auth()->user()->id;
        $solo_booking->save();
        return redirect()->route('soloBookings.show')->withFlashSuccess('Request submitted successfully. Please wait for an approval');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('touristBookings.SoloBookings.showSoloBookings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($solo_booking_id)
    {
        $nation=MemberNationality::all()->pluck('nation_name','id');
        $solo_booking=soloBookings::query()->where('uuid',$solo_booking_id)->first();
        return view('touristBookings.SoloBookings.edit')
            ->with('nation',$nation)
            ->with('solo_booking',$solo_booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $solo_booking_id)
    {
      $solo_booking=soloBookings::query()->where('uuid',$solo_booking_id)->first();
      $solo_booking->tourist_name=$request->input('tourist_name');
      $solo_booking->phone_number=$request->input('phone_number');
      $solo_booking->email_address=$request->input('email_address');
      $solo_booking->tourist_nation=$request->input('tourist_nation');
      $solo_booking->number_of_tourists=$request->input('number_of_tourists');
      $solo_booking->start_date=$request->input('start_date');
      $solo_booking->end_date=$request->input('end_date');
      $solo_booking->tourist_request=$request->input('tourist_request');
      $solo_booking->save();
      return redirect()->route('soloBookings.show')->withFlashSuccess('Information updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(soloBookings $solo_booking)
    {
        $solo_booking->delete();
        return back()->withFlashSuccess('SoloTrip was removed successfully');
    }

    public function getAllSoloTripForSearch()
    {
        $search=DB::table('solo_bookings')
            ->select(
                [
                    'solo_bookings.id as id',
                    'solo_bookings.tour_operators_blogs_id as tour_operators_blogs_id',
                    'solo_bookings.tourist_name as tourist_name',
                    'solo_bookings.status as status',
                    'solo_bookings.phone_number as phone_number',
                    'solo_bookings.email_address as email_address',
                    'solo_bookings.tourist_nation as tourist_nation',
                    'solo_bookings.number_of_tourists as number_of_tourists',
                    'solo_bookings.start_date as start_date',
                    'solo_bookings.end_date as end_date',
                    'solo_bookings.uuid as uuid',
                    'operator.company_name as company_name',
                    'operator.logo as logo',
                    'blog.blog_topic as blog_topic',
                    'blog.payment_range as payment_range',
                    'attraction.attraction_name as attraction_name',
                    'member_nation.nation_name as nation_name'
                ]
            )
            ->leftJoin('member_nationality as member_nation','member_nation.id','=','solo_bookings.tourist_nation')
            ->leftJoin('tour_operators_blogs as blog','blog.id','=','solo_bookings.tour_operators_blogs_id')
            ->leftJoin('tour_operators as operator','operator.id','=','solo_bookings.tour_operators_id')
            ->leftJoin('tourist_attractions as attraction','attraction.id','=','blog.blog_topic');
        return $search;
    }

    public function search_Trip_booked_solo()
    {
        $search_trip=request()->all();
        $solo_bookings=$this->getAllSoloTripForSearch()->where('tourist_name','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('start_date','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('end_date','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('operator.company_name','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('attraction.attraction_name','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('member_nation.nation_name','LIKE','%'.$search_trip['search'].'%')
            ->get();
        return view('touristBookings.soloBookings.searched_trip_booked_results',compact('solo_bookings'));
    }
    public function ConfirmationStatus(Request $request)
    {
        $solo_booking=soloBookings::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $solo_booking->status=1;
                break;
            case 1:
                $solo_booking->status=0;
                break;
        }
        $solo_booking->save();
    }

    public function PublicOrPrivateTripStatus(Request $request)
    {
        $solo_booking=soloBookings::find($request->id);
        $solo_trip_public_status=$request->solo_trip_public_status;
        switch ($solo_trip_public_status)
        {
            case 0:
                $solo_booking->solo_trip_public_status=1;
                break;
            case 1:
                $solo_booking->solo_trip_public_status=0;
                break;
        }
        $solo_booking->save();
    }

    public function overview($tour_operator)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator)->first();
        $total_solo_bookings=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->select(
            DB::raw("(COUNT(*)) as total_monthly_bookings"),
            DB::raw('MONTHNAME(created_at) as month_name')
        )
            ->whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
            ->groupBy('month_name')
            ->get();
        $verified_solo_bookings=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->select(
            DB::raw("(COUNT(*)) as total_verified"),
            DB::raw('MONTHNAME(created_at) as month_name')
        )
            ->whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
            ->groupBy('month_name')
            ->get();
        $unverified_solo_bookings=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->select(
            DB::raw("(COUNT(*)) as total_unverified"),
            DB::raw('MONTHNAME(created_at) as month_name')
        )
            ->whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])
            ->groupBy('month_name')
            ->get();
        $solo_bookings_daily=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->count();
        $approved_solo_bookings_daily=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->whereBetween('created_at',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->count();
        $unapproved_solo_bookings_daily=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->whereBetween('created_at',[Carbon::now()->startOfDay(),Carbon::now()->endOfDay()])->count();
        $solo_bookings_weekly=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->count();
        $approved_solo_bookings_weekly=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->count();
        $unapproved_solo_bookings_weekly=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->count();
        $solo_bookings_yearly=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])->count();
        $approved_solo_bookings_yearly=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])->count();
        $unapproved_solo_bookings_yearly=soloBookings::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->whereBetween('created_at',[Carbon::now()->startOfYear(),Carbon::now()->endOfYear()])->count();
        return view('touristBookings.SoloBookings.overview')
            ->with('tour_operator',$tour_operator)
            ->with('verified_solo_bookings',$verified_solo_bookings)
            ->with('total_solo_bookings',$total_solo_bookings)
            ->with('unverified_solo_bookings',$unverified_solo_bookings)
            ->with('approved_solo_bookings_weekly',$approved_solo_bookings_weekly)
            ->with('unapproved_solo_bookings_weekly',$unapproved_solo_bookings_weekly)
            ->with('solo_bookings_weekly',$solo_bookings_weekly)
            ->with('solo_bookings_daily',$solo_bookings_daily)
            ->with('approved_solo_bookings_daily',$approved_solo_bookings_daily)
            ->with('unapproved_solo_bookings_daily',$unapproved_solo_bookings_daily)
            ->with('solo_bookings_yearly',$solo_bookings_yearly)
            ->with('unapproved_solo_bookings_yearly',$unapproved_solo_bookings_yearly)
            ->with('approved_solo_bookings_yearly',$approved_solo_bookings_yearly);
    }

    public function get_solo_bookings($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $solo_booking=soloBookings::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->get();
        return DataTables::of($solo_booking)
            ->addIndexColumn()
            ->addColumn('date_of_booking',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->created_at));
            })
            ->addColumn('solo_trip_public_status',function ($solo_booking)
            {
                if ($solo_booking->solo_trip_public_status==1)
                {
                    return '<span class="badge badge-info">Public</span>';
                }
                else
                {
                    return '<span class="badge badge-primary">Private</span>';
                }
            })
            ->addColumn('trip_code',function ($solo_booking)
            {
                return $solo_booking->trip_code;
            })
            ->addColumn('blog_topic',function ($solo_booking){
                return touristAttraction::find($solo_booking->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('group_travel_category',function ($solo_booking)
            {
                return $solo_booking->group_travel_category;
            })
            ->addColumn('number_of_days',function ($solo_booking)
            {
                return $solo_booking->number_of_days_for_a_solo_trip_label;
            })
            ->addColumn('tourist_name',function ($solo_booking)
            {
                return $solo_booking->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking)
            {
                return $solo_booking->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking)
            {
                return $solo_booking->email_address;
            })
            ->addColumn('tourist_nation',function ($solo_booking)
            {
                return MemberNationality::find($solo_booking->tourist_nation)->nation_name;
            })
            ->addColumn('number_of_tourists',function($solo_booking)
            {
                return $solo_booking->number_of_tourists;
            })
            ->addColumn('start_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->start_date));
            })
            ->addColumn('end_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->end_date));
            })
            ->addColumn('amount',function ($solo_booking)
            {
                if ($solo_booking->amount_to_be_paid_label!=null)
                {
                    return number_format($solo_booking->amount_to_be_paid_label);
                }
                else
                {
                    return '<span class="badge badge-danger">Unset</span>';
                }
            })
            ->addColumn('count_down_days_for_trip',function ($solo_booking)
            {
                return $solo_booking->CountDownNumberOfDaysForASoloTripLabel;
            })
            ->addColumn('count_down_days_status',function ($solo_booking)
            {
                if ($solo_booking->count_down_days_status<1)
                {
                    return '<span class="badge badge-success">On range</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Out of range</span>';
                }
            })
            ->addColumn('tourist_request',function ($solo_booking)
            {
                return $solo_booking->tourist_request;
            })

            ->addColumn('trip_confirmation',function ($solo_booking)
            {
                return $solo_booking->status_label;
            })
            ->addColumn('actions',function ($solo_booking)
            {
                return $solo_booking->button_actions_label;
            })
            ->addColumn('confirm_trip',function($solo_booking){
                $btn='<label class="switch{{$solo_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('number_of_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_transactions_label;
            })
            ->addColumn('number_of_checked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_checked_transactions_label;
            })
            ->addColumn('number_of_unchecked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_unchecked_transactions_label;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->number_of_unchecked_transactions_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($solo_booking_payment->number_of_checked_transactions_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($solo_booking_payment->number_of_transactions_label==$solo_booking_payment->number_of_checked_transactions_label)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })

            ->rawColumns(['actions','solo_trip_public_status','count_down_days_status','count_down_days_for_trip','trip_confirmation','confirm_trip','amount','number_of_transactions','number_of_checked_transactions','number_of_unchecked_transactions','payment_status'])
            ->make(true);
    }
    public function get_verified_solo_trips($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $solo_booking=soloBookings::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->get();
        return DataTables::of($solo_booking)
            ->addIndexColumn()
            ->addColumn('date_of_booking',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->created_at));
            })
            ->addColumn('solo_trip_public_status',function ($solo_booking)
            {
                if ($solo_booking->solo_trip_public_status==1)
                {
                    return '<span class="badge badge-info">Public</span>';
                }
                else
                {
                    return '<span class="badge badge-primary">Private</span>';
                }
            })
            ->addColumn('trip_code',function ($solo_booking)
            {
                return $solo_booking->trip_code;
            })
            ->addColumn('blog_topic',function ($solo_booking){
                return touristAttraction::find($solo_booking->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('group_travel_category',function ($solo_booking)
            {
                return $solo_booking->group_travel_category;
            })
            ->addColumn('number_of_days',function ($solo_booking)
            {
                return $solo_booking->number_of_days_for_a_solo_trip_label;
            })
            ->addColumn('tourist_name',function ($solo_booking)
            {
                return $solo_booking->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking)
            {
                return $solo_booking->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking)
            {
                return $solo_booking->email_address;
            })
            ->addColumn('tourist_nation',function ($solo_booking)
            {
                return MemberNationality::find($solo_booking->tourist_nation)->nation_name;
            })
            ->addColumn('number_of_tourists',function($solo_booking)
            {
                return $solo_booking->number_of_tourists;
            })
            ->addColumn('start_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->start_date));
            })
            ->addColumn('end_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->end_date));
            })
            ->addColumn('amount',function ($solo_booking)
            {
                if ($solo_booking->amount_to_be_paid_label!=null)
                {
                    return number_format($solo_booking->amount_to_be_paid_label);
                }
                else
                {
                    return '<span class="badge badge-danger">Unset</span>';
                }
            })
            ->addColumn('count_down_days_for_trip',function ($solo_booking)
            {
                return $solo_booking->CountDownNumberOfDaysForASoloTripLabel;
            })
            ->addColumn('count_down_days_status',function ($solo_booking)
            {
                if ($solo_booking->count_down_days_status<1)
                {
                    return '<span class="badge badge-success">On range</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Out of range</span>';
                }
            })
            ->addColumn('tourist_request',function ($solo_booking)
            {
                return $solo_booking->tourist_request;
            })

            ->addColumn('trip_confirmation',function ($solo_booking)
            {
                return $solo_booking->status_label;
            })
            ->addColumn('actions',function ($solo_booking)
            {
                return $solo_booking->button_actions_label;
            })
            ->addColumn('confirm_trip',function($solo_booking){
                $btn='<label class="switch{{$solo_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('number_of_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_transactions_label;
            })
            ->addColumn('number_of_checked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_checked_transactions_label;
            })
            ->addColumn('number_of_unchecked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_unchecked_transactions_label;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->number_of_unchecked_transactions_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($solo_booking_payment->number_of_checked_transactions_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($solo_booking_payment->number_of_transactions_label==$solo_booking_payment->number_of_checked_transactions_label)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })

            ->rawColumns(['actions','solo_trip_public_status','count_down_days_status','count_down_days_for_trip','trip_confirmation','confirm_trip','amount','number_of_transactions','number_of_checked_transactions','number_of_unchecked_transactions','payment_status'])
            ->make(true);
    }
    public function get_unverified_solo_trips($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $solo_booking=soloBookings::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->get();
        return DataTables::of($solo_booking)
            ->addIndexColumn()
            ->addColumn('date_of_booking',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->created_at));
            })
            ->addColumn('solo_trip_public_status',function ($solo_booking)
            {
                if ($solo_booking->solo_trip_public_status==1)
                {
                    return '<span class="badge badge-info">Public</span>';
                }
                else
                {
                    return '<span class="badge badge-primary">Private</span>';
                }
            })
            ->addColumn('trip_code',function ($solo_booking)
            {
                return $solo_booking->trip_code;
            })
            ->addColumn('blog_topic',function ($solo_booking){
                return touristAttraction::find($solo_booking->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('group_travel_category',function ($solo_booking)
            {
                return $solo_booking->group_travel_category;
            })
            ->addColumn('number_of_days',function ($solo_booking)
            {
                return $solo_booking->number_of_days_for_a_solo_trip_label;
            })
            ->addColumn('tourist_name',function ($solo_booking)
            {
                return $solo_booking->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking)
            {
                return $solo_booking->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking)
            {
                return $solo_booking->email_address;
            })
            ->addColumn('tourist_nation',function ($solo_booking)
            {
                return MemberNationality::find($solo_booking->tourist_nation)->nation_name;
            })
            ->addColumn('number_of_tourists',function($solo_booking)
            {
                return $solo_booking->number_of_tourists;
            })
            ->addColumn('start_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->start_date));
            })
            ->addColumn('end_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->end_date));
            })
            ->addColumn('amount',function ($solo_booking)
            {
                if ($solo_booking->amount_to_be_paid_label!=null)
                {
                    return number_format($solo_booking->amount_to_be_paid_label);
                }
                else
                {
                    return '<span class="badge badge-danger">Unset</span>';
                }
            })
            ->addColumn('count_down_days_for_trip',function ($solo_booking)
            {
                return $solo_booking->CountDownNumberOfDaysForASoloTripLabel;
            })
            ->addColumn('count_down_days_status',function ($solo_booking)
            {
                if ($solo_booking->count_down_days_status<1)
                {
                    return '<span class="badge badge-success">On range</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Out of range</span>';
                }
            })
            ->addColumn('tourist_request',function ($solo_booking)
            {
                return $solo_booking->tourist_request;
            })

            ->addColumn('trip_confirmation',function ($solo_booking)
            {
                return $solo_booking->status_label;
            })
            ->addColumn('actions',function ($solo_booking)
            {
                return $solo_booking->button_actions_label;
            })
            ->addColumn('confirm_trip',function($solo_booking){
                $btn='<label class="switch{{$solo_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('number_of_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_transactions_label;
            })
            ->addColumn('number_of_checked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_checked_transactions_label;
            })
            ->addColumn('number_of_unchecked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_unchecked_transactions_label;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->number_of_unchecked_transactions_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($solo_booking_payment->number_of_checked_transactions_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($solo_booking_payment->number_of_transactions_label==$solo_booking_payment->number_of_checked_transactions_label)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })

            ->rawColumns(['actions','solo_trip_public_status','count_down_days_status','count_down_days_for_trip','trip_confirmation','confirm_trip','amount','number_of_transactions','number_of_checked_transactions','number_of_unchecked_transactions','payment_status'])
            ->make(true);
    }

    public function get_recent_solo_trips_to_be_conducted($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $solo_booking=soloBookings::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->whereBetween('start_date',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
        return DataTables::of($solo_booking)
            ->addIndexColumn()
            ->addColumn('date_of_booking',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->created_at));
            })
            ->addColumn('solo_trip_public_status',function ($solo_booking)
            {
                if ($solo_booking->solo_trip_public_status==1)
                {
                    return '<span class="badge badge-info">Public</span>';
                }
                else
                {
                    return '<span class="badge badge-primary">Private</span>';
                }
            })
            ->addColumn('trip_code',function ($solo_booking)
            {
                return $solo_booking->trip_code;
            })
            ->addColumn('blog_topic',function ($solo_booking){
                return touristAttraction::find($solo_booking->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('group_travel_category',function ($solo_booking)
            {
                return $solo_booking->group_travel_category;
            })
            ->addColumn('number_of_days',function ($solo_booking)
            {
                return $solo_booking->number_of_days_for_a_solo_trip_label;
            })
            ->addColumn('tourist_name',function ($solo_booking)
            {
                return $solo_booking->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking)
            {
                return $solo_booking->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking)
            {
                return $solo_booking->email_address;
            })
            ->addColumn('tourist_nation',function ($solo_booking)
            {
                return MemberNationality::find($solo_booking->tourist_nation)->nation_name;
            })
            ->addColumn('number_of_tourists',function($solo_booking)
            {
                return $solo_booking->number_of_tourists;
            })
            ->addColumn('start_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->start_date));
            })
            ->addColumn('end_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->end_date));
            })
            ->addColumn('amount',function ($solo_booking)
            {
                if ($solo_booking->amount_to_be_paid_label!=null)
                {
                    return number_format($solo_booking->amount_to_be_paid_label);
                }
                else
                {
                    return '<span class="badge badge-danger">Unset</span>';
                }
            })
            ->addColumn('count_down_days_for_trip',function ($solo_booking)
            {
                return $solo_booking->CountDownNumberOfDaysForASoloTripLabel;
            })
            ->addColumn('count_down_days_status',function ($solo_booking)
            {
                if ($solo_booking->count_down_days_status<1)
                {
                    return '<span class="badge badge-success">On range</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Out of range</span>';
                }
            })
            ->addColumn('tourist_request',function ($solo_booking)
            {
                return $solo_booking->tourist_request;
            })

            ->addColumn('trip_confirmation',function ($solo_booking)
            {
                return $solo_booking->status_label;
            })
            ->addColumn('actions',function ($solo_booking)
            {
                return $solo_booking->button_actions_label;
            })
            ->addColumn('confirm_trip',function($solo_booking){
                $btn='<label class="switch{{$solo_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('number_of_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_transactions_label;
            })
            ->addColumn('number_of_checked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_checked_transactions_label;
            })
            ->addColumn('number_of_unchecked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_unchecked_transactions_label;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->number_of_unchecked_transactions_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($solo_booking_payment->number_of_checked_transactions_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($solo_booking_payment->number_of_transactions_label==$solo_booking_payment->number_of_checked_transactions_label)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })

            ->rawColumns(['actions','solo_trip_public_status','count_down_days_status','count_down_days_for_trip','trip_confirmation','confirm_trip','amount','number_of_transactions','number_of_checked_transactions','number_of_unchecked_transactions','payment_status'])
            ->make(true);
    }

    public function get_recent_solo_trip_bookings($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $solo_booking=soloBookings::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get();
        return DataTables::of($solo_booking)
            ->addIndexColumn()
            ->addColumn('date_of_booking',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->created_at));
            })
            ->addColumn('solo_trip_public_status',function ($solo_booking)
            {
                if ($solo_booking->solo_trip_public_status==1)
                {
                    return '<span class="badge badge-info">Public</span>';
                }
                else
                {
                    return '<span class="badge badge-primary">Private</span>';
                }
            })
            ->addColumn('trip_code',function ($solo_booking)
            {
                return $solo_booking->trip_code;
            })
            ->addColumn('blog_topic',function ($solo_booking){
                return touristAttraction::find($solo_booking->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('group_travel_category',function ($solo_booking)
            {
                return $solo_booking->group_travel_category;
            })
            ->addColumn('number_of_days',function ($solo_booking)
            {
                return $solo_booking->number_of_days_for_a_solo_trip_label;
            })
            ->addColumn('tourist_name',function ($solo_booking)
            {
                return $solo_booking->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking)
            {
                return $solo_booking->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking)
            {
                return $solo_booking->email_address;
            })
            ->addColumn('tourist_nation',function ($solo_booking)
            {
                return MemberNationality::find($solo_booking->tourist_nation)->nation_name;
            })
            ->addColumn('number_of_tourists',function($solo_booking)
            {
                return $solo_booking->number_of_tourists;
            })
            ->addColumn('start_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->start_date));
            })
            ->addColumn('end_date',function ($solo_booking)
            {
                return date('jS M Y, H:m:s',strtotime($solo_booking->end_date));
            })
            ->addColumn('amount',function ($solo_booking)
            {
                if ($solo_booking->amount_to_be_paid_label!=null)
                {
                    return number_format($solo_booking->amount_to_be_paid_label);
                }
                else
                {
                    return '<span class="badge badge-danger">Unset</span>';
                }
            })
            ->addColumn('count_down_days_for_trip',function ($solo_booking)
            {
                return $solo_booking->CountDownNumberOfDaysForASoloTripLabel;
            })
            ->addColumn('count_down_days_status',function ($solo_booking)
            {
                if ($solo_booking->count_down_days_status<1)
                {
                    return '<span class="badge badge-success">On range</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Out of range</span>';
                }
            })
            ->addColumn('tourist_request',function ($solo_booking)
            {
                return $solo_booking->tourist_request;
            })

            ->addColumn('trip_confirmation',function ($solo_booking)
            {
                return $solo_booking->status_label;
            })
            ->addColumn('actions',function ($solo_booking)
            {
                return $solo_booking->button_actions_label;
            })
            ->addColumn('confirm_trip',function($solo_booking){
                $btn='<label class="switch{{$solo_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('number_of_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_transactions_label;
            })
            ->addColumn('number_of_checked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_checked_transactions_label;
            })
            ->addColumn('number_of_unchecked_transactions',function ($solo_booking_payment){
                return $solo_booking_payment->number_of_unchecked_transactions_label;
            })
            ->addColumn('payment_status',function ($solo_booking_payment){
                if ($solo_booking_payment->number_of_unchecked_transactions_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($solo_booking_payment->number_of_checked_transactions_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($solo_booking_payment->number_of_transactions_label==$solo_booking_payment->number_of_checked_transactions_label)
                {
                    return '<span class="badge badge-success">Checked</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })

            ->rawColumns(['actions','solo_trip_public_status','count_down_days_status','count_down_days_for_trip','trip_confirmation','confirm_trip','amount','number_of_transactions','number_of_checked_transactions','number_of_unchecked_transactions','payment_status'])
            ->make(true);
    }

}
