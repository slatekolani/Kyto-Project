@extends('layouts.main', ['title' => __('Tour Operator Profile'), 'header' => __('Tour Operator Profile')])

@include('includes.datatable_assets')

@section('content')
{{--Mother Row--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
{{--                 First Child Row with the image and the company little details--}}
                    <div class="row">
{{--                        left container--}}
                        <div class="col-md-8">
                            <div class="card" style="border:2px solid gainsboro">
                                <div class="card-body">
                                        <img src="{{asset('public/TeamImage/Images/'.$tour_operator->tourOperatorProfile->company_team_image)}}" class="team-photo">
                                </div>
                            </div>
                        </div>
{{--                        End of left container--}}
{{--                        Beginning of the right container--}}
                        <div class="col-md-4">
                            <div class="card" style="border: 2px solid gainsboro">
                                <div class="card-body">
                                    <div class="topic">
                                        <div class="logo-container">
                                            <img src="{{asset('public/logo_uploads/Logo/'.$tour_operator->logo)}}"
                                                 class="logo_display">
                                        </div>
                                        <h4>{{$tour_operator->company_name}}</h4>


                                    </div>
                                    <hr>
                                    <div style="text-align:left">
                                        <h4 style="font-size: 14px">Company office: <img src="{{asset('public/nationFlags/'.\App\Models\MemberNations\MemberNationality::find($tour_operator->company_nation)->nation_flag)}}" style="width:30px;height:30px"> {{\App\Models\MemberNations\MemberNationality::find($tour_operator->company_nation)->nation_name}}</h4>
                                        <h4 style="font-size: 14px">Experience: {{$tour_operator->tourOperatorProfile->company_experience}}</h4>
                                        <h4 style="font-size: 14px">Language Used: {{$tour_operator->tourOperatorProfile->language_label}} </h4>
                                        <h4 style="font-size: 14px">Special Groups: {{$tour_operator->tourOperatorProfile->special_care_label}}</h4>
                                        <h4 style="font-size: 14px">Tour Types: Please visit our blogs for more</h4>
                                        <h4 style="font-size: 14px">Phone number: <a href="tel:{{$tour_operator->phone_number}}">Click to call</a></h4>
                                        <h4 style="font-size: 14px">Email address:<a href="mailto:{{$tour_operator->email_address}}">Click to Email us</a></h4>

                                    </div>


                                </div>
                            </div>
                        </div>
{{--                        End of the right container--}}
                    </div>

{{--                    End of the Child Row--}}



                </div>
            </div>
        </div>
    </div>
{{--    End of mother row--}}

{{--    Second row for the about company--}}
                <div class="row" style="padding-top:10px">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
{{--                                First row--}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card" style="border: 2px solid gainsboro">
                                            <div class="card-body">
                                                <legend style="text-align: center">About us</legend>
                                                <div style="align-items: center">
                                                    <p style="text-align: center">{{$tour_operator->tourOperatorProfile->about_company}}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
{{--                                First end row--}}
{{--                                Second row--}}
                                <div class="row" style="padding-top:8px ">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">

{{--                                                Inner row--}}
                                                <div class="row">
{{--                                                    Container 1--}}
                                                    <div class="col-md-4">
                                                        <div class="card" style="border: 2px solid gainsboro">
                                                            <div class="card-body">

                                                                <legend style="text-align: center">Company address</legend>
                                                                @if(!empty($tour_operator_addresses) && $tour_operator_addresses->count())
                                                                @foreach($tour_operator_addresses as $tour_operator_address)
                                                                    <address style="text-align: center;text-decoration-thickness: auto">{{$tour_operator_address->company_operating_regions}} | {{$tour_operator_address->company_address}} | {{$tour_operator_address->company_contact}}</address>
                                                                    @endforeach
                                                                @else
                                                                <span>Seems this tour operator has no address</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                   End Container 1--}}

{{--                                                    Container 2--}}
                                                    <div class="col-md-4">
                                                        <div class="card" style="border: 2px solid gainsboro">
                                                            <div class="card-body">

                                                                <legend style="text-align: center">Company Core Values</legend>
                                                                <h4 style="font-size: 14px;text-align: center">{{$tour_operator->tourOperatorProfile->company_core_values}}</h4>

                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    End container 2--}}

{{--                                                    Container 3--}}
                                                    <div class="col-md-4">
                                                        <div class="card" style="border: 2px solid gainsboro">
                                                            <div class="card-body">

                                                                <legend style="text-align: center">Other Operations Areas</legend>
                                                                <h4 style="font-size: 14px;text-align: center">{{$tour_operator->tourOperatorProfile->tourist_attraction_label}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
{{--                                                    End container 3--}}
                                                </div>
{{--                                                End of inner row--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    {{--End second row--}}
                            </div>
                        </div>
                    </div>
                </div>
{{--    End of the row for about company--}}

    <div class="row" style="padding-top: 10px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="border:2px solid gainsboro">
                                <div class="card-body">

                                    <div style="padding-top:10px">
                                        <legend style="text-align: center">We are public also. Check us here</legend>

                                        <div class="end_contents">
                                            <a href="{{$tour_operator->company_instagram_url}}" target="_blank"><img src="{{url('/img/Kyto/Back-images/Instagram icon.png')}}" class="social-images" title="Instagram"></a>
                                            <a href="{{$tour_operator->company_website_url}}" target="_blank"><img src="{{url('/img/Kyto/Back-images/website.png')}}" class="social-images" title="website"></a>
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


@endsection
