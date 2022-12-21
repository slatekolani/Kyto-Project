@extends('layouts.main', ['title' => trans('Tour Type Categories'), 'header' => trans('Tour Type Categories')])

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
                <a class='' href="{{ route('tourType.create') }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add tour type') }}</a>&nbsp;&nbsp;

                @include('tourType.get_tour_type')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
