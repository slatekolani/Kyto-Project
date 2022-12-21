<?php

namespace App\Http\Controllers\tourOperatorBlogs;

use App\Http\Controllers\Controller;
use App\Models\tourOperatorBlogs\tour_operator_blog_cost_exclusive;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class tourOperatorBlogCostExclusiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::query()->where('uuid',$tour_operator_blog_id)->first();
        return view('tourOperatorBlogs.BlogCostExclusive.index')->with('tour_operator_blog',$tour_operator_blog);
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

    public function get_cost_exclusive($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::find($tour_operator_blog_id);
        $cost_exclusive=tour_operator_blog_cost_exclusive::query()->orderBy('cost_exclusive')->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        return DataTables::of($cost_exclusive)
            ->addIndexColumn()
            ->addColumn('cost_exclusive',function ($cost_exclusive){
                return $cost_exclusive->cost_exclusive;
            })
            ->make(true);
    }
}
