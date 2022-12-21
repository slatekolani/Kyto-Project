@extends('layouts.main', ['title' => trans('Tourist Attraction'), 'header' => trans('Tourist Attraction')])

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
                <a class='' href="{{ route('touristAttraction.create') }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Add attraction') }}</a>&nbsp;&nbsp;

                @include('touristAttraction.get_tourist_attractions')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
