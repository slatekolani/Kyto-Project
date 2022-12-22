@extends('layouts.main', ['title' => __("Account Information"), 'header' => trans("Account Information")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($solo_tourist_account_information,['enctype="multipart/form-data"','route' => ['soloTouristAccountInformation.update', $solo_tourist_account_information->uuid], 'method'=>'put','autocomplete' => 'off',
          'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $solo_tourist_account_information->id, []) }}
    <i class="fa fa-pencil-alt">Edit Account Information for your trip pals to use for payments</i>
    <section class="card">
        <div class="card-body" style="border: 2px solid gainsboro">
            <p>{{ getLanguageBlock('lang.auth.mandatory-field') }}</p>
            {{--User account type(Administrative)--}}
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('payment_gateway', __("Payment gateway"), ['class' => 'required_asterik']) }}
                                {{ Form::select('payment_gateway',$payment_gateway, $solo_tourist_account_information->payment_gateway, ['class' => 'form-control select2', 'autocomplete' => 'off', 'id' => 'payment_gateway', 'required']) }}
                                {!! $errors->first('payment_gateway', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('account_name', __("Account name"), ['class' => 'required_asterik']) }}
                                {{ Form::text('account_name', $solo_tourist_account_information->account_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'account_name', 'required']) }}
                                {!! $errors->first('account_name', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('account_number', __("Account number"), ['class' => 'required_asterik']) }}
                                {{ Form::text('account_number', $solo_tourist_account_information->account_number, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'account_number', 'required']) }}
                                {!! $errors->first('account_number', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
                        {{--Right--}}
                        <input name="solo_bookings_id" value="{{$solo_tourist_account_information->soloBookings->id}}" hidden>
                    </div>
                </div>
            </div>





            <br/>
            {{--Buttons--}}
            <div class="row">
                <div class="col-md-6">
                    <div class="element-form">
                        <div class="form-group pull-left">
                            {{ link_to_route('home',trans('buttons.general.cancel'),[],['id'=> 'cancel', 'class' => 'btn btn-primary cancel_button', ]) }}
                            {{ Form::button(trans('Update'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br/>
    {{ Form::close() }}
@endsection

@push('after-scripts')

    <script>
        $(function() {
            $(".select2").select2();

        });
    </script>

@endpush
