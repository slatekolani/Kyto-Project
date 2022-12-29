@extends('layouts.main', ['title' => trans('Solo Trip Amount'), 'header' => trans('Solo Trip Amount')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')


    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12">
            <section class="card card-primary mb-4">
                @if($solo_booking->NumberOfSoloTripAmountTransactionLabel<1)
                <a class='' href="{{ route('SoloTripAmount.create',$solo_booking->uuid) }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Set Amount') }}</a>&nbsp;&nbsp;
                @else
                    <button style='cursor: pointer' onclick="alert('Amount is already set!')"><i
                            class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Set Amount') }}</button>&nbsp;&nbsp;
                @endif
                @include('touristBookings.SoloBookings.SoloTripAmount.get_solo_trip_amount')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
