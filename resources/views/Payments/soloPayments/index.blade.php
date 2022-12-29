@extends('layouts.main', ['title' => trans('Solo Trip Payments'), 'header' => trans('Solo Trip Payments')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> Amount to be Paid</h5>
                        @if($solo_booking->tourist_nation==1)
                        <span>{{number_format($solo_booking->SoloTripAmountLabel)}} shillings</span>
                        @else
                        <span> $ {{number_format($solo_booking->SoloTripAmountLabel)}}</span>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> Reserve Amount Required </h5>
                        @if($solo_booking->tourist_nation==1)
                            <span>{{number_format($solo_booking->getSoloTripReserveAmount($solo_booking))}} shillings</span>
                        @else
                            <span> $ {{number_format($solo_booking->getSoloTripReserveAmount($solo_booking))}}</span>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> Amount Paid (Verified) </h5>
                        @if($solo_booking->tourist_nation==1)
                            <span>{{number_format($solo_booking->SoloTripAmountPaidLabel)}} shillings</span>
                        @else
                            <span> $ {{number_format($solo_booking->SoloTripAmountPaidLabel)}}</span>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> Remaining amount(Pending) </h5>
                        @if($solo_booking->tourist_nation==1)
                            <span>{{number_format($solo_booking->SoloTripAmountLabel-$solo_booking->SoloTripAmountPaidLabel)}} shillings</span>
                        @else
                            <span> $ {{number_format($solo_booking->SoloTripAmountLabel-$solo_booking->SoloTripAmountPaidLabel)}}</span>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> Exceeded Paid Amount </h5>
                        @if($solo_booking->tourist_nation==1)
                            <span> {{number_format($solo_booking->SoloTripAmountPaidLabel-$solo_booking->SoloTripAmountLabel)}} shillings</span>
                        @else
                            <span> $ {{number_format($solo_booking->SoloTripAmountPaidLabel-$solo_booking->SoloTripAmountLabel)}}</span>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

    </div>

    <div class="row">
    </div>
    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12" >
            <section class="card card-primary mb-4" style="width:180%">

                @include('payments.soloPayments.get_solo_payments')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
