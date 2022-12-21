<?php

namespace App\Http\Controllers\tourOperators;

use App\Http\Controllers\Controller;
use App\Models\MemberNations\MemberNationality;
use App\Models\touristBookings\touristBooking;
use App\Models\tourOperators\tourOperatorAddress;
use App\Models\tourOperators\tourOperators;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class tourOperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tourOperator.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nation=MemberNationality::where('status','=',1)->pluck('nation_name','id');
            return view('tourOperator.create')
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
            $tour_operator=new tourOperators();
            $tour_operator->company_name=$request->input('company_name');
            $tour_operator->phone_number=$request->input('phone_number');
            $tour_operator->email_address=$request->input('email_address');
            $tour_operator->company_nation=$request->input('company_nation');
            $tour_operator->company_website_url=$request->input('company_website_url');
            $tour_operator->company_instagram_url=$request->input('company_instagram_url');
            $tour_operator->GPS_link=$request->input('GPS_link');
            $tour_operator->whatsapp_direct_link=$request->input('whatsapp_direct_link');
            $tour_operator->users_id=auth()->user()->id;
            if($request->hasFile('logo'))
            {
                $file=$request->file('logo');
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('public/logo_uploads/Logo/',$filename);
                $tour_operator->logo=$filename;
            }
            $tour_operator->save();

            //save operators honey points
            $this->savetourOperatorAddress($request,$tour_operator);
            return redirect()->route('tourOperatorProfile.create',$tour_operator->uuid)->withFlashSuccess('Initial information received successfully, please proceed with filling in your profile information');
        }


    public function savetourOperatorAddress($request,$tour_operator)
    {
        $input=$request->all();
        foreach ($input as $key =>$value)
        {
            if(str_contains($key,'company_operating_regions')!==false)
            {
                $key_id=substr($key,25);

                $tour_operator_address_array=[
                    'company_operating_regions'=>$input['company_operating_regions'.$key_id],
                    'company_address'=>$input['company_address'.$key_id],
                    'company_contact'=>$input['company_contact'.$key_id],
                    'tour_operators_id'=>$tour_operator->id
                ];
//                Saves tour operators Address

                $tour_operator_address=new tourOperatorAddress();
                $tour_operator_address->company_operating_regions=$tour_operator_address_array['company_operating_regions'];
                $tour_operator_address->company_contact=$tour_operator_address_array['company_contact'];
                $tour_operator_address->company_address=$tour_operator_address_array['company_address'];
                $tour_operator_address->tour_operators_id=$tour_operator_address_array['tour_operators_id'];
                $tour_operator_address->save();
            }
        }
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
    public function edit($tour_operators_id)
    {
        $nation=MemberNationality::all()->pluck('nation_name','id');
        $tour_operator=tourOperators::query()->where('uuid',$tour_operators_id)->first();
        $tour_operator_addresses=tourOperatorAddress::query()->where('tour_operators_id',$tour_operator->id)->get();
        return view('tourOperator.edit')
            ->with('nation',$nation)
            ->with('tour_operator_addresses',$tour_operator_addresses)
            ->with('tour_operator',$tour_operator);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tourOperators $tour_operator)
    {
        $tour_operator=tourOperators::find($tour_operator->id);
        $tour_operator->company_name=$request->input('company_name');
        $tour_operator->phone_number=$request->input('phone_number');
        $tour_operator->email_address=$request->input('email_address');
        $tour_operator->company_nation=$request->input('company_nation');
        $tour_operator->company_website_url=$request->input('company_website_url');
        $tour_operator->company_instagram_url=$request->input('company_instagram_url');
        $tour_operator->GPS_link=$request->input('GPS_link');
        $tour_operator->whatsapp_direct_link=$request->input('whatsapp_direct_link');
        $tour_operator->users_id=auth()->user()->id;
        if($request->hasFile('logo'))
        {
            $file=$request->file('logo');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/logo_uploads/Logo/',$filename);
            $tour_operator->logo=$filename;
        }
        $tour_operator->save();
        $this->savetourOperatorAddress($request,$tour_operator);
        return redirect()->route('tourOperatorProfile.edit',$tour_operator->uuid)->withFlashSuccess('Initial information received successfully, please proceed with filling in your profile information');

    }

    public function UpdatetourOperatorAddress($request,$tour_operator)
    {
        $input=$request->all();
        foreach ($input as $key =>$value)
        {
            if(str_contains($key,'company_operating_regions')!==false)
            {
                $key_id=substr($key,25);

                $tour_operator_address_array=[
                    'company_operating_regions'=>$input['company_operating_regions'.$key_id],
                    'company_address'=>$input['company_address'.$key_id],
                    'company_contact'=>$input['company_contact'.$key_id],
                    'tour_operators_id'=>$tour_operator->id
                ];
//                Saves tour operators Address

                $tour_operator_address=tourOperatorAddress::find($tour_operator->id);
                $tour_operator_address->company_operating_regions=$tour_operator_address_array['company_operating_regions'];
                $tour_operator_address->company_contact=$tour_operator_address_array['company_contact'];
                $tour_operator_address->company_address=$tour_operator_address_array['company_address'];
                $tour_operator_address->tour_operators_id=$tour_operator_address_array['tour_operators_id'];
                $tour_operator_address->save();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tourOperators $tour_operator)
    {
        $tour_operator->delete();
        return redirect()->route('tourOperator.index')->withFlashSuccess('Tour company deleted successfully');
    }

    public function activateCompanyStatus(Request $request)
    {
        $tour_operator=tourOperators::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $tour_operator->status=1;
                break;
            case 1:
                $tour_operator->status=0;
                break;
        }
        $tour_operator->save();
    }

    public function get_tour_operator()
    {
        $tour_operator=tourOperators::Query()->where('users_id',auth()->user()->id)->orderBy('company_name')->get();
        return DataTables::of($tour_operator)
            ->addIndexColumn()
            ->addColumn('logo', function ($tour_operator) {
                return $tour_operator->logo_label;
            })
            ->addColumn('company_name', function ($tour_operator) {
                return ($tour_operator->company_name);
            })
            ->addColumn('phone_number', function ($tour_operator) {
                return $tour_operator->phone_number;
            })
            ->addColumn('email_address', function ($tour_operator) {
                return $tour_operator->email_address;
            })
            ->addColumn('date_of_joining',function($tour_operator){
                return $tour_operator->date_of_joining_label;
            })
            ->addColumn('company_nation', function($tour_operator){
                return MemberNationality::find($tour_operator->company_nation)->nation_name;
            })

            ->addColumn('company_instagram_url', function ($tour_operator) {
                return $tour_operator->company_instagram_url;
            })

            ->addColumn('company_website_url', function ($tour_operator) {
                return $tour_operator->company_website_url;
            })
            ->addColumn('whatsapp_direct_link',function ($tour_operator){
                return $tour_operator->whatsapp_direct_link;
            })
            ->addColumn('GPS_link',function ($tour_operator){
                return $tour_operator->GPS_link;
            })

            ->addColumn('activate_company',function ($tour_operator){
                $btn='<label class="switch{{$tour_operator->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })

            ->addColumn('company_status', function ($tour_operator) {
                if($tour_operator->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Unverified</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Verified</span>';
                }
            })
            ->addColumn('blog_posted',function ($tour_operator){
                return $tour_operator->blog_posted_label;
            })

            ->addColumn('blogs_verified',function($tour_operator){
                return $tour_operator->blog_posted_verified_label;
            })
            ->addColumn('blogs_unverified',function ($tour_operator){
                return $tour_operator->blog_posted_unverified_label;
            })
            ->addColumn('bookings_made',function ($tour_operator){
                return $tour_operator->total_bookings_made_label;
            })
            ->addColumn('bookings_verified',function ($tour_operator){
                return $tour_operator->total_bookings_verified_label;
            })
            ->addColumn('bookings_unverified',function ($tour_operator){
                return $tour_operator->total_bookings_unverified_label;
            })
            ->addColumn('action', function($tour_operator) {
                return $tour_operator->button_actions;
            })
            ->rawColumns(['logo'])
            ->rawColumns(['action','status','activate_company','company_status','blog_posted','blogs_verified','blogs_unverified','bookings_made','bookings_verified','bookings_unverified','date_of_joining'])
            ->make(true);

    }
}
