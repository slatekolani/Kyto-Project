@extends('layouts.main', ['title' => __("Normal Booking"), 'header' => trans("Normal Booking")])

@include('includes.validate_assets')



@section('content')

    {{ Form::open(['route' => 'touristBookings.store', 'autocomplete' => 'off','method' => 'post', 'class' => 'needs-validation', 'novalidate']) }}
    <div class="image_container">
        <img src="{{asset('public/BlogImages/topicImages/'.$tour_operator_blogs->blog_topic_image)}}"
             class="imageBackground" style="height:450px;width:100%">
        <div class="text_container">
            <div class="text">
                <h2 style="color: goldenrod"> {{\App\Models\touristAttraction\touristAttraction::find($tour_operator_blogs->blog_topic)->attraction_name}}</h2>
                <h3>"{{$tour_operator_blogs->topic_description}}"</h3>
                <div style="display: inline-flex">
                    <h3>Tanzanian: <span style="color: goldenrod">{{number_format($tour_operator_blogs->visit_cost_local)}} shillings </span>~
                    </h3>
                    <h3>~ Foreigner: <span style="color: goldenrod">${{number_format($tour_operator_blogs->visit_cost_foreigner)}} USD</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="content" style="padding-top: 30px">
        <div class="row">
            <div class="col-md-8">
                <section class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">
                        <h4 style="text-align: center;border-bottom: 2px solid gainsboro">BOOKING FOR A TRIP TO <span
                                    style="color: goldenrod">"<i>{{\App\Models\touristAttraction\touristAttraction::find($tour_operator_blogs->blog_topic)->attraction_name}}"</i></span>
                        </h4>
                        <p>{{ getLanguageBlock('lang.auth.mandatory-field') }}</p>
                        {{--User account type(Administrative)--}}

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    {{--Left--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('tourist_name', __("Tourist name"), ['class' => 'required_asterik']) }}
                                            {{ Form::text('tourist_name', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'tourist_name', 'required']) }}
                                            {!! $errors->first('tourist_name', '<span class="badge badge-danger">:message</span>')!!}
                                        </div>
                                    </div>
                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('phone_number', __("Phone number"), ['class' => 'required_asterik']) }}
                                            {{ Form::tel('phone_number', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'phone_number', 'required']) }}
                                            <small id="phoneHelp" class="form-text text-muted">Valid phone number for
                                                your tour operator to reach you</small>
                                            {!! $errors->first('phone_number', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    {{--Left--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('email_address', __("Email address"), ['class' => 'required_asterik']) }}
                                            {{ Form::email('email_address', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'email_address', 'aria-describedby' => 'emailHelp', 'required']) }}
                                            <small id="emailHelp"
                                                   class="form-text text-muted">{{ __("Valid email address for your tour operator to reach you") }}</small>
                                            {!! $errors->first('email_address', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('tourist_nation', __("Nationality"), ['class' => 'required_asterik']) }}
                                            {{ Form::select('tourist_nation',$nation, null, ['class' => 'form-control select2', 'autocomplete' => 'off', 'id' => 'tourist_nation',  'required']) }}
                                            {!! $errors->first('tourist_nation', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    {{--Left--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('number_of_tourists', __("Number of travellers"), ['class' => 'required_asterik']) }}
                                            {{ Form::number('number_of_tourists', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'number_of_tourists','required']) }}
                                            <small id="emailHelp"
                                                   class="form-text text-muted">{{ __("Number of travellers determines your bill") }}<span class="badge badge-pill badge-success" style="font-size: 12px"></span></small>
                                            {!! $errors->first('number_of_tourists', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>

                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('start_date', __("Start date"), ['class' => 'required_asterik']) }}
                                            {{ Form::date('start_date', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'start_date','required']) }}
                                            <small id="emailHelp"
                                                   class="form-text text-muted">{{ __("Number of days determines your bill") }}</small>
                                            {!!  $errors->first('start_date', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    {{--Left--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('end_date', __("End date"), ['class' => 'required_asterik']) }}
                                            {{ Form::date('end_date', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'end_date', 'required']) }}
                                            <small id="emailHelp"
                                                   class="form-text text-muted">{{ __("Number of days determines your bill") }}</small>
                                            {!!  $errors->first('end_date', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>

                                    {{--Right--}}

                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('tourist_request', __("Your Request or Message"), ['class' => 'required_asterik']) }}
                                            {{ Form::text('tourist_request', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'tourist_request', 'required']) }}
                                            <small class="form-text text-muted">{{ __("This helps tour operator to know an extra information you want to provide") }}</small>
                                            {!!  $errors->first('tourist_request', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input name="tour_operators_id" value="{{$tour_operator_blogs->tourOperators->id}}" hidden>
                        <input name="tour_operators_blogs_id" value="{{$tour_operator_blogs->id}}" hidden>
                        <br/>
                        {{--Buttons--}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="element-form">
                                    <div class="form-group pull-left">
                                        {{ link_to_route('home',trans('buttons.general.cancel'),[],['id'=> 'cancel', 'class' => 'btn btn-primary cancel_button', ]) }}
                                        {{ Form::button(trans('Send Booking Request'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!--              Form ends here  -->


            </div>
            <!--        Instructions begin here-->

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body" style="border: 2px solid gainsboro">

                        <div class="logo-container"
                             style="position: relative;display: flex;align-content: center;border-bottom: 2px solid gainsboro">
                            <img src="{{asset('public/logo_uploads/Logo/'.$tour_operator_blogs->tourOperators->logo)}}"
                                 class="logo_display" style="width:50px;height:50px">
                            <span style="padding-left:30px;font-family: sans-serif, Verdana">  {{$tour_operator_blogs->tourOperators->company_name}}</span>
                            @php
                                $average=$tour_operator_blogs->getRatingAverageAttribute();
                            @endphp
                            <div class="star" style="padding-left: 30px">
                                <i class="fa fa-star {{ (($average <= 1) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 2) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 3) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 4) ? '' : 'checked') }}"></i>
                                <i class="fa fa-star {{ (($average <= 5) ? '' : 'checked') }}"></i>
                            </div>

                        </div>

                        <div class="container">
                            <h3 style="text-align: center;font-family: sans-serif, Verdana">Payment Gateway used</h3>
                            <hr>
                            @if(!empty($tour_operator_accounts) && $tour_operator_accounts->count())
                            @foreach($tour_operator_accounts as $tour_operator_account)
                                    <img src="{{url('public/PaymentGatewayImages/images/',\App\Models\paymentGateways\paymentGateways::find($tour_operator_account->payment_gateway)->payment_gateway_image)}}" class="gateway-images">
                            @endforeach
                            @else
                                <span>Whoops! This tour operator didn't put accounts public. Please contact <a href="mailTo:{{$tour_operator_blogs->tourOperators->email_address}}"> here </a> to get more info</span>
                            @endif
                            <h3 style="text-align: center;font-family: sans-serif, Verdana">Payment condition</h3>
                            <hr>
                            <p>{{$tour_operator_blogs->payment_condition}}</p>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
    <br/>
    {{ Form::close() }}
@endsection

@push('after-scripts')

    <script>
        $(function () {
            $(".select2").select2();

        });
    </script>

@endpush

@push('after-scripts')

    <script>
        $(function () {
            var dateToday = new Date();
            var month = dateToday.getMonth() + 1;
            var day = dateToday.getDate();
            var year = dateToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var MaxDate = year + '-' + month + '-' + day;
            $('#start_date').attr('min', MaxDate);

        });


    </script>
@endpush

@push('after-scripts')

    <script>
        $(function () {
            var dateToday = new Date();
            var month = dateToday.getMonth() + 1;
            var day = dateToday.getDate();
            var year = dateToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var MaxDate = year + '-' + month + '-' + day;
            $('#end_date').attr('min', MaxDate);
        })
    </script>
@endpush

