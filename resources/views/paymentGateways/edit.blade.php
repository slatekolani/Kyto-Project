@extends('layouts.main', ['title' => __(" Payment gateways"), 'header' => trans("Payment gateways")])

@include('includes.validate_assets')



@section('content')

    {{ Form::model($payment_gateway,['enctype="multipart/form-data"','route' => ['paymentGateway.update', $payment_gateway->uuid], 'method'=>'put','autocomplete' => 'off',
                 'id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
    {{ Form::hidden('id', $payment_gateway->id, []) }}
    <section class="card">
        <div class="card-body">
            <p>{{ getLanguageBlock('lang.auth.mandatory-field') }}</p>
            {{--User account type(Administrative)--}}

            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        {{--Left--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                {{ Form::label('payment_gateway_name', __("Payment gateway"), ['class' => 'required_asterik']) }}
                                {{ Form::text('payment_gateway_name', $payment_gateway->payment_gateway_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'payment_gateway_name', 'required']) }}
                                {!! $errors->first('payment_gateway_name', '<span class="badge badge-danger">:message</span>')!!}
                            </div>
                        </div>
                        {{--Right--}}
                        <div class="col-xs-3 col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <img src="{{url('public/PaymentGatewayImages/images/',$payment_gateway->payment_gateway_image)}}" style="width:50px;height:50px">
                                {{ Form::label('payment_gateway_image', __("Payment gateway image"), ['class' => 'required_asterik']) }}
                                {{ Form::file('payment_gateway_image', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'payment_gateway_image', 'required']) }}
                                {!! $errors->first('payment_gateway_image', '<span class="badge badge-danger">:message</span>') !!}
                            </div>
                        </div>
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
                            {{ Form::button(trans('Populate'), ['class' => 'btn btn-primary', 'type'=>'submit', 'style' => 'border-radius: 5px;']) }}
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
