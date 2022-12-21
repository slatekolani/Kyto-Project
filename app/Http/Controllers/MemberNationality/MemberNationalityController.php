<?php

namespace App\Http\Controllers\MemberNationality;

use App\Http\Controllers\Controller;
use App\Models\MemberNations\MemberNationality;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MemberNationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('MemberNationality.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('MemberNationality.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nation=new MemberNationality();
        $nation->nation_name=$request->input('nation_name');
        if($request->hasFile('nation_flag'))
        {
            $file=$request->file('nation_flag');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/nationFlags/',$filename);
            $nation->nation_flag=$filename;
        }
        $nation->save();
        return redirect()->route('MemberNationality.index')->withFlashSuccess('nation saved successfully');
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
    public function edit($member_nation_id)
    {
        $member_nation=MemberNationality::query()->where('uuid',$member_nation_id)->first();
        return view('MemberNationality.edit')->with('member_nation',$member_nation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $member_nation)
    {
        $member_nation=MemberNationality::query()->where('uuid',$member_nation)->first();
        $member_nation->nation_name=$request->input('nation_name');
        if($request->hasFile('nation_flag'))
        {
            $file=$request->file('nation_flag');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/nationFlags/',$filename);
            $member_nation->nation_flag=$filename;
        }
        $member_nation->save();
        return redirect()->route('MemberNationality.index')->withFlashSuccess('Nation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MemberNationality $member_nation)
    {
        $member_nation->delete();
        return redirect()->route('MemberNationality.index')->withFlashSuccess('Nation removed successfully');
    }

    public function activateNation(Request $request)
    {
        $member_nation=MemberNationality::find($request->id);
        $status=$request->status;
        switch($status)
        {
            case 0:
                $member_nation->status=1;
                break;
            case 1:
                $member_nation->status=0;
                break;
        }
        $member_nation->save();
    }

    public function get_member_nationality()
    {
        $member_nation=MemberNationality::query()->orderBy('nation_name')->get();
        return DataTables::of($member_nation)
            ->addIndexColumn()
            ->addColumn('nation_flag',function($member_nation)
            {
                return $member_nation->nation_flag_label;
            })
            ->addColumn('nation_name',function($member_nation)
            {
                return $member_nation->nation_name;
            })
            ->addColumn('activate_nation',function($member_nation)
            {
                $btn='<label class="switch{{$member_nation->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('nation_status',function ($member_nation)
            {
                if($member_nation->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })
            ->addColumn('action',function($member_nation)
            {
                $btn='<a href="'.route('MemberNationality.edit',$member_nation->uuid).'"><button class="btn btn-primary btn-sm">Edit</button></a>';
                $btn=$btn.'<a href="'.route('MemberNationality.delete',$member_nation->uuid).'" class="disabled"><button class="btn btn-danger btn-sm">Delete</button></a>';
                return $btn;
            })
            ->rawColumns(['action','nation_status','activate_nation'])
            ->make(true);
    }
}
