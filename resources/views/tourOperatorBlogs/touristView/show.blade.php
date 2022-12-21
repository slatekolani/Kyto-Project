@extends('layouts.main', ['title' => $tour_operator_blog->tourOperators->company_name, 'header' => $tour_operator_blog->tourOperators->company_name])

@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

@endpush
@section('content')
{{--Here is the beginning of the page--}}
    <div class="image_container">
        <img src="{{asset('public/BlogImages/topicImages/'.$tour_operator_blog->blog_topic_image)}}"
             class="imageBackground" style="height:450px;width:100%">
        <div class="text_container">
            <div class="text">
                <h2 style="color:goldenrod">{{\App\Models\touristAttraction\touristAttraction::find($tour_operator_blog->blog_topic)->attraction_name}}</h2>
                <h3>{{$tour_operator_blog->topic_description}}</h3>
                <div style="display: inline-flex">
                    <h3>Tanzanian: <span style="color: goldenrod">{{number_format($tour_operator_blog->visit_cost_local)}} shillings </span>~
                    </h3>
                    <h3>~ Foreigner: <span style="color: goldenrod">${{number_format($tour_operator_blog->visit_cost_foreigner)}} USD</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>



    <div class="content" style="padding-top: 20px">
        <!--       Large container left -->
        <div class="row">
            <div class="col-md-8">

{{--                Here is the beginning of the honey points--}}

                <div class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">

                        <div class="topic_content">
                            <div class="container-fluid">
                                <div class="topic">
                                    <legend style="text-align: center">Honey Points</legend>
                                </div>
                                @foreach($tour_operator_blog_honey_points as $tour_operator_blog_honey_point)
                                    <div class="container" style="padding-top:20px;">
                                        <div style="text-align: center">
                                            <h4>{{$tour_operator_blog_honey_point->honey_point}}</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <img src="{{asset('public/BlogImages/honeyPointsImages/'.$tour_operator_blog_honey_point->honey_point_image)}}" class="honey_point_image" alt="blog-image" style="width:100%;height:auto;border: 2px solid gainsboro">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p>{{$tour_operator_blog_honey_point->honey_point_description}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </div>
                </div>
{{--                Here is the end of the honey points --}}

{{--                Here is the beginning of the services offered--}}
                <div class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">
                        <div class="topic">
                            <legend style="text-align: center">Services Offered</legend>
                        </div>
                        <div class="container-fluid">
                            @if(!empty($tour_operator_blog_services) && $tour_operator_blog_services->count())
                                @foreach($tour_operator_blog_services as $tour_operator_blog_service)
                                    <div class="container" style="padding-top:20px;">
                                        <div style="text-align: center">
                                            <h4>{{$tour_operator_blog_service->service_name}}</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <img src="{{asset('public/BlogImages/serviceImages/'.$tour_operator_blog_service->service_image)}}" class="honey_point_image" alt="Service Image" style="width:100%;height:auto;border: 2px solid gainsboro">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p>{{$tour_operator_blog_service->service_description}}</p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <span>Services are yet to be published</span>
                            @endif
{{--                            Here is the end of the services offered--}}


{{--                            Here  the beginning of the cost break down--}}
                                <div style="padding-top: 20px">
                                <legend style="text-align: center">Trip Cost Breakdown</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div style="display: flex">
                                            <div class="container">
                                                <div class="col-md-8">
                                                    <h4 style="text-align: center">Cost Inclusive</h4>
                                                    @foreach($tour_operator_blog_cost_inclusives as $tour_operator_blog_cost_inclusive)
                                                        <ul style="list-style: none">
                                                            <li><img src="{{url('/img/Kyto/Back-images/tick.png')}}" style="width:30px;height:30px">{{$tour_operator_blog_cost_inclusive->cost_inclusive}}</li>
                                                        </ul>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="container">
                                                <div class="col-md-8">
                                                    <h4 style="text-align: center">Cost Exclusive</h4>
                                                    @foreach($tour_operator_blog_cost_exclusives as $tour_operator_blog_cost_exclusive)
                                                        <ul style="list-style: none">
                                                            <li><img src="{{url('/img/Kyto/Back-images/wrong.png')}}" style="width:30px;height:30px">{{$tour_operator_blog_cost_exclusive->cost_exclusive}}</li>
                                                        </ul>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
{{--                            Here is the end of the cost breakdown--}}

{{--                            Here is the beginning of the trip requirement--}}
                                <div style="padding-top:20px">
                                    <legend style="text-align:center">Trip Requirement</legend>
                                    @foreach($tour_operator_blog_trip_requirements as $tour_operator_blog_trip_requirement)
                                        <ul style="list-style: none">
                                            <li><img src="{{url('/img/Kyto/Back-images/check.png')}}" style="width:40px;height:40px">{{$tour_operator_blog_trip_requirement->trip_requirement}} ~~ {{$tour_operator_blog_trip_requirement->reason_for_requirement}}</li>
                                        </ul>
                                    @endforeach
                                </div>
{{--                            Here is the end of the trip requirement--}}

{{--                            Here is the beginning of the trip summary--}}
                                <div style="padding-top: 20px">
                                    <legend style="text-align: center">Trip Summary</legend>
                                    <p>{{$tour_operator_blog->trip_description}}</p>
                                </div>
{{--                            Here is the end of the trip summary--}}
                        </div>
                    </div>
                </div>
            </div>



            <!--             Start Right grid-->
            <div class="col-md-4">
                <!--first card right-->
                <div class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">
                        <div class="topic">
                            <div class="logo-container" style="border-bottom:1px solid dimgray;">
                                <img src="{{asset('public/logo_uploads/Logo/'.$tour_operator_blog->tourOperators->logo)}}"
                                     class="logo_display">
                            </div>
                            <h4>{{$tour_operator_blog->tourOperators->company_name}}</h4>

                            @php
                                $average=$tour_operator_blog->getRatingAverageAttribute();
                            @endphp
                            <div class="star">
                                <i class="fa fa-star {{ (($average <= 1) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 2) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 3) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 4) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 5) ? '' : 'checked') }}"></i>
                                <i style="color:dodgerblue">{{$average}}/5</i>
                            </div>

                            <div>
                                <span style="color:dodgerblue">{{$tour_operator_blog->tourOperators->tourOperatorRating->count()}} reviews</span>

                            </div>
                        </div>
                        <div class="button-group">
                            <button type="button" class="btn btn-primary reviews_btn" value="{{$tour_operator_blog->tourOperators->id}}">Customer Reviews</button>
                            <a href="{{route('tourOperatorProfile.index',$tour_operator_blog->tourOperators->uuid)}}">
                                More about us</a>
                        </div>
                    </div>
                </div>
                <!--                Ending first card right-->

                <!--                Second card right -->
                <div class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">
                        <h4 style="text-align: center;">Tour Features</h4>
                        <hr>
                            <legend><img src="{{url('/img/Kyto/Back-images/language.png')}}" style="width:30px;height:30px">Language Offered</legend>
                        <p style="padding-right: 30px;">{{$tour_operator_blog->tourOperators->tourOperatorProfile->language_label}}</p>
                        <legend><img src="{{url('/img/Kyto/Back-images/tourType.png')}}" style="width:30px;height:30px">Tours Types</legend>
                        <p>{{$tour_operator_blog->tour_types_label}}</p>
                        <legend><img src="{{url('/img/Kyto/Back-images/Transport.png')}}" style="width:30px;height:30px">Transport Included</legend>
                        <p>{{$tour_operator_blog->transport_offered_label}}</p>
                        <legend><img src="{{url('/img/Kyto/Back-images/special care.jpg')}}" style="width:40px;height:40px">Special Attention</legend>
                        <p>{{$tour_operator_blog->special_care_label}}</p>
                    </div>
                </div>
                <!--                Ending second card right-->

{{--                Third card right--}}
                <div class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">
                        <h4 style="text-align: center;">Payment Information</h4>
                        <hr>
                        <h4 style="font-family: sans-serif, Verdana;text-align: center">Gateways used</h4>
                        @if(!empty($tour_operator_accounts) && $tour_operator_accounts->count())
                        @foreach($tour_operator_accounts as $tour_operator_account)
                            <img src="{{url('public/PaymentGatewayImages/images/',\App\Models\paymentGateways\paymentGateways::find($tour_operator_account->payment_gateway)->payment_gateway_image)}}" class="gateway-images">
                        @endforeach
                        @else
                            <span>This tour operator didn't put their accounts public. Please <a href="mailTo:{{$tour_operator_blog->tourOperators->email_address}}"> contact </a> to get more info</span>
                        @endif
                        <h4 style="font-family: sans-serif, Verdana;text-align: center">Payment condition</h4>
                        <p style="text-align: center;">{{$tour_operator_blog->payment_condition}}</p>
                    </div>
                </div>
{{--                Ending third card right--}}
            </div>
            <!--           Ending right grid  -->

        </div>
        <!--       Ending row -->
    </div>

    <!--   Footer content -->
    <div class="content" style="padding-top: 20px">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">
                        <div class="end_contents" style="padding-top: 10px">
                            <h4 style="text-align: center">Wanna travel with us?</h4>
                            @if($tour_operator_blog->tourOperators->status==1)
                                @if(Auth::check())
                                    @if(auth()->user()->hasRole(3))
                                        <a href="{{route('touristBookings.create',$tour_operator_blog->uuid)}}"
                                           class="btn btn-primary btn-sm">Book normal</a>
                                        <a href="{{route('soloBookings.create',$tour_operator_blog->uuid)}}"
                                           class="btn btn-primary btn-sm">Book Solo</a>
                                    @else
                                        <a href="#"
                                           onclick="alert('Your account is not legible for booking. Please get a touristic account')"
                                           title="not legible, get a touristic account" class="btn btn-primary btn-sm">Book
                                            normal</a>
                                        <a href="#"
                                           onclick="alert('Your account is not legible for booking. Please get a touristic account')"
                                           title="not legible, get a touristic account" class="btn btn-primary btn-sm">Book Solo
                                            here</a>

                                    @endif
                                @else
                                    <a href="{{route('touristBookings.create',$tour_operator_blog->uuid)}}"
                                       onclick="alert('Please get a touristic account to book or log in to your account')"
                                       title="not legible, get a touristic account" class="btn btn-primary btn-sm">Book
                                        normal</a>
                                    <a href="{{route('touristBookings.soloBookings.create',$tour_operator_blog->uuid)}}"
                                       onclick="alert('Please get a touristic account to book or log in to your account')"
                                       title="not legible, get a touristic account" class="btn btn-primary btn-sm">Book
                                        Solo</a>
                                @endif
                            @else
                                <a href="#" onclick="alert('Sorry,booking to this tour operator is closed for a moment. Please wait...')"><button class="btn btn-primary btn-sm">Book us</button></a>
                            @endif

                        </div>

                        <div style="padding-top:10px">
                            <h4 style="text-align: center">We are public also. Check us here</h4>

                                <div class="end_contents">
                                    <a href="{{$tour_operator_blog->tourOperators->company_instagram_url}}" target="_blank"><img src="{{url('/img/Kyto/Back-images/Instagram icon.png')}}" class="social-images" title="Instagram"></a>
                                    <a href="{{$tour_operator_blog->tourOperators->company_website_url}}" target="_blank"><img src="{{url('/img/Kyto/Back-images/website.png')}}" class="social-images" title="website"></a>
                                    <a href="{{$tour_operator_blog->trip_advisor_link}}" target="_blank"><img src="{{url('/img/Kyto/Back-images/Trip Advisor Icon.png')}}" class="social-images" title="Trip Advisor"></a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End footer content-->

    {{--                Modal content for reviews--}}
    <div class="container">
        <!-- Trigger the modal with a button -->

        <!-- Modal -->
        <div class="modal fade" id="myModal{{$tour_operator_blog->tourOperators->id}}" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row" style="display: flex">
                            <div class="col-md-2">
                                <img src="{{asset('public/logo_uploads/Logo/'.$tour_operator_blog->tourOperators->logo)}}"
                                     style="height:50px;width:50px;border-radius: 50%">
                            </div>
                            <div class="col-md-10" style="top:-10px">
                                <h4 style="padding-left: 5px">{{$tour_operator_blog->tourOperators->company_name}}</h4>

                                <div class="star">
                                    <i class="fa fa-star {{ (($average <= 1) ? '' : 'checked') }}"></i>
                                    <i class="fa fa-star {{ (($average <= 2) ? '' : 'checked') }}"></i>
                                    <i class="fa fa-star {{ (($average <= 3) ? '' : 'checked') }}"></i>
                                    <i class="fa fa-star {{ (($average <= 4) ? '' : 'checked') }}"></i>
                                    <i class="fa fa-star {{ (($average <= 5) ? '' : 'checked') }}"></i>
                                    <i style="color:dodgerblue">{{$average}}/5
                                        - {{$tour_operator_blog->tourOperators->tourOperatorRating->count()}}
                                        reviews</i>

                            </div>

                        </div>


                    </div>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>


                    <div class="modal-body">
                        @if(!empty($tour_operator_ratings) && $tour_operator_ratings->count())
                            @foreach($tour_operator_ratings as $tour_operator_rating)
                                <div class="card" style="border-bottom: 1px solid gainsboro ">
                                    <div class="card-body">
                                        <div class="user">
                                            @if($tour_operator_rating->gender=='Female')
                                                <img src="{{url('/img/Kyto/Back-images/female-306407__340.png')}}"
                                                     style="width:50px;height:45px;border-radius:50%;color: dodgerblue">
                                            @else
                                                <img src="{{url('/img/Kyto/Back-images/male-306408__340.png')}}"
                                                     style="width:50px;height:45px;border-radius:50%;color: dodgerblue">
                                            @endif
                                            <h4 style="color: black">{{$tour_operator_rating->user->username}}</h4>
                                        </div>
                                        <div class="comment-block">
                                            <p>{{$tour_operator_rating->comment}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span>No reviews contributed or yet to be verified</span>
                        @endif

                    </div>
                    <div class="modal-footer">
                        <span>"Verified Tanzanian Tour Operator"</span>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
    {{--                Ending content for reviews--}}


    @push('after-scripts')
        <script>
            $(function () {

                $('.reviews_btn').on('click', function (e) {
                    e.preventDefault();
                    var id = $(this).val();
                    $('#operator_inputs').empty()

                    $('#operator_inputs').append(
                        $('<input>', {
                            type: 'text',
                            value: id,
                            name: 'tour_operators_id',
                            hidden: true
                        }))

                    $('#myModal' + id).modal("show")
                })
            })

        </script>


    @endpush



@endsection
