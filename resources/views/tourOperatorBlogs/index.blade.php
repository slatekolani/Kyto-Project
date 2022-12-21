@extends('layouts.main', ['title' => trans('Manage Blogs'), 'header' => trans('Manage Blogs')])

@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/sweetalert/sweetalert.css')) }}

    <style>

    </style>
@endpush
@section('content')
    <div class="row">

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Number of Approved blogs') }} ~ <span class="badge badge-pill badge-success" style="padding:8px">{{$tour_operator->checked_blog_label}}</span></h5>
                    </a>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="list-group">
                <ul class="list-unstyled">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="list-group-item-heading"><i class="fas fa-clipboard"></i> {{ __('Number of Unchecked blogs') }} ~ <span class="badge badge-pill badge-danger" style="padding:8px">{{$tour_operator->unchecked_blog_label}}</span></h5>
                    </a>
                </ul>
            </div>
        </div>
    </div>
    <div class="row" style="overflow-x: scroll">
        <div class="col-md-12">
            <section class="card card-primary mb-4" style="width:1000%">
                <a class='' href="{{ route('tourOperatorBlogs.create',$tour_operator->uuid) }}"><i
                        class="fas fa-pencil-alt"></i>&nbsp;{{ trans('Create blog') }}</a>&nbsp;&nbsp;
                @include('tourOperatorBlogs.get_tour_operator_blogs')
            </section>
        </div>

    </div>

@endsection

@push('after-scripts')
    {{ Html::script(url('vendor/sweetalert/sweetalert.min.js')) }}
@endpush
