<?php

namespace App\Http\Controllers\touristBookings;

use App\Http\Controllers\Controller;
use App\Models\MemberNations\MemberNationality;
use App\Models\touristAttraction\touristAttraction;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class touristBookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $tourist_booking=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->first();
        return view('touristBookings.index')
            ->with('tourist_booking',$tourist_booking)
            ->with('tour_operator',$tour_operator);
    }

    public function recent_bookings_index($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        return view('touristBookings.RecentBookings.index')
            ->with('tour_operator',$tour_operator);
    }
    public function recent_trips_to_be_conducted_index($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        return view('touristBookings.RecentTripsToBeConducted.index')->with('tour_operator',$tour_operator);
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
        $nation=MemberNationality::where('status','=',1)->pluck('nation_name','id');
        return view('touristBookings.create')
            ->with('tour_operator_accounts',$tour_operator_accounts)
            ->with('tour_operator_blogs',$tour_operator_blogs)
            ->with('nation',$nation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tourist_booking=new touristBooking();
        $tourist_booking->tourist_name=$request->input('tourist_name');
        $tourist_booking->phone_number=$request->input('phone_number');
        $tourist_booking->email_address=$request->input('email_address');
        $tourist_booking->tourist_nation=$request->input('tourist_nation');
        $tourist_booking->number_of_tourists = $request->input('number_of_tourists');
        $tourist_booking->start_date = $request->input('start_date');
        $tourist_booking->end_date = $request->input('end_date');
        $tourist_booking->tourist_request = $request->input('tourist_request');
        $tourist_booking->tour_operators_id = $request->input('tour_operators_id');
        $tourist_booking->tour_operators_blogs_id = $request->input('tour_operators_blogs_id');
        $tourist_booking->users_id = auth()->user()->id;
        $tourist_booking->save();
        return redirect()->route('touristBookings.show', $tourist_booking->tourOperators->uuid)->withFlashSuccess('Booking request received successfully. Please wait for the tour operator response');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('touristBookings.showBookings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tourist_bookings_id)
    {
        $nation=MemberNationality::all()->pluck('nation_name','id');
        $tourist_bookings=touristBooking::query()->where('uuid',$tourist_bookings_id)->first();
        return view('touristBookings.edit')
            ->with('nation',$nation)
            ->with('tourist_bookings',$tourist_bookings);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tourist_booking_id)
    {
        $tourist_booking=touristBooking::query()->where('uuid',$tourist_booking_id)->first();
        $tourist_booking->tourist_name=$request->input('tourist_name');
        $tourist_booking->phone_number=$request->input('phone_number');
        $tourist_booking->email_address=$request->input('email_address');
        $tourist_booking->tourist_nation=$request->input('tourist_nation');
        $tourist_booking->number_of_tourists=$request->input('number_of_tourists');
        $tourist_booking->start_date=$request->input('start_date');
        $tourist_booking->end_date=$request->input('end_date');
        $tourist_booking->tourist_request=$request->input('tourist_request');
        $tourist_booking->tour_operators_id=$request->input('tour_operators_id');
        $tourist_booking->tour_operators_blogs_id=$request->input('tour_operators_blogs_id');
        $tourist_booking->users_id=auth()->user()->id;
        $tourist_booking->save();
        return redirect()->route('touristBookings.show')->withFlashSuccess('Trip booking updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(touristBooking $tourist_bookings)
    {
       $tourist_bookings->delete();
       return redirect()->route('touristBookings.index',$tourist_bookings->tourOperators->uuid)->withFlashSuccess('Trip Booking removed successfully');
    }

    public function ConfirmationStatus(Request $request)
    {
        $tourist_bookings=touristBooking::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $tourist_bookings->status=1;
                break;
            case 1:
                $tourist_bookings->status=0;
                break;
        }
        $tourist_bookings->save();
    }
    public function overview($tour_operator)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator)->first();
        $company_bookings_verified=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->select(
            DB::raw("(COUNT(*)) as total_verified"),
            DB::raw('MONTHNAME(created_at) as month_name')
            )
            ->whereBetween('created_at',[carbon::now()->startOfYear(),carbon::now()->endOfYear()])
            ->groupBy('month_name')
            ->get();
        $company_bookings_unverified=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->select(
            DB::raw("(COUNT(*)) as total_unverified"),
            DB::raw('MONTHNAME(created_at) as month_name')
        )
            ->whereBetween('created_at',[carbon::now()->startOfYear(),carbon::now()->endOfYear()])
            ->groupBy('month_name')
            ->get();
        $total_company_monthly_bookings=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->select(
            DB::raw("(COUNT(*)) as total_monthly_bookings"),
            DB::raw('MONTHNAME(created_at) as month_name')
        )
            ->whereBetween('created_at',[carbon::now()->startOfYear(),carbon::now()->endOfYear()])
            ->groupBy('month_name')
            ->get();
        $company_bookings_weekly=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[carbon::now()->startOfWeek(),carbon::now()->endOfWeek()])->count();
        $company_approved_bookings_weekly=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->whereBetween('created_at',[carbon::now()->startOfWeek(),carbon::now()->endOfWeek()])->count();
        $company_unapproved_bookings_weekly=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->whereBetween('created_at',[carbon::now()->startOfWeek(),carbon::now()->endOfWeek()])->count();
        $company_bookings_daily=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[carbon::now()->startOfDay(),carbon::now()->endOfDay()])->count();
        $company_approved_bookings_daily=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->whereBetween('created_at',[carbon::now()->startOfDay(),carbon::now()->endOfDay()])->count();
        $company_unapproved_bookings_daily=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->whereBetween('created_at',[carbon::now()->startOfDay(),carbon::now()->endOfDay()])->count();
        $company_bookings_yearly=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[carbon::now()->startOfYear(),carbon::now()->endOfYear()])->count();
        $company_approved_bookings_yearly=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',1)->whereBetween('created_at',[carbon::now()->startOfYear(),carbon::now()->endOfYear()])->count();
        $company_unapproved_bookings_yearly=touristBooking::query()->where('tour_operators_id',$tour_operator->id)->where('status','=',0)->whereBetween('created_at',[carbon::now()->startOfYear(),carbon::now()->endOfYear()])->count();
        return view('touristBookings.overview')
            ->with('total_company_monthly_bookings',$total_company_monthly_bookings)
            ->with('company_bookings_verified',$company_bookings_verified)
            ->with('company_bookings_unverified',$company_bookings_unverified)
            ->with('company_bookings_weekly',$company_bookings_weekly)
            ->with('company_approved_bookings_weekly',$company_approved_bookings_weekly)
            ->with('company_unapproved_bookings_weekly',$company_unapproved_bookings_weekly)
            ->with('company_bookings_daily',$company_bookings_daily)
            ->with('company_approved_bookings_daily',$company_approved_bookings_daily)
            ->with('company_unapproved_bookings_daily',$company_unapproved_bookings_daily)
            ->with('company_bookings_yearly',$company_bookings_yearly)
            ->with('company_approved_bookings_yearly',$company_approved_bookings_yearly)
            ->with('company_unapproved_bookings_yearly',$company_unapproved_bookings_yearly)
            ->with('tour_operator',$tour_operator);
    }

    public function get_bookings($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $tourist_bookings=touristBooking::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->get();
        return DataTables::of($tourist_bookings)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($tourist_bookings){
                return $tourist_bookings->tourist_name;
            })
            ->addColumn('phone_number',function($tourist_bookings){
                return $tourist_bookings->phone_number;
            })
            ->addColumn('email_address',function ($tourist_bookings){
                return $tourist_bookings->email_address_label;
            })
            ->addColumn('tourist_nation',function($tourist_bookings){
                return MemberNationality::find($tourist_bookings->tourist_nation)->nation_name;
            })
            ->addColumn('blog_topic',function ($tourist_bookings){
                return touristAttraction::find($tourist_bookings->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('number_of_tourists',function ($tourist_bookings){
                return $tourist_bookings->number_of_tourists;
            })
            ->addColumn('start_date',function ($tourist_bookings){
                return date('jS M Y, H:m:s',strtotime($tourist_bookings->start_date));
            })
            ->addColumn('end_date',function ($tourist_bookings){
                return date('jS M Y, H:m:s',strtotime($tourist_bookings->end_date));
            })
            ->addColumn('booked_time',function($tourist_bookings){
                return $tourist_bookings->booked_time_label;
            })
            ->addColumn('number_of_days',function ($tourist_bookings){
                return $tourist_bookings->number_of_days_label;
            })
            ->addColumn('reserve_percent',function($tourist_bookings){
                return $tourist_bookings->tourOperatorsBlogs->guarantee_percentage;
            })

            ->addColumn('tourist_request',function ($tourist_bookings){
                return $tourist_bookings->tourist_request;
            })
            ->addColumn('confirm_trip',function($tourist_booking){
                $btn='<label class="switch{{$tourist_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('confirmation',function($tourist_booking){
                if ($tourist_booking->status==1)
                {
                    return '<span class="badge badge-pill badge-success">Confirmed</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-warning">Unconfirmed</span>';
                }
            })
            ->addColumn('total_number_of_payments',function ($tourist_booking){
                return $tourist_booking->total_number_of_payments_label;
            })
            ->addColumn('checked_payments',function ($tourist_booking){
                    return $tourist_booking->checked_number_of_payments_label;
            })
            ->addColumn('unchecked_payments',function($tourist_booking){
                if ($tourist_booking->unchecked_number_of_payments_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($tourist_booking->checked_number_of_payments_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($tourist_booking->total_number_of_payments_label==$tourist_booking->checked_number_of_payments_label)
                {
                    return '<span class="badge badge-success">Complete</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })
            ->addColumn('action',function ($tourist_bookings){
                $btn='<a href="'.route('payments.index',$tourist_bookings->uuid).'"><button class="btn btn-primary btn-sm">Payments</button></a>';
                $btn=$btn.'<a href="'.route('touristBookings.delete',$tourist_bookings->uuid).'"><button class="btn btn-danger btn-sm">Delete</button></a>';
                return $btn;
            })
            ->rawColumns(['action','confirmation','email_address','checked_payments','total_number_of_payments','unchecked_payments','number_of_days','booked_time'])
            ->make(true);
    }

    public function getAllTripForSearch()
    {
        $search=DB::table('tourist_bookings')
            ->select(
                [
                    'tourist_bookings.id as id',
                    'tourist_bookings.tour_operators_blogs_id as tour_operators_blogs_id',
                    'tourist_bookings.tourist_name as tourist_name',
                    'tourist_bookings.status as status',
                    'tourist_bookings.phone_number as phone_number',
                    'tourist_bookings.email_address as email_address',
                    'tourist_bookings.tourist_nation as tourist_nation',
                    'tourist_bookings.number_of_tourists as number_of_tourists',
                    'tourist_bookings.start_date as start_date',
                    'tourist_bookings.end_date as end_date',
                    'tourist_bookings.tourist_request as tourist_request',
                    'tourist_bookings.uuid as uuid',
                    'operator.company_name as company_name',
                    'operator.logo as logo',
                    'attraction.attraction_name as attraction_name',
                    'blog.blog_topic as blog_topic',
                    'blog.payment_range as payment_range',
                    'member_nation.nation_name as nation_name'
                    ]
            )
            ->leftJoin('member_nationality as member_nation','member_nation.id','=','tourist_bookings.tourist_nation')
            ->leftJoin('tour_operators_blogs as blog','blog.id','=','tourist_bookings.tour_operators_blogs_id')
            ->leftJoin('tour_operators as operator','operator.id','=','tourist_bookings.tour_operators_id')
            ->leftJoin('tourist_attractions as attraction','attraction.id','=','blog.blog_topic');
        return $search;
    }
    public function search_Trip_booked()
    {
        $search_trip=request()->all();
        $tourist_bookings=$this->getAllTripForSearch()->where('tourist_name','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('start_date','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('end_date','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('attraction.attraction_name','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('operator.company_name','LIKE','%'.$search_trip['search'].'%')
            ->orWhere('member_nation.nation_name','LIKE','%'.$search_trip['search'].'%')
            ->get();
        return view('touristBookings.searched_trip_booked_results',compact('tourist_bookings'));
    }
    public function get_recent_bookings($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $tourist_bookings=touristBooking::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->whereBetween('created_at',[Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->get();
        return DataTables::of($tourist_bookings)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($tourist_bookings){
                return $tourist_bookings->tourist_name;
            })
            ->addColumn('phone_number',function($tourist_bookings){
                return $tourist_bookings->phone_number;
            })
            ->addColumn('email_address',function ($tourist_bookings){
                return $tourist_bookings->email_address_label;
            })
            ->addColumn('tourist_nation',function($tourist_bookings){
                return MemberNationality::find($tourist_bookings->tourist_nation)->nation_name;
            })
            ->addColumn('blog_topic',function ($tourist_bookings){
                return touristAttraction::find($tourist_bookings->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('number_of_tourists',function ($tourist_bookings){
                return $tourist_bookings->number_of_tourists;
            })
            ->addColumn('start_date',function ($tourist_bookings){
                return date('jS M Y, H:m:s',strtotime($tourist_bookings->start_date));
            })
            ->addColumn('end_date',function ($tourist_bookings){
                return date('jS M Y, H:m:s',strtotime($tourist_bookings->end_date));
            })
            ->addColumn('booked_time',function($tourist_bookings){
                return $tourist_bookings->booked_time_label;
            })
            ->addColumn('number_of_days',function ($tourist_bookings){
                return $tourist_bookings->number_of_days_label;
            })
            ->addColumn('reserve_percent',function($tourist_bookings){
                return $tourist_bookings->tourOperatorsBlogs->guarantee_percentage;
            })

            ->addColumn('tourist_request',function ($tourist_bookings){
                return $tourist_bookings->tourist_request;
            })
            ->addColumn('confirm_trip',function($tourist_booking){
                $btn='<label class="switch{{$tourist_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('confirmation',function($tourist_booking){
                if ($tourist_booking->status==1)
                {
                    return '<span class="badge badge-pill badge-success">Confirmed</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-warning">Unconfirmed</span>';
                }
            })
            ->addColumn('total_number_of_payments',function ($tourist_booking){
                return $tourist_booking->total_number_of_payments_label;
            })
            ->addColumn('checked_payments',function ($tourist_booking){
                    return $tourist_booking->checked_number_of_payments_label;
            })
            ->addColumn('unchecked_payments',function($tourist_booking){
                if ($tourist_booking->unchecked_number_of_payments_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($tourist_booking->checked_number_of_payments_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($tourist_booking->total_number_of_payments_label==$tourist_booking->checked_number_of_payments_label)
                {
                    return '<span class="badge badge-success">Complete</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })
            ->addColumn('action',function ($tourist_bookings){
                $btn='<a href="'.route('payments.index',$tourist_bookings->uuid).'"><button class="btn btn-primary btn-sm">Payments</button></a>';
                $btn=$btn.'<a href="'.route('touristBookings.delete',$tourist_bookings->uuid).'"><button class="btn btn-danger btn-sm">Delete</button></a>';
                return $btn;
            })
            ->rawColumns(['action','confirmation','email_address','checked_payments','total_number_of_payments','unchecked_payments','number_of_days','booked_time'])
            ->make(true);
    }

    public function get_recent_trips_to_be_conducted($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $tourist_bookings=touristBooking::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->whereBetween('start_date',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
        return DataTables::of($tourist_bookings)
            ->addIndexColumn()
            ->addColumn('tourist_name',function ($tourist_bookings){
                return $tourist_bookings->tourist_name;
            })
            ->addColumn('phone_number',function($tourist_bookings){
                return $tourist_bookings->phone_number;
            })
            ->addColumn('email_address',function ($tourist_bookings){
                return $tourist_bookings->email_address_label;
            })
            ->addColumn('tourist_nation',function($tourist_bookings){
                return MemberNationality::find($tourist_bookings->tourist_nation)->nation_name;
            })
            ->addColumn('blog_topic',function ($tourist_bookings){
                return touristAttraction::find($tourist_bookings->tourOperatorsBlogs->blog_topic)->attraction_name;
            })
            ->addColumn('number_of_tourists',function ($tourist_bookings){
                return $tourist_bookings->number_of_tourists;
            })
            ->addColumn('start_date',function ($tourist_bookings){
                return date('jS M Y, H:m:s',strtotime($tourist_bookings->start_date));
            })
            ->addColumn('end_date',function ($tourist_bookings){
                return date('jS M Y, H:m:s',strtotime($tourist_bookings->end_date));
            })
            ->addColumn('booked_time',function($tourist_bookings){
                return $tourist_bookings->booked_time_label;
            })
            ->addColumn('number_of_days',function ($tourist_bookings){
                return $tourist_bookings->number_of_days_label;
            })
            ->addColumn('reserve_percent',function($tourist_bookings){
                return $tourist_bookings->tourOperatorsBlogs->guarantee_percentage;
            })

            ->addColumn('tourist_request',function ($tourist_bookings){
                return $tourist_bookings->tourist_request;
            })
            ->addColumn('confirm_trip',function($tourist_booking){
                $btn='<label class="switch{{$tourist_booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('confirmation',function($tourist_booking){
                if ($tourist_booking->status==1)
                {
                    return '<span class="badge badge-pill badge-success">Confirmed</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-warning">Unconfirmed</span>';
                }
            })
            ->addColumn('total_number_of_payments',function ($tourist_booking){
                return $tourist_booking->total_number_of_payments_label;
            })
            ->addColumn('checked_payments',function ($tourist_booking){
                return $tourist_booking->checked_number_of_payments_label;
            })
            ->addColumn('unchecked_payments',function($tourist_booking){
                if ($tourist_booking->unchecked_number_of_payments_label>0)
                {
                    return '<span class="badge badge-info">unchecked</span>';
                }
                elseif($tourist_booking->checked_number_of_payments_label==0)
                {
                    return '<span class="badge badge-warning">null</span>';
                }
                elseif($tourist_booking->total_number_of_payments_label==$tourist_booking->checked_number_of_payments_label)
                {
                    return '<span class="badge badge-success">Complete</span>';
                }
                else
                {
                    return '<span class="badge badge-danger">Error</span>';
                }
            })
            ->addColumn('action',function ($tourist_bookings){
                $btn='<a href="'.route('payments.index',$tourist_bookings->uuid).'"><button class="btn btn-primary btn-sm">Payments</button></a>';
                $btn=$btn.'<a href="'.route('touristBookings.delete',$tourist_bookings->uuid).'"><button class="btn btn-danger btn-sm">Delete</button></a>';
                return $btn;
            })
            ->rawColumns(['action','confirmation','email_address','checked_payments','total_number_of_payments','unchecked_payments','number_of_days','booked_time'])
            ->make(true);
    }

}
