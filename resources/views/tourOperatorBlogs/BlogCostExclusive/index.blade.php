@extends('layouts.main', ['title' => trans('Cost Exclusive Materials'), 'header' => trans('Cost Exclusive Materials')])

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
                    <h2 class="card-title">{{ trans('Cost exclusive Materials') }}</h2>
                </header>
                @include('tourOperatorBlogs.BlogCostExclusive.get_blog_cost_exclusive')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
