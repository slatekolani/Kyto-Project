<?php

namespace App\Http\Controllers\touristAttraction;

use App\Http\Controllers\Controller;
use App\Models\touristAttraction\touristAttraction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class touristAttractionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('touristAttraction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('touristAttraction.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $tourist_attraction=new touristAttraction();
       $tourist_attraction->attraction_name=$request->input('attraction_name');
       $tourist_attraction->description=$request->input('description');
       $tourist_attraction->save();
       return redirect()->route('touristAttraction.index')->withFlashSuccess('Attraction populated successfully');
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
    public function edit($tourist_attraction_id)
    {
        $tourist_attraction=touristAttraction::query()->where('uuid',$tourist_attraction_id)->first();
        return view('touristAttraction.edit')->with('tourist_attraction',$tourist_attraction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tourist_attraction_id)
    {
        $tourist_attraction=touristAttraction::query()->where('uuid',$tourist_attraction_id)->first();
        $tourist_attraction->attraction_name=$request->input('attraction_name');
        $tourist_attraction->description=$request->input('description');
        $tourist_attraction->save();
        return redirect()->route('touristAttraction.index')->withFlashSuccess('Touristic Attraction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(touristAttraction $tourist_attraction)
    {
        $tourist_attraction->delete();
        return redirect()->route('touristAttraction.index')->withFlashSuccess('Tourist attraction removed successfully');
    }

    public function activateTouristAttraction(Request $request)
    {
        $tourist_attraction=touristAttraction::find($request->id);
        $status=$request->status;
        switch($status)
        {
            case 0:
                $tourist_attraction->status=1;
                break;
            case 1:
                $tourist_attraction->status=0;
                break;
        }
        $tourist_attraction->save();
    }
    public function get_tourist_attractions()
    {
        $tourist_attraction=touristAttraction::query()->orderBy('attraction_name')->get();
        return DataTables::of($tourist_attraction)
            ->addIndexColumn()
            ->addColumn('attraction_name',function ($tourist_attraction)
            {
                return $tourist_attraction->attraction_name;
            })
            ->addColumn('description',function ($tourist_attraction)
            {
                return $tourist_attraction->description;
            })
            ->addColumn('activate_tourist_attraction',function($tourist_attraction)
            {
                $btn='<label class="switch{{$tourist_attraction->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('tourist_attraction_status',function($tourist_attraction)
            {
                if($tourist_attraction->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })
            ->addColumn('action',function($tourist_attraction)
            {
                $btn='<a href="'.route('touristAttraction.edit',$tourist_attraction->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('touristAttraction.delete',$tourist_attraction->uuid).'" class="btn btn-danger btn-sm disabled">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','status','activate_tourist_attraction','tourist_attraction_status'])
            ->make(true);
    }
}
