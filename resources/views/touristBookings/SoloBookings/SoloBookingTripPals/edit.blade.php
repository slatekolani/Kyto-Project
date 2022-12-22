@extends('layouts.main', ['title' => __("Trip Pals"), 'header' => trans("Trip Pals")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($solo_booking_trip_pal,['enctype="multipart/form-data"','route' => ['soloBookingTripPals.update', $solo_booking_trip_pal->uuid], 'method'=>'put','autocomplete' => 'off',
             'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $solo_booking_trip_pal->id, []) }}       <div class="content" style="padding-top: 30px">
        <div class="row">
            <div class="col-md-8">
                <i class="fas fa-pencil-alt">Add Trip Pals Manually</i>
                <section class="card" style="border: 2px solid gainsboro">
                    <div class="card-body">
                        <p>{{ getLanguageBlock('lang.auth.mandatory-field') }}</p>
                        {{--User account type(Administrative)--}}

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    {{--Left--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('tourist_name', __("Invited Tourist name"), ['class' => 'required_asterik']) }}
                                            {{ Form::text('tourist_name', $solo_booking_trip_pal->tourist_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'tourist_name', 'required']) }}
                                            {!! $errors->first('tourist_name', '<span class="badge badge-danger">:message</span>')!!}
                                        </div>
                                    </div>
                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('phone_number', __("Phone number"), ['class' => 'required_asterik']) }}
                                            {{ Form::tel('phone_number', $solo_booking_trip_pal->phone_number, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'phone_number', 'required']) }}
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
                                            {{ Form::email('email_address', $solo_booking_trip_pal->email_address, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'email_address', 'required']) }}
                                            {!! $errors->first('email_address', '<span class="badge badge-danger">:message</span>')!!}
                                        </div>
                                    </div>
                                    {{--Right--}}
                                    <div class="col-xs-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            {{ Form::label('trip_amount', __("Trip Amount Paid"), ['class' => 'required_asterik']) }}
                                            {{ Form::number('trip_amount', $solo_booking_trip_pal->trip_amount, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'email_address', 'required']) }}
                                            {!! $errors->first('trip_amount', '<span class="badge badge-danger">:message</span>')!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input name="solo_bookings_id" value="{{$solo_booking_trip_pal->soloBookings->id}}" hidden>
                        <br/>
                        {{--Buttons--}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="element-form">
                                    <div class="form-group pull-left">
                                        {{ link_to_route('home',trans('buttons.general.cancel'),[],['id'=> 'cancel', 'class' => 'btn btn-primary cancel_button', ]) }}
                                        {{ Form::button(trans('Update Trip Pal'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
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
