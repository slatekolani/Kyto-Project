<?php

namespace App\Http\Controllers\tourOperatorBlogs;

use App\Http\Controllers\Controller;
use App\Models\tourOperatorBlogs\tourOperatorBlogHoneyPoints;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperators\tourOperators;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use function foo\func;

class tourOperatorBlogHoneyPointsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::query()->where('uuid',$tour_operator_blog_id)->first();
        return view('tourOperatorBlogs.BlogHoneyPoints.index')->with('tour_operator_blog',$tour_operator_blog);
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

    public function get_honey_points($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::find($tour_operator_blog_id);
        $blog_honey_point=tourOperatorBlogHoneyPoints::query()->orderBy('honey_point')->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        return DataTables::of($blog_honey_point)
            ->addIndexColumn()
            ->addColumn('honey_point_image',function ($blog_honey_point){
                return $blog_honey_point->honey_point_image_label;
            })
            ->addColumn('honey_point',function($blog_honey_point){
                return $blog_honey_point->honey_point;
            })
            ->addColumn('honey_point_description',function ($blog_honey_point){
                return $blog_honey_point->honey_point_description;
            })
            ->rawColumns(['honey_point_image'])
            ->make(true);

    }
}
