@extends('layouts.main', ['title' => trans('Payments'), 'header' => trans('Payments')])

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
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Amount to be Paid') }}</h5>
                        @if($tourist_booking->tourist_nation==1)
                            <p>{{number_format($tourist_booking->amount_to_be_paid_local_label)}} shillings</p>
                        @else
                            <p>${{number_format($tourist_booking->amount_to_be_paid_foreigner_label)}} USD</p>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Tour bill') }}</h5>
                        @if($tourist_booking->tourist_nation==1)
                        <p>{{number_format($tourist_booking->tourOperatorsBlogs->visit_cost_local)}} shillings</p>
                        @else
                        <p>${{number_format($tourist_booking->tourOperatorsBlogs->visit_cost_foreigner)}} USD</p>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Reserve Amount Required') }}</h5>
                        @if($tourist_booking->tourist_nation==1)
                            <p>{{number_format($tourist_booking->reserve_amount_to_be_paid_local_label)}} Shillings</p>
                            @if($tourist_booking->amount_paid_label >= $tourist_booking->reserve_amount_to_be_paid_local_label)
                                <span class="badge badge-success">successful payment</span>
                            @else
                                <span class="badge badge-info">Incomplete paid</span>
                            @endif
                        @else
                            <p>${{number_format($tourist_booking->reserve_amount_to_be_paid_foreigner_label)}} USD</p>
                            @if($tourist_booking->amount_paid_label >= $tourist_booking->reserve_amount_to_be_paid_foreigner_label)
                                <span class="badge badge-success">successful payment</span>
                            @else
                                <span class="badge badge-info">Incomplete paid -</span>
                            @endif
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Amount Paid (Verified)') }}</h5>
                        @if($tourist_booking->tourist_nation==1)
                            <p>{{number_format($tourist_booking->amount_paid_label)}} shillings</p>
                            @if($tourist_booking->amount_paid_label < $tourist_booking->amount_to_be_paid_local_label)
                                <span class="badge badge-pill badge-danger">Incomplete payment</span>
                            @else
                                <span class="badge badge-pill badge-success">Completed</span>
                            @endif
                        @else
                            <p>${{number_format($tourist_booking->amount_paid_label)}} USD</p>
                            @if($tourist_booking->amount_paid_label < $tourist_booking->amount_to_be_paid_foreigner_label)
                                <span class="badge badge-pill badge-danger">Incomplete</span>
                            @else
                                <span class="badge badge-pill badge-success">Complete</span>
                            @endif
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Remaining amount(Pending)') }}</h5>
                        @if($tourist_booking->tourist_nation==1)
                            <p>{{number_format(($tourist_booking->amount_to_be_paid_local_label) - ($tourist_booking->amount_paid_label))}} shillings</p>
                        @else
                            <p>{{number_format(($tourist_booking->amount_to_be_paid_foreigner_label) - ($tourist_booking->amount_paid_label))}} USD</p>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Exceeded Paid Amount') }}</h5>
                        @if($tourist_booking->tourist_nation==1)
                            <p>{{number_format(($tourist_booking->amount_paid_label) - ($tourist_booking-> amount_to_be_paid_local_label))}} shillings</p>
                            @else
                            <p>{{number_format(($tourist_booking->amount_paid_label) - ($tourist_booking->amount_to_be_paid_foreigner_label))}} USD</p>
                        @endif
                    </a>
                </ul>
            </div>
        </div>

    </div>
    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12" >
            <section class="card card-primary mb-4" style="width:110%">

                @include('payments.get_booking_payments')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
