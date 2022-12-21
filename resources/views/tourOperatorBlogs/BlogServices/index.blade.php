@extends('layouts.main', ['title' => trans('Services'), 'header' => trans('Services')])

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
                    <h2 class="card-title">{{ trans('Services') }}</h2>
                </header>

                @include('tourOperatorBlogs.BlogServices.get_blog_service')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
