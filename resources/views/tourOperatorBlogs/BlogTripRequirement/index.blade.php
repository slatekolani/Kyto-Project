@extends('layouts.main', ['title' => trans('Trip Requirement'), 'header' => trans('Trip Requirement')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-md-12">
            <section class="card card-primary mb-4">
                <header class="card-header card-header-custom">
                    <div class="card-actions">
                        {{--Action Links--}}

                    </div>
                    <h2 class="card-title">{{ trans('Trip Requirement') }}</h2>
                </header>

                @include('tourOperatorBlogs.BlogTripRequirement.get_trip_requirement')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
