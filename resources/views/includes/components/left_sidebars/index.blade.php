
{{--@permission('admin_menu')--}}

{{--@include('includes/components/left_sidebars/admin')--}}

{{--@else--}}

    {{--@include('includes/components/left_sidebars/default')--}}
{{--@endauth--}}
@if(Auth::user()->hasRole(1))
@include('includes/components/left_sidebars/admin')
@elseif(Auth::user()->hasRole(2))
    @include('includes/components/left_sidebars/admin')
@else

@endif
