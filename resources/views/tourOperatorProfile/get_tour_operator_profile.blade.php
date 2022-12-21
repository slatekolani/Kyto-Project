@extends('layouts.main', ['title' => $tour_operator->company_name, 'header' => $tour_operator->company_name])
@include('includes.datatable_assets')
@push('after-styles')
    {{ Html::style(url('vendor/select2/css/select2.min.css')) }}
    {{ Html::style(url('vendor/magnific-popup/magnific-popup.css')) }}
    {{ Html::style(url('vendor/animate/animate.css')) }}

    <style>

    </style>
@endpush

@section('content')

    <div class="row">

        {{--MAIN CONTENT--}}
        <div class="col-md-9">

            {{--Contact Person Info--}}
            @include('tourOperatorProfile.show_profile')


        </div>

    </div>







@endsection


@push('after-scripts')
    {{ Html::script(url('vendor/select2/js/select2.min.js')) }}
    {{ Html::script(url('js/examples/examples.modals.js')) }}
    <script>
        $(function() {
            $(".select2").select2();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var tab = $(e.target).attr('href').substr(1);
                if (history.pushState) {
                    history.pushState(null, null, '#' + tab);
                    //var id = this.id;
                    //alert(id);
                } else {
                    location.hash = '#' + tab;
                }
            });


        });
    </script>
@endpush
