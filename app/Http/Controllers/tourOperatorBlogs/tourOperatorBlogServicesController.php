<?php

namespace App\Http\Controllers\tourOperatorBlogs;

use App\Http\Controllers\Controller;
use App\Models\tourOperatorBlogs\tourOperatorBlogService;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class tourOperatorBlogServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::query()->where('uuid',$tour_operator_blog_id)->first();
        return view('tourOperatorBlogs.BlogServices.index')->with('tour_operator_blog',$tour_operator_blog);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function get_services($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::find($tour_operator_blog_id);
        $tour_operator_service=tourOperatorBlogService::query()->orderBy('service_name')->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        return DataTables::of($tour_operator_service)
        ->addIndexColumn()
            ->addColumn('service_image',function ($tour_operator_service){
                return $tour_operator_service->service_image_label;
            })
            ->addColumn('service_name',function ($tour_operator_service){
                return $tour_operator_service->service_name;
            })
            ->addColumn('service_description',function ($tour_operator_service){
                return $tour_operator_service->service_description;
            })

            ->rawColumns(['service_image'])
            ->make(true);
    }
}
