<?php

namespace App\Http\Controllers\transportService;

use App\Http\Controllers\Controller;
use App\Models\transportService\transportService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class transportServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('transportService.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transportService.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transport_service=new transportService();
        $transport_service->transport_name=$request->input('transport_name');
        $transport_service->save();
        return redirect()->route('transportService.index')->withFlashSuccess('Transport service category populated successfully');
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
    public function edit($transport_service_id)
    {
        $transport_service=transportService::query()->where('uuid',$transport_service_id)->first();
        return view('transportService.edit')
            ->with('transport_service',$transport_service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $transport_service_id)
    {
        $transport_service=transportService::query()->where('uuid',$transport_service_id)->first();
        $transport_service->transport_name=$request->input('transport_name');
        $transport_service->save();
        return redirect()->route('transportService.index')->withFlashSuccess('Transport updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(transportService $transport_service)
    {
        $transport_service->delete();
        return redirect()->route('transportService.index')->withFlashSuccess('Transport category removed successfully');
    }

    public function activateTransport(Request $request)
    {
        $transport_service=transportService::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $transport_service->status=1;
                break;
            case 1:
                $transport_service->status=0;
                break;
        }
        $transport_service->save();
    }

    public function get_transport_service()
    {
        $transport_service=transportService::query()->orderBy('transport_name')->get();
        return DataTables::of($transport_service)
            ->addIndexColumn()
            ->addColumn('transport_name',function ($transport_service)
            {
                return $transport_service->transport_name;
            })
            ->addColumn('activate_transport',function($transport_service){
                $btn='<label class="switch{{$transport_service->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('transport_status',function ($transport_service)
            {
                if ($transport_service->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })
            ->addColumn('action',function($transport_service)
            {
                $btn='<a href="'.route('transportService.edit',$transport_service->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('transportService.delete',$transport_service->uuid).'" class="btn btn-danger btn-sm disabled">Delete</a>';
                return $btn;
            })
            ->rawColumns(['transport_status','action','activate_transport'])
            ->make(true);
    }
}
