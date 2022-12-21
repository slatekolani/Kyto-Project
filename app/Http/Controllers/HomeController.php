<?php

namespace App\Http\Controllers;

use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Repositories\Information\ForumRepository;
use App\Repositories\Information\NewsRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(tourOperatorsBlogs $tour_operator_blog_id)
    {
        $tour_operator_blogs=tourOperatorsBlogs::all()->where('tour_operators_blogs_id',$tour_operator_blog_id->id);
        return view('home')->with('tour_operator_blogs',$tour_operator_blogs);
    }
}
