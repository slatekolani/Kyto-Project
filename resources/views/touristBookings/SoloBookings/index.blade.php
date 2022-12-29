@extends('layouts.main', ['title' => trans('Solo Trip Bookings'), 'header' => trans('Solo Trip Bookings')])

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
                    <a href="{{route('soloBookings.index',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Total Solo Bookings') }} ~ {{$solo_booking->total_solo_bookings_label}} </h5>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('soloBookings.verifiedTripsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Verified Trips') }} ~ {{$solo_booking->verified_solo_bookings_label}} </h5>
                        <span class="badge badge-success">confirmed</span>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('soloBookings.unverifiedTripsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Unverified Trips') }} ~ {{$solo_booking->unverified_solo_bookings_label}}</h5>
                        <span class="badge badge-warning">Unconfirmed</span>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Unset solo trip price ') }} </h5>
                        <p>Search <span class="badge badge-danger">Unset</span></p>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('soloBookingPayments.unverifiedSoloTripPaymentsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Unchecked Transactions') }} ~ {{$tour_operator->number_of_unchecked_transactions_for_solo_trip_label}}</h5>
                        <span class="badge badge-info">unchecked</span>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('soloBookingPayments.verifiedSoloTripPaymentsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Checked Transactions') }} ~ {{$tour_operator->number_of_checked_transactions_for_solo_trip_label}} </h5>
                         <span class="badge badge-success">checked</span>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('soloBookings.recentTripsToBeConductedIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Trips to be conducted on')}}</h5>
                        <p><span class="badge badge-light">{{date('F , Y')}}</span></p>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('soloBookings.overview',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Bookings Overview') }}</h5>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="{{route('soloBookings.recentSoloTripsBookingsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Recent Bookings') }} </h5>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Bookings timed out') }} </h5>
                        <p>Search <span class="badge badge-danger">Out of range</span></p>
                    </a>
                </ul>
            </div>
        </div>

        @if($solo_booking==null)
            <div class="col-md-4">
                <div class="list-group">
                    <ul class="list-unstyled">
                        <button onclick="alert('Please wait for a booking to be made')" class="list-group-item list-group-item-action">
                            <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Recent Transactions') }}</h5>
                        </button>
                    </ul>
                </div>
            </div>
        @else
            <div class="col-md-4">
                <div class="list-group">
                    <ul class="list-unstyled">
                        <a href="{{route('soloBookingPayments.recentSoloTripPaymentsIndex',$tour_operator->uuid)}}" class="list-group-item list-group-item-action">
                            <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Recent Transactions') }}</h5>
                        </a>
                    </ul>
                </div>
            </div>
        @endif


    </div>

    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12">
            <section class="card card-primary mb-4" style="width:400%">
                @include('touristBookings.SoloBookings.get_solo_bookings')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
