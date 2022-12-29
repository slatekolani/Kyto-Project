@extends('layouts.main', ['title' => __("Solo Trip Payment"), 'header' => trans("Solo Trip Payment")])

@include('includes.validate_assets')



@section('content')

    <section class="card">
        <div class="card-body">
            <div class="row">
                <div class="d-flex flex-row bd-highlight mb-3">
                    <div class="container_blog">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body" style="border: 2px solid gainsboro">
                                            <div class="end_contents">
                                                <h4 style="font-family: sans-serif, Verdana"><span class="badge badge-light">Approved</span></h4>
                                                <img src={{url('public/PaymentGatewayImages/images/',\App\Models\paymentGateways\paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway_image)}} style="width:70px;height:50px">
                                            </div>
                                                        <hr>
                                            <div class="end_contents">
                                                <button type="button" class="btn btn-primary btn-sm payment" value="{{\App\Models\paymentGateways\paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway}}">Pay</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="container">
                                                        <!-- Trigger the modal with a button -->

                                                        <!-- Modal -->
                                            <div class="modal fade" id="myModal{{\App\Models\paymentGateways\paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway}}" role="dialog">
                                                <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="row" style="display: flex">
                                                                <div class="col-md-12" style="border-bottom: 3px solid gainsboro">
                                                                    <div class="col-md-2" style="display: inline-flex;">
                                                                        <img src={{url('public/PaymentGatewayImages/images/',\App\Models\paymentGateways\paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway_image)}} style="width:70px;height:50px;margin-left:150px">
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="end_contents">
                                                                        <h4 style="font-family: sans-serif, Verdana">Account Name ~ {{\App\Models\paymentGateways\paymentGateways::find($solo_booking_payment->payment_gateway)->payment_gateway}}</h4>
                                                                        <h4 style="font-family: sans-serif, Verdana">Account Number ~ {{\App\Models\tourOperatorAccounts\tourOperatorAccounts::find($solo_booking_payment->payment_gateway)->account_number}}</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <hr>
                                                        <div class="modal-body">
                                                            {{ Form::model($solo_booking_payment,['route' => ['soloBookingPayments.update', $solo_booking_payment->uuid], 'method'=>'put','autocomplete' => 'off','id' => 'update','class' => 'form-horizontal  needs-validation', 'novalidate']) }}
                                                            {{ Form::hidden('id', $solo_booking_payment->id, []) }}
                                                            <div class="form-group" id="">
                                                                {{ Form::label('account_name', __("Personal account name"), ['class' => 'required_asterik']) }}
                                                                {{ Form::text('account_name', $solo_booking_payment->account_name, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'account_name', 'required']) }}
                                                                {!! $errors->first('account_name', '<span class="badge badge-danger">:message</span>')!!}
                                                            </div>
                                                            <div class="form-group" id="">
                                                                {{ Form::label('amount', __("Amount Transacted"), ['class' => 'required_asterik']) }}
                                                                {{ Form::number('amount', $solo_booking_payment->amount, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'amount', 'required']) }}
                                                                {!! $errors->first('amount', '<span class="badge badge-danger">:message</span>') !!}
                                                            </div>
                                                            <div class="form-group" id="">
                                                                {{ Form::label('reference', __("Reference number"), ['class' => 'required_asterik']) }}
                                                                {{ Form::text('reference', $solo_booking_payment->reference, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'reference', 'required']) }}
                                                                {!! $errors->first('reference', '<span class="badge badge-danger">:message</span>')!!}
                                                            </div>
                                                            <div class="form-group" id="operator_inputs">
                                                            </div>
                                                            <input name="payment_gateway" value="{{\App\Models\Payments\soloBookingPayments\soloBookingPayments::find($solo_booking_payment->id)->payment_gateway}}" hidden>
                                                            <input name="tour_operators_id" value="{{$solo_booking_payment->tourOperators->id}}" hidden>
                                                            <input name="solo_bookings_id" value="{{$solo_booking_payment->id}}" hidden>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="element-form">
                                                                        <div class="form-group pull-left">
                                                                            <button type="submit" class="btn btn-primary">Store</button>
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{ Form::close() }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <span>"Verified Tanzanian Tour Operator"</span>
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
                </div>
            </div>
            <br/>
        </div>
    </section>
    <br/>
@endsection

@push('after-scripts')

    <script>
        $(function() {
            $(".select2").select2();

        });
    </script>

@endpush
@push('after-scripts')
    <script>
        $(function (){

            $('.payment').on('click',function (e){
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

