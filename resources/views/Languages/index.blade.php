@extends('layouts.main', ['title' => trans('Languages'), 'header' => trans('Languages')])

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
                <a class='' href="{{ route('Language.create') }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add language') }}</a>&nbsp;&nbsp;

                @include('Languages.get_language')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
