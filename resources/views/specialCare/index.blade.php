@extends('layouts.main', ['title' => trans('Special Care Categories'), 'header' => trans('Special Care Categories')])

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
                <a class='' href="{{ route('specialCare.create') }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add special care category') }}</a>&nbsp;&nbsp;

                @include('specialCare.get_special_care')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
