@extends('layouts.main', ['title' => __("Tanzania Tour Operator"), 'header' => trans("Tanzania Tour Operator")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($tourist_bookings,['enctype="multipart/form-data"','route' => ['touristBookings.update', $tourist_bookings->uuid], 'method'=>'put','autocomplete' => 'off',
       'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $tourist_bookings->id, []) }}

    <div class="image_container">
        <img src="{{asset('public/BlogImages/topicImages/'.$tourist_bookings->tourOperatorsBlogs->blog_topic_image)}}"
             class="imageBackground" style="height:450px;width:100%">
        <div class="text_container">
            <div class="text">
                <h2 style="color: goldenrod"> {{\App\Models\touristAttraction\touristAttraction::find($tourist_bookings->tourOperatorsBlogs->blog_topic)->attraction_name}}</h2>
                <h3>"{{$tourist_bookings->tourOperatorsBlogs->topic_description}}"</h3>
                <div style="display: inline-flex">
                    <h3>Tanzanian: <span style="color: goldenrod">{{number_format($tourist_bookings->tourOperatorsBlogs->visit_cost_local)}} shillings </span>~
                    </h3>
                    <h3>~ Foreigner: <span style="color: goldenrod">${{number_format($tourist_bookings->tourOperatorsBlogs->visit_cost_foreigner)}} USD</span>
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
                                style="color: goldenrod">"<i>{{\App\Models\touristAttraction\touristAttraction::find($tourist_bookings->tourOperatorsBlogs->blog_topic)->attraction_name}}"</i></span>
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
                                            {{ Form::text('tourist_name', $tourist_bookings->tourist_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'tourist_name', 'required']) }}
                                            {!! $errors->first('tourist_name', '<span class="badge badge-danger">:message</span>')!!}
                                        </div>
                                    </div>
                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('phone_number', __("Phone number"), ['class' => 'required_asterik']) }}
                                            {{ Form::tel('phone_number', $tourist_bookings->phone_number, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'phone_number', 'required']) }}
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
                                            {{ Form::email('email_address', $tourist_bookings->email_address, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'email_address', 'aria-describedby' => 'emailHelp', 'required']) }}
                                            <small id="emailHelp"
                                                   class="form-text text-muted">{{ __("Valid email address for your tour operator to reach you") }}</small>
                                            {!! $errors->first('email_address', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('tourist_nation', __("Nationality"), ['class' => 'required_asterik']) }}
                                            {{ Form::select('tourist_nation',$nation, $nation, ['class' => 'form-control select2', 'autocomplete' => 'off', 'id' => 'tourist_nation',  'required']) }}
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
                                            {{ Form::number('number_of_tourists', $tourist_bookings->number_of_tourists, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'number_of_tourists','required']) }}
                                            <small id="emailHelp"
                                                   class="form-text text-muted">{{ __("Number of travellers determines your bill") }}</small>
                                            {!! $errors->first('number_of_tourists', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>

                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('start_date', __("Start date"), ['class' => 'required_asterik']) }}
                                            {{ Form::date('start_date', $tourist_bookings->start_date, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'start_date','required']) }}
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
                                            {{ Form::date('end_date', $tourist_bookings->end_date, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'end_date', 'required']) }}
                                            <small id="emailHelp"
                                                   class="form-text text-muted">{{ __("Number of days determines your bill") }}</small>
                                            {!!  $errors->first('end_date', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>

                                    {{--Right--}}

                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('tourist_request', __("Your Request or Message"), ['class' => 'required_asterik']) }}
                                            {{ Form::text('tourist_request', $tourist_bookings->tourist_request, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'tourist_request', 'required']) }}
                                            <small class="form-text text-muted">{{ __("This helps tour operator to know an extra information you want to provide") }}</small>
                                            {!!  $errors->first('tourist_request', '<span class="badge badge-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input name="tour_operators_id" value="{{$tourist_bookings->tourOperators->id}}" hidden>
                        <input name="tour_operators_blogs_id" value="{{$tourist_bookings->tourOperatorsBlogs->id}}" hidden>
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

