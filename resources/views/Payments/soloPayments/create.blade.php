@extends('layouts.main', ['title' => __(" Payments"), 'header' => trans("Payments")])

@include('includes.validate_assets')



@section('content')

    <h4 style="font-family: sans-serif, Verdana;text-align: center">Congrats for being approved, here are the accounts to do trip payments. Choose one of your choice...</h4>
    <section class="card">
        <div class="card-body">
            <div class="row">
                @if(!empty($tour_operator_accounts) && $tour_operator_accounts->count())
                    @foreach($tour_operator_accounts as $tour_operator_account)
                        @if($tour_operator_account->status==1)
                            <div class="d-flex flex-row bd-highlight mb-3">
                                <div class="container_blog">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card-body" style="border: 2px solid gainsboro">
                                                        <div class="end_contents">
                                                            <h4 style="font-family: sans-serif, Verdana"><span class="badge badge-light">Approved</span></h4>
                                                            <img src={{url('public/PaymentGatewayImages/images/',\App\Models\paymentGateways\paymentGateways::find($tour_operator_account->payment_gateway)->payment_gateway_image)}} style="width:70px;height:50px">
                                                        </div>
                                                        <hr>
                                                        <div class="end_contents">
                                                            <button type="button" class="btn btn-primary btn-sm payment" value="{{\App\Models\tourOperatorAccounts\tourOperatorAccounts::find($tour_operator_account->id)->payment_gateway}}">Pay</button>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">

                                                    <div class="container">
                                                        <!-- Trigger the modal with a button -->

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="myModal{{\App\Models\tourOperatorAccounts\tourOperatorAccounts::find($tour_operator_account->id)->payment_gateway}}" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <div class="row" style="display: flex">
                                                                            <div class="col-md-12" style="border-bottom: 3px solid gainsboro">
                                                                                <div class="col-md-2" style="display: inline-flex;">
                                                                                    <img src={{url('public/PaymentGatewayImages/images/',\App\Models\paymentGateways\paymentGateways::find($tour_operator_account->payment_gateway)->payment_gateway_image)}} style="width:70px;height:50px;margin-left:150px">
                                                                                    {{--                                                                        <h4 style="padding-left: 30px;"> {{\App\Models\paymentGateways\paymentGateways::find($tour_operator_account->payment_gateway)->payment_gateway_name}}</h4>--}}
                                                                                </div>

                                                                            </div>
                                                                            <div class="col-md-10">
                                                                                <div class="end_contents">
                                                                                    <h4 style="font-family: sans-serif, Verdana">Account Name ~ {{$tour_operator_account->account_name}}</h4>
                                                                                    <h4 style="font-family: sans-serif, Verdana">Account Number ~ {{$tour_operator_account->account_number}}</h4>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <hr>

                                                                    <div class="modal-body">
                                                                        {{ Form::open([ 'route' => 'soloBookingPayments.store',  'autocomplete' => 'off','method' => 'post', 'class' => 'needs-validation', 'validate']) }}
                                                                        <div class="form-group" id="">
                                                                            {{ Form::label('account_name', __("Personal account name"), ['class' => 'required_asterik']) }}
                                                                            {{ Form::text('account_name', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'account_name', 'required']) }}
                                                                            {!! $errors->first('account_name', '<span class="badge badge-danger">:message</span>')!!}
                                                                        </div>

                                                                        <div class="form-group" id="">
                                                                            {{ Form::label('amount', __("Amount Transacted"), ['class' => 'required_asterik']) }}
                                                                            {{ Form::number('amount', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'amount', 'required']) }}
                                                                            {!! $errors->first('amount', '<span class="badge badge-danger">:message</span>') !!}
                                                                        </div>
                                                                        <div class="form-group" id="">
                                                                            {{ Form::label('reference', __("Reference number"), ['class' => 'required_asterik']) }}
                                                                            {{ Form::text('reference', null, ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'reference', 'required']) }}
                                                                            {!! $errors->first('reference', '<span class="badge badge-danger">:message</span>')!!}
                                                                        </div>

                                                                        <div class="form-group" id="operator_inputs">

                                                                        </div>

                                                                        <input name="payment_gateway" value="{{\App\Models\tourOperatorAccounts\tourOperatorAccounts::find($tour_operator_account->id)->payment_gateway}}" hidden>
                                                                        <input name="tour_operators_id" value="{{$solo_bookings->tourOperators->id}}" hidden>
                                                                        <input name="solo_bookings_id" value="{{$solo_bookings->id}}" hidden>

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
                        @endif
                    @endforeach
                @else
                    <span> Sorry, Seems {{$solo_bookings->tourOperators->company_name}} has not published their accounts public. Please mail the tour operator <a href="mailTo:{{$solo_bookings->tourOperators->email_address}}"> here </a>  or call <a href="tel:{{$solo_bookings->tourOperators->phone_number}}">here</a> to get instructions on payments</span>
                @endif
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

