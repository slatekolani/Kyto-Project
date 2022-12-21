@extends('layouts.main', ['title' => trans('Member Nationality'), 'header' => trans('Member Nationality')])

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
                <a class='' href="{{ route('MemberNationality.create') }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add nation') }}</a>&nbsp;&nbsp;

                @include('MemberNationality.get_member_nationality')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
