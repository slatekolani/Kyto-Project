@extends('layouts.main', ['title' => __("Solo Trip Amount"), 'header' => trans("Solo Trip Amount")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($solo_trip_amount,['enctype="multipart/form-data"','route' => ['SoloTripAmount.update', $solo_trip_amount->uuid], 'method'=>'put','autocomplete' => 'off',
            'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $solo_trip_amount->id, []) }}    <div class="content" style="padding-top: 30px">
        <div class="row">
            <div class="col-md-8">
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
                                            {{ Form::label('amount_to_be_paid', __("Amount to be Paid"), ['class' => 'required_asterik']) }}
                                            {{ Form::number('amount_to_be_paid', $solo_trip_amount->amount_to_be_paid, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'amount_to_be_paid', 'required']) }}
                                            {!! $errors->first('amount_to_be_paid', '<span class="badge badge-danger">:message</span>')!!}
                                        </div>
                                    </div>
                                    {{--Right--}}
                                </div>
                            </div>
                        </div>

                        <input name="solo_bookings_id" value="{{$solo_trip_amount->soloBookings->id}}" hidden>
                        <br/>
                        {{--Buttons--}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="element-form">
                                    <div class="form-group pull-left">
                                        {{ link_to_route('home',trans('buttons.general.cancel'),[],['id'=> 'cancel', 'class' => 'btn btn-primary cancel_button', ]) }}
                                        {{ Form::button(trans('Set Amount'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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


