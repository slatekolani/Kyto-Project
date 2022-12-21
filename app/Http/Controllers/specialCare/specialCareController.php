<?php

namespace App\Http\Controllers\specialCare;

use App\Http\Controllers\Controller;
use App\Models\specialCare\tourOperatorSpecialCare;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class specialCareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('specialCare.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('specialCare.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $special_care=new tourOperatorSpecialCare();
        $special_care->special_care=$request->input('special_care');
        $special_care->save();
        return redirect()->route('specialCare.index')->withFlashSuccess('Special care category populated successfully');
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
    public function edit($special_care_category_id)
    {
        $special_care_category=tourOperatorSpecialCare::query()->where('uuid',$special_care_category_id)->first();
        return view('specialCare.edit')
            ->with('special_care_category',$special_care_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $special_care_category_id)
    {
        $special_care_category=tourOperatorSpecialCare::query()->where('uuid',$special_care_category_id)->first();
        $special_care_category->special_care=$request->input('special_care');
        $special_care_category->save();
        return redirect()->route('specialCare.index')->withFlashSuccess('Special care category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tourOperatorSpecialCare $special_care_category)
    {
        $special_care_category->delete();
        return redirect()->route('specialCare.index')->withFlashSuccess('Special care category removed successfully');
    }
    public function activateSpecialCare(Request $request)
    {
        $special_care_category=tourOperatorSpecialCare::find($request->id);
        $status=$request->status;
        switch($status)
        {
            case 0:
                $special_care_category->status=1;
                break;
            case 1:
                $special_care_category->status=0;
                break;
        }
        $special_care_category->save();
    }

    public function get_special_care()
    {
        $special_care_category=tourOperatorSpecialCare::query()->orderBy('special_care')->get();
        return DataTables::of($special_care_category)
            ->addIndexColumn()
            ->addColumn('special_care',function ($special_care_category)
            {
                return $special_care_category->special_care;
            })
            ->addColumn('activate_special_care',function($special_care_category)
            {
                $btn='<label class="switch{{$special_care_category->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('special_care_status',function($special_care_category)
            {
                if($special_care_category->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })
            ->addColumn('action',function ($special_care_category)
            {
                $btn='<a href="'.route('specialCare.edit',$special_care_category->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('specialCare.delete',$special_care_category->uuid).'" class="btn btn-danger btn-sm disabled">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','special_care_status','activate_special_care'])
            ->make(true);

    }
}
