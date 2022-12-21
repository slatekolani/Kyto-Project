<?php

namespace App\Http\Controllers\touristBookings\soloBookings;

use App\Http\Controllers\Controller;
use App\Models\MemberNations\MemberNationality;
use App\Models\touristAttraction\touristAttraction;
use App\Models\touristBookings\soloBookings\soloBookings;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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
    public function destroy($id)
    {
        //
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
    public function get_solo_bookings($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $solo_booking=soloBookings::query()->orderBy('tourist_name')->where('tour_operators_id',$tour_operator->id)->get();
        return DataTables::of($solo_booking)
            ->addIndexColumn()
            ->addColumn('group_travel_category',function ($solo_booking){
                return $solo_booking->group_travel_category;
            })
            ->addColumn('tourist_name',function ($solo_booking){
                return $solo_booking->tourist_name;
            })
            ->addColumn('phone_number',function ($solo_booking){
                return $solo_booking->phone_number;
            })
            ->addColumn('email_address',function ($solo_booking){
                return $solo_booking->email_address;
            })
            ->addColumn('tourist_nation',function($solo_booking){
                return $solo_booking->tourist_nation;
            })
            ->addColumn('number_of_tourists',function ($solo_booking){
                return $solo_booking->number_of_tourists;
            })
            ->addColumn('start_date',function ($solo_booking){
                return $solo_booking->start_date;
            })
            ->addColumn('end_date',function ($solo_booking){
                return $solo_booking->end_date;
            })
            ->addColumn('trip_code',function($solo_booking){
                return $solo_booking->trip_code;
            })
            ->addColumn('tourist_request',function ($solo_booking){
                return $solo_booking->tourist_request;
            })
            ->addColumn('actions',function ($solo_booking){
               //
            })
            ->rawColumns('actions')
            ->make(true);
    }
}
