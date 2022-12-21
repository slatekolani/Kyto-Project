<?php

namespace App\Http\Controllers\tourType;

use App\Http\Controllers\Controller;
use App\Models\tourType\tourTypes;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class tourTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tourType.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tourType.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tour_type=new tourTypes();
        $tour_type->tour_type_name=$request->input('tour_type_name');
        $tour_type->save();
        return redirect()->route('tourType.index')->withFlashSuccess('Tour Type Category populated Successfully');
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
    public function edit($tour_type_id)
    {
        $tour_type=tourTypes::query()->where('uuid',$tour_type_id)->first();
        return view('tourType.edit')->with('tour_type',$tour_type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tour_type_id)
    {
        $tour_type=tourTypes::query()->where('uuid',$tour_type_id)->first();
        $tour_type->tour_type_name=$request->input('tour_type_name');
        $tour_type->save();
        return redirect()->route('tourType.index')->withFlashSuccess('Tour type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tourTypes $tour_type)
    {
        $tour_type->delete();
        return redirect()->route('tourType.index')->withFlashSuccess('Tour type removed successfully');
    }

    public function activateTourType(Request $request)
    {
        $tour_type=tourTypes::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $tour_type->status=1;
                break;
            case 1:
                $tour_type->status=0;
                break;
        }
        $tour_type->save();
    }

    public function get_tour_type()
    {
        $tour_type=tourTypes::query()->orderBy('tour_type_name')->get();
        return DataTables::of($tour_type)
            ->addIndexColumn()
            ->addColumn('tour_type_name',function ($tour_type)
            {
                return $tour_type->tour_type_name;
            })
            ->addColumn('activate_tour_type',function($tour_type){
                $btn='<label class="switch{{$tour_type->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('tour_type_status',function($tour_type)
            {
                if ($tour_type->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })
            ->addColumn('action',function($tour_type)
            {
                $btn='<a href="'.route('tourType.edit',$tour_type->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('tourType.delete',$tour_type->uuid).'" class="btn btn-danger btn-sm disabled">Delete</a>';
                return $btn;
            })
            ->rawColumns(['tour_type_status','action','activate_tour_type'])
            ->make(true);
    }
}
