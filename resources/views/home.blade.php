@extends('layouts.main', ['title' => __("label.home"), 'header' => __("label.home")])

@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

@endpush
@section('content')



            @guest
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{url('/img/Kyto/Back-images/serengeti 1.jpg')}}" class="home-photo">
                                                <div class="message_container">
                                                    <h4>Make history for Travelling to Tanzania for Tourism using the Kyto Platform. Want to know how? <a href="#see-features" class="badge badge-warning" id="see features">Navigate</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="topic">
                                                    <img src="{{ url("/img/KYTO-4.png") }}" width="200" height="200" style="margin-top: -20px" alt="{{ config("app.name") }}" />
                                                    <h3>Know Your Tour Operator-TZ</h3>
                                                </div>
                                                <hr>
                                                <h4>Available Topics</h4>
                                                <ul style="list-style: none">
                                                    <li><img src="{{url('/img/Kyto/Back-images/tick.png')}}" style="width:30px;height:30px">National Parks</li>
                                                    <li><img src="{{url('/img/Kyto/Back-images/tick.png')}}" style="width:30px;height:30px">Forest Reserves</li>
                                                    <li><img src="{{url('/img/Kyto/Back-images/tick.png')}}" style="width:30px;height:30px">Historical sites</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row" id="see-features">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="topic" style="margin-top: -30px">
                                    <h3>KYTO TANZANIA</h3>
                                    <p>Know your Tour Operator (KYTO-TZ) platform enables your travel to Tanzania for tourism much more easier and manageable.</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="content" onclick="off()">
                                                        <div id="text">
                                                            Hello Friend
                                                        </div>
                                                    </div>
                                                    <span onclick="on()" style="color:dodgerblue" class="features"> Click to see features >></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    @endguest


                <form class="search-bar" type="get" action="{{route('tourOperatorBlogs.search')}}" style="padding-top: 20px">
                    <div class="input-group">
                        <div class="form-outline">
                            <input type="search" id="form1" name="search" class="form-control" placeholder="search topic"/>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>



                <div class="row" style="padding-top: 20px">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @if(!empty($tour_operator_blogs) && $tour_operator_blogs->count())
                                        @foreach($tour_operator_blogs as $tour_operator_blog)
                                            @if($tour_operator_blog->status==1)
                                            <div class="col-md-4">
                                                <a href="{{route('tourOperatorBlogs.view',$tour_operator_blog->uuid)}}" style="text-decoration: none">
                                                    <div class="post-container">
                                                        <div class="card" style="margin-top:10px;">
                                                            <div class="card-body">
                                                                <img src="{{asset('public/BlogImages/topicImages/'.$tour_operator_blog->blog_topic_image)}}" class="blog_image">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="head">
                                                                            <h3 style="color:black;"><b>{{\App\Models\touristAttraction\touristAttraction::find($tour_operator_blog->blog_topic)->attraction_name}}</b></h3>
                                                                        </div>
                                                                        <div class="description">
                                                                            <p>{{$tour_operator_blog->topic_description}}</p>
                                                                            <div style="display: inline-flex">
                                                                                    <span>Tanzanian: <span style="color: goldenrod">{{number_format($tour_operator_blog->visit_cost_local)}} shillings </span>~
                                                                                    </span>
                                                                                <span>~ Foreigner: <span style="color: goldenrod">${{number_format($tour_operator_blog->visit_cost_foreigner)}} USD </span>
                                                                                    </span>
                                                                            </div>
                                                                            <hr>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div style="text-align:center">
                                                                                        <span style="color:black"> {{$tour_operator_blog->tourOperators->company_name}}</span>
                                                                                        @php
                                                                                            $average=$tour_operator_blog->rating_average;
                                                                                        @endphp
                                                                                        <div class="star">
                                                                                            <i class="fa fa-star {{ (($average <= 1) ? '' : 'checked') }}"></i>
                                                                                            <i class="fa fa-star {{ (($average <= 2) ? '' : 'checked') }}"></i>
                                                                                            <i class="fa fa-star {{ (($average <= 3) ? '' : 'checked') }}"></i>
                                                                                            <i class="fa fa-star {{ (($average <= 4) ? '' : 'checked') }}"></i>
                                                                                            <i class="fa fa-star {{ (($average <= 5) ? '' : 'checked') }}"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>


                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            @else

                                            @endif

                                        @endforeach
                                    @else
                                        <span>No posts yet</span>
                                    @endif

                                </div>

                            </div>
                        </div>

                    </div>
                </div>


    <script>
        function on()
        {
            document.getElementById('content').style.display="block";
        }
        function off()
        {
            document.getElementById('content').style.display="none";
        }
    </script>



@endsection

