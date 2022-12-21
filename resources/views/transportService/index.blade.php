@extends('layouts.main', ['title' => trans('Transport Service Categories'), 'header' => trans('Transport Service Categories')])

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
                <a class='' href="{{ route('transportService.create') }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add transport service') }}</a>&nbsp;&nbsp;

                @include('transportService.get_transport_service')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
