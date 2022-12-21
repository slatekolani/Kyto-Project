<?php

namespace App\Http\Controllers\tourOperatorBlogs;

use App\Http\Controllers\Controller;
use App\Models\specialCare\tourOperatorSpecialCare;
use App\Models\touristAttraction\touristAttraction;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperatorBlogs\tour_operator_blog_cost_exclusive;
use App\Models\tourOperatorBlogs\tour_operator_blog_cost_inclusive;
use App\Models\tourOperatorBlogs\tour_operator_blog_trip_requirement;
use App\Models\tourOperatorBlogs\tourOperatorBlogHoneyPoints;
use App\Models\tourOperatorBlogs\tourOperatorBlogService;
use App\Models\tourOperatorBlogs\tourOperatorsBlogs;
use App\Models\tourOperatorRating\tourOperatorRating;
use App\Models\tourOperators\tourOperators;
use App\Models\tourType\tourTypes;
use App\Models\transportService\transportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class tourOperatorBlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        return view('tourOperatorBlogs.index')->with('tour_operator',$tour_operator);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        $tourist_attraction=touristAttraction::where('status','=',1)->pluck('attraction_name','id');
        $transport_service=transportService::where('status','=',1)->pluck('transport_name','id');
        $special_care=tourOperatorSpecialCare::where('status','=',1)->pluck('special_care','id');
        $tour_type=tourTypes::where('status','=',1)->pluck('tour_type_name','id');
        return view('tourOperatorBlogs.create')
            ->with('tour_type',$tour_type)
            ->with('tour_operator',$tour_operator)
            ->with('special_care',$special_care)
            ->with('transport_service',$transport_service)
            ->with('tourist_attraction',$tourist_attraction);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->all();
        $tour_operator_blogs = new tourOperatorsBlogs();
        $tour_operator_blogs->blog_topic = $request->input('blog_topic');
        $tour_operator_blogs->visit_cost_local = $request->input('visit_cost_local');
        $tour_operator_blogs->visit_cost_foreigner = $request->input('visit_cost_foreigner');
        if ($tour_operator_blogs->guarantee_percentage=$request->input('guarantee_percentage')>100)
        {
            return redirect()->route('home')->withFlashWarning('We noticed a suspicious input, please populate the credentials accurately again accurately. Hint: Percentage should be below 100%');
        }
        elseif ($tour_operator_blogs->guarantee_percentage=$request->input('guarantee_percentage')<1)
        {
            return redirect()->route('home')->withFlashWarning('We noticed a suspicious input, please populate the credentials accurately again accurately. Hint: Percentage should be above 1%');
        }
        else
        {
            $tour_operator_blogs->guarantee_percentage=$request->input('guarantee_percentage');
            $tour_operator_blogs->payment_condition=$request->input('payment_condition');
            $tour_operator_blogs->trip_description = $request->input('trip_description');
            $tour_operator_blogs->payment_range = $request->input('payment_range');
            $tour_operator_blogs->tour_operators_id = $request->input('tour_operators_id');
            $tour_operator_blogs->maximum_travellers = $request->input('maximum_travellers');
            $tour_operator_blogs->minimum_travellers = $request->input('minimum_travellers');
            $tour_operator_blogs->trip_advisor_link = $request->input('trip_advisor_link');
            $tour_operator_blogs->users_id = auth()->user()->id;
            if ($request->hasFile('blog_topic_image')) {
                $file = $request->file('blog_topic_image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('public/BlogImages/topicImages/', $filename);
                $tour_operator_blogs->blog_topic_image = $filename;
            }
            $tour_operator_blogs->save();
//            Save pivot information
            $tour_operator_blogs->getSpecialCare($input,$tour_operator_blogs);
            $tour_operator_blogs->getTransportOffered($input,$tour_operator_blogs);
            $tour_operator_blogs->gettourTypes($input,$tour_operator_blogs);
            //save services offered in a specific topic area. Multiple inputs
            $this->savetourOperatorBlogHoneyPoints($request, $tour_operator_blogs);
            $this->savetourOperatorBlogService($request, $tour_operator_blogs);
            $this->savetourOperatorBlogCostInclusive($request, $tour_operator_blogs);
            $this->savetourOperatorBlogsCostExclusive($request, $tour_operator_blogs);
            $this->savetourOperatorBlogsTripRequirements($request, $tour_operator_blogs);
            return redirect()->route('home')->withFlashSuccess('Blog uploaded successful');
        }
    }

    public function savetourOperatorBlogService($request,$tour_operator_blogs)
    {
     $input=$request->all();
     foreach ($input as $key=>$value)
     {
         if(str_contains($key,'service_name')!==false)
         {
            $key_id=substr($key,12) ;

            $tour_operator_blogs_service_array=[
                'service_name'=>$input['service_name'.$key_id],
                'service_description'=>$input['service_description'.$key_id],
                'service_image'=>$input['service_image'.$key_id],
                'tour_operators_blogs_id'=>$tour_operator_blogs->id,
                'tour_operators_id'=>$tour_operator_blogs->tourOperators->id,
                'tour_operator_profiles_id'=>$tour_operator_blogs->tourOperators->tourOperatorProfile->id
            ];

            //saving
             $tour_operator_blogs_service=new tourOperatorBlogService();
             $tour_operator_blogs_service->service_name=$tour_operator_blogs_service_array['service_name'];
             $tour_operator_blogs_service->service_description=$tour_operator_blogs_service_array['service_description'];
             $tour_operator_blogs_service->tour_operators_blogs_id=$tour_operator_blogs_service_array['tour_operators_blogs_id'];
             $tour_operator_blogs_service->tour_operators_id=$tour_operator_blogs_service_array['tour_operators_id'];
             $tour_operator_blogs_service->tour_operator_profiles_id=$tour_operator_blogs_service_array['tour_operator_profiles_id'];

             $file=$request->file('service_image'.$key_id);
             $extension = $file->getClientOriginalExtension();
             $filename = time() . '.' . $extension;
             $file->move('public/BlogImages/serviceImages/',$filename);
             $tour_operator_blogs_service->service_image=$filename;

             $tour_operator_blogs_service->save();

         }
     }
    }

    public function savetourOperatorBlogHoneyPoints($request ,$tour_operator_blogs)
    {
        $input=$request->all();
        foreach ($input as $key=>$value)
        {
            if(str_contains($key,'honey_point_description')!==false){
                $key_id=substr($key,23);
                $tour_operator_blog_honey_points_array=[
                    'honey_point'=>$input['honey_point'.$key_id],
                    'honey_point_description'=>$input['honey_point_description'.$key_id],
                    'honey_point_image'=>$input['honey_point_image'.$key_id],
                    'tour_operators_blogs_id'=>$tour_operator_blogs->id,
                    'tour_operators_id'=>$tour_operator_blogs->tourOperators->id,
                    'tour_operator_profiles_id'=>$tour_operator_blogs->tourOperators->tourOperatorProfile->id
                ];
                //saving
                $tour_operator_blog_honey_points=new tourOperatorBlogHoneyPoints();
                $tour_operator_blog_honey_points->honey_point=$tour_operator_blog_honey_points_array['honey_point'];
                $tour_operator_blog_honey_points->honey_point_description=$tour_operator_blog_honey_points_array['honey_point_description'];
                $tour_operator_blog_honey_points->tour_operators_blogs_id=$tour_operator_blog_honey_points_array['tour_operators_blogs_id'];
                $tour_operator_blog_honey_points->tour_operators_id=$tour_operator_blog_honey_points_array['tour_operators_id'];
                $tour_operator_blog_honey_points->tour_operator_profiles_id=$tour_operator_blog_honey_points_array['tour_operator_profiles_id'];

                $file=$request->file('honey_point_image'.$key_id);
                $extension=$file->getClientOriginalExtension();
                $filename=time().'.'.$extension;
                $file->move('public/BlogImages/honeyPointsImages/',$filename);
                $tour_operator_blog_honey_points->honey_point_image=$filename;

                $tour_operator_blog_honey_points->save();
            }
        }
    }

    public function savetourOperatorBlogCostInclusive($request,$tour_operator_blogs)
    {
      $input=$request->all();
      foreach($input as $key => $value)
      {
          if(str_contains($key,'cost_inclusive')!==false)
          {
              $key_id=substr($key,14);
              $tour_operator_blogs_cost_inclusive_array=[
                  'cost_inclusive'=>$input['cost_inclusive'.$key_id],
                  'tour_operators_id'=>$tour_operator_blogs->tourOperators->id,
                  'tour_operators_blogs_id'=>$tour_operator_blogs->id,
                  'tour_operator_profiles_id'=>$tour_operator_blogs->tourOperators->tourOperatorProfile->id

              ];
              $tour_operator_blogs_cost_inclusive=new tour_operator_blog_cost_inclusive();
              $tour_operator_blogs_cost_inclusive->cost_inclusive=$tour_operator_blogs_cost_inclusive_array['cost_inclusive'];
              $tour_operator_blogs_cost_inclusive->tour_operators_id=$tour_operator_blogs_cost_inclusive_array['tour_operators_id'];
              $tour_operator_blogs_cost_inclusive->tour_operators_blogs_id=$tour_operator_blogs_cost_inclusive_array['tour_operators_blogs_id'];
              $tour_operator_blogs_cost_inclusive->tour_operator_profiles_id=$tour_operator_blogs_cost_inclusive_array['tour_operator_profiles_id'];
              $tour_operator_blogs_cost_inclusive->save();
          }
      }
    }

    public function savetourOperatorBlogsCostExclusive($request,$tour_operator_blogs)
    {
        $input=$request->all();
        foreach ($input as $key =>$value)
        {
            if(str_contains($key,'cost_exclusive')!==false)
            {
                $key_id=substr($key,14);
                $tour_operator_blogs_cost_exclusive_array=[
                    'cost_exclusive'=>$input['cost_exclusive'.$key_id],
                    'tour_operators_id'=>$tour_operator_blogs->tourOperators->id,
                    'tour_operators_blogs_id'=>$tour_operator_blogs->id,
                    'tour_operator_profiles_id'=>$tour_operator_blogs->tourOperators->tourOperatorProfile->id
                ];
                $tour_operator_blogs_cost_exclusive=new tour_operator_blog_cost_exclusive();
                $tour_operator_blogs_cost_exclusive->cost_exclusive=$tour_operator_blogs_cost_exclusive_array['cost_exclusive'];
                $tour_operator_blogs_cost_exclusive->tour_operators_id=$tour_operator_blogs_cost_exclusive_array['tour_operators_id'];
                $tour_operator_blogs_cost_exclusive->tour_operators_blogs_id=$tour_operator_blogs_cost_exclusive_array['tour_operators_blogs_id'];
                $tour_operator_blogs_cost_exclusive->tour_operator_profiles_id=$tour_operator_blogs_cost_exclusive_array['tour_operator_profiles_id'];
                $tour_operator_blogs_cost_exclusive->save();
            }
        }
    }

    public function savetourOperatorBlogsTripRequirements($request,$tour_operator_blogs)
    {
        $input=$request->all();
        foreach($input as $key =>$value)
        {
            if(str_contains($key,'trip_requirement')!==false)
            {
                $key_id=substr($key,16);
                $tour_operator_blogs_trip_requirement_array=[
                    'trip_requirement'=>$input['trip_requirement'.$key_id],
                    'reason_for_requirement'=>$input['reason_for_requirement'.$key_id],
                    'tour_operators_id'=>$tour_operator_blogs->tourOperators->id,
                    'tour_operators_blogs_id'=>$tour_operator_blogs->id,
                    'tour_operator_profiles_id'=>$tour_operator_blogs->tourOperators->tourOperatorProfile->id
                ];
                $tour_operator_blogs_trip_requirement=new tour_operator_blog_trip_requirement();
                $tour_operator_blogs_trip_requirement->trip_requirement=$tour_operator_blogs_trip_requirement_array['trip_requirement'];
                $tour_operator_blogs_trip_requirement->reason_for_requirement=$tour_operator_blogs_trip_requirement_array['reason_for_requirement'];
                $tour_operator_blogs_trip_requirement->tour_operators_id=$tour_operator_blogs_trip_requirement_array['tour_operators_id'];
                $tour_operator_blogs_trip_requirement->tour_operators_blogs_id=$tour_operator_blogs_trip_requirement_array['tour_operators_blogs_id'];
                $tour_operator_blogs_trip_requirement->tour_operator_profiles_id=$tour_operator_blogs_trip_requirement_array['tour_operator_profiles_id'];
                $tour_operator_blogs_trip_requirement->save();
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::query()->where('uuid',$tour_operator_blog_id)->first();
        $tour_operator_blog_honey_points=tourOperatorBlogHoneyPoints::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_blog_services=tourOperatorBlogService::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_ratings=tourOperatorRating::query()->where('tour_operators_id',$tour_operator_blog->tourOperators->id)->where('status','=',1)->get();
        $tour_operator_blog_cost_inclusives=tour_operator_blog_cost_inclusive::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_blog_cost_exclusives=tour_operator_blog_cost_exclusive::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_blog_trip_requirements=tour_operator_blog_trip_requirement::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_accounts=tourOperatorAccounts::query()->where('tour_operators_id',$tour_operator_blog->tourOperators->tourOperatorProfile->id)->get();
        return view('tourOperatorBlogs.touristView.show')
            ->with('tour_operator_accounts',$tour_operator_accounts)
            ->with('tour_operator_blog_trip_requirements',$tour_operator_blog_trip_requirements)
            ->with('tour_operator_ratings',$tour_operator_ratings)
            ->with('tour_operator_blog_cost_inclusives',$tour_operator_blog_cost_inclusives)
            ->with('tour_operator_blog_cost_exclusives',$tour_operator_blog_cost_exclusives)
            ->with('tour_operator_blog',$tour_operator_blog)
            ->with('tour_operator_blog_services',$tour_operator_blog_services)
            ->with('tour_operator_blog_honey_points',$tour_operator_blog_honey_points);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tour_operator_blog_id)
    {
        $tour_operator_blog=tourOperatorsBlogs::query()->where('uuid',$tour_operator_blog_id)->first();
        $tourist_attraction=touristAttraction::all()->pluck('attraction_name','id');
        $tour_type=tourTypes::all()->pluck('tour_type_name','id');
        $tour_type_ids=DB::table('tour_type_tour_operator_blog')->where('tour_operator_blog_id',$tour_operator_blog->id)->pluck('tour_type_id');
        $special_care=tourOperatorSpecialCare::all()->pluck('special_care');
        $special_care_ids=DB::table('tour_operator_profile_tour_operator_special_care')->where('tour_operator_profile_id',$tour_operator_blog->id)->pluck('tour_operator_special_care_id');
        $transport_service=transportService::all()->pluck('transport_name');
        $transport_service_ids=DB::table('blog_transport_service')->where('blog_id',$tour_operator_blog->id)->pluck('transport_service_id');
        $tour_operator_blog_services=tourOperatorBlogService::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_blog_honey_points=tourOperatorBlogHoneyPoints::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_trip_requirements=tour_operator_blog_trip_requirement::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_blog_cost_inclusives=tour_operator_blog_cost_inclusive::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        $tour_operator_blog_cost_exclusives=tour_operator_blog_cost_exclusive::query()->where('tour_operators_blogs_id',$tour_operator_blog->id)->get();
        return view('tourOperatorBlogs.edit')
            ->with('tour_operator_blog_cost_exclusives',$tour_operator_blog_cost_exclusives)
            ->with('tour_operator_blog_cost_inclusives',$tour_operator_blog_cost_inclusives)
            ->with('tour_operator_trip_requirements',$tour_operator_trip_requirements)
            ->with('tour_operator_blog_services',$tour_operator_blog_services)
            ->with('tour_operator_blog_honey_points',$tour_operator_blog_honey_points)
            ->with('tourist_attraction',$tourist_attraction)
            ->with('transport_service',$transport_service)
            ->with('transport_service_ids',$transport_service_ids)
            ->with('special_care',$special_care)
            ->with('special_care_ids',$special_care_ids)
            ->with('tour_type',$tour_type)
            ->with('tour_type_ids',$tour_type_ids)
            ->with('tour_operator_blog',$tour_operator_blog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tour_operator_blogs_id)
    {
        $input=$request->all();
        $tour_operator_blogs=tourOperatorsBlogs::query()->where('uuid',$tour_operator_blogs_id)->first();
        $tour_operator_blogs->blog_topic = $request->input('blog_topic');
        $tour_operator_blogs->visit_cost_local = $request->input('visit_cost_local');
        $tour_operator_blogs->visit_cost_foreigner = $request->input('visit_cost_foreigner');
        if ($tour_operator_blogs->guarantee_percentage=$request->input('guarantee_percentage')>100)
        {
            return redirect()->route('home')->withFlashWarning('We noticed a suspicious input, please populate the credentials accurately again accurately. Hint: Percentage should be below 100%');
        }
        elseif ($tour_operator_blogs->guarantee_percentage=$request->input('guarantee_percentage')<1)
        {
            return redirect()->route('home')->withFlashWarning('We noticed a suspicious input, please populate the credentials accurately again accurately. Hint: Percentage should be above 1%');
        }
        else {
            $tour_operator_blogs->guarantee_percentage = $request->input('guarantee_percentage');
            $tour_operator_blogs->payment_condition = $request->input('payment_condition');
            $tour_operator_blogs->trip_description = $request->input('trip_description');
            $tour_operator_blogs->payment_range = $request->input('payment_range');
            $tour_operator_blogs->tour_operators_id = $request->input('tour_operators_id');
            $tour_operator_blogs->maximum_travellers = $request->input('maximum_travellers');
            $tour_operator_blogs->minimum_travellers = $request->input('minimum_travellers');
            $tour_operator_blogs->trip_advisor_link = $request->input('trip_advisor_link');
            $tour_operator_blogs->tour_operators_id = $request->input('tour_operators_id');
            $tour_operator_blogs->users_id = auth()->user()->id;
            if ($request->hasFile('blog_topic_image')) {
                $file = $request->file('blog_topic_image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('public/BlogImages/topicImages/', $filename);
                $tour_operator_blogs->blog_topic_image = $filename;
            }
            $tour_operator_blogs->save();
            //            Save pivot information
            $tour_operator_blogs->getSpecialCare($input,$tour_operator_blogs);
            $tour_operator_blogs->getTransportOffered($input,$tour_operator_blogs);
            $tour_operator_blogs->gettourTypes($input,$tour_operator_blogs);
            //save services offered in a specific topic area. Multiple inputs
            $this->savetourOperatorBlogHoneyPoints($request, $tour_operator_blogs);
            $this->savetourOperatorBlogService($request, $tour_operator_blogs);
            $this->savetourOperatorBlogCostInclusive($request, $tour_operator_blogs);
            $this->savetourOperatorBlogsCostExclusive($request, $tour_operator_blogs);
            $this->savetourOperatorBlogsTripRequirements($request, $tour_operator_blogs);
            return redirect()->route('tourOperatorBlogs.index',$tour_operator_blogs->tourOperators->uuid)->withFlashSuccess('Blog Updated successful');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tourOperatorsBlogs $tour_operator_blog)
    {
        $tour_operator_blog->delete();
        return redirect()->route('tourOperatorBlogs.index',$tour_operator_blog->tourOperators->uuid)->withFlashSuccess('Blog removed successfully');
    }

    public function getAllBlogsForSearch()
    {
        $search=DB::table('tour_operators_blogs')
            ->select(
            [
                'tour_operators_blogs.blog_topic as blog_topic',
                'tour_operators_blogs.topic_description as topic_description',
                'tour_operators_blogs.visit_cost_local as visit_cost_local',
                'tour_operators_blogs.visit_cost_foreigner as visit_cost_foreigner',
                'attraction.id as attraction_id',
                'attraction.attraction_name as attraction_name',
                'tour_operators_blogs.status as status',
                'tour_operators_blogs.uuid as uuid',
                'tour_operators_blogs.blog_topic_image',
                'tour_operators_blogs.guarantee_percentage',
                'operator.company_name as company_name',
                'ratings.id as rating_average'
            ]
            )
            ->leftJoin('tourist_attractions as attraction','attraction.id','=','tour_operators_blogs.blog_topic')
            ->leftJoin('tour_operators as operator','operator.id','=','tour_operators_blogs.tour_operators_id')
            ->leftJoin('tour_operator_ratings as ratings','ratings.id','=','tour_operators_blogs.tour_operators_id');
        return $search;
    }


    public function search()
    {
        $search_blog=request()->all();
        $tour_operator_blogs=$this->getAllBlogsForSearch()->where('attraction.attraction_name','LIKE','%'.$search_blog['search'].'%')
            ->orWhere('tour_operators_blogs.topic_description','LIKE','%'.$search_blog['search'].'%')
            ->orWhere('operator.company_name','LIKE','%'.$search_blog['search'].'%')
            ->get();
        return view('tourOperatorBlogs.search_results',compact('tour_operator_blogs'));
    }

    public function enableBlog(Request $request)
    {
        $tour_operator_blog=tourOperatorsBlogs::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $tour_operator_blog->status=1;
                break;
            case 1:
                $tour_operator_blog->status=0;
                break;
        }
        $tour_operator_blog->save();
    }

    public function get_tour_operator_blogs($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $tour_operator_blog=tourOperatorsBlogs::query()->orderBy('blog_topic')->where('tour_operators_id',$tour_operator->id)->get();
        return DataTables::of($tour_operator_blog)
            ->addIndexColumn()
            ->addColumn('blog_topic_image',function ($tour_operator_blog){
                return $tour_operator_blog->blog_topic_image_label;
            })
            ->addColumn('blog_topic',function ($tour_operator_blog){
                return touristAttraction::find($tour_operator_blog->blog_topic)->attraction_name;
            })
            ->addColumn('topic_description',function ($tour_operator_blog){
                return $tour_operator_blog->topic_description;
            })
            ->addColumn('visit_cost_local',function ($tour_operator_blog){
                return $tour_operator_blog->visit_cost_local;
            })
            ->addColumn('visit_cost_foreigner',function($tour_operator_blog){
                return $tour_operator_blog->visit_cost_foreigner;
            })
            ->addColumn('guarantee_percentage',function($tour_operator_blog){
                return $tour_operator_blog->guarantee_percentage;
            })
            ->addColumn('maximum_travellers',function ($tour_operator_blog){
                return $tour_operator_blog->maximum_travellers;
            })
            ->addColumn('minimum_travellers',function ($tour_operator_blog){
                return $tour_operator_blog->minimum_travellers;
            })
            ->addColumn('payment_condition',function($tour_operator_blog){
                return $tour_operator_blog->payment_condition;
            })
            ->addColumn('trip_description',function($tour_operator_blog){
                return $tour_operator_blog->trip_description;
            })
            ->addColumn('trip_advisor_link',function($tour_operator_blog){
                return $tour_operator_blog->trip_advisor_link;
            })
            ->addColumn('tour_type_name',function ($tour_operator_blog){
                return $tour_operator_blog->tour_types_label;
            })
            ->addColumn('transport_offered',function($tour_operator_blog){
                return $tour_operator_blog->transport_offered_label;
            })
            ->addColumn('special_care',function($tour_operator_blog){
                return $tour_operator_blog->special_care_label;
            })
            ->addColumn('enable_blog',function($tour_operator_blog){
                $btn='<label class="switch{{$tour_operator_blog->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })

            ->addColumn('blog_status',function($tour_operator_blog){
                if($tour_operator_blog->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Disabled</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Enabled</span>';
                }
            })
            ->addColumn('action',function($tour_operator_blog){
                return $tour_operator_blog->button_actions;
            })
            ->rawColumns(['action','status','blog_topic_image','enable_blog','blog_status'])
            ->make(true);
    }
}
