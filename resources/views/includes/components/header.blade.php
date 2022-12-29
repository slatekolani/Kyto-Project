<header class="header fixed has-top-menu" style="position: fixed">



        <a href="{{ url("/") }}">
            <img src="{{ url("/img/KYTO-4.png") }}" width="200" height="100" style="margin-top: -20px" alt="{{ config("app.name") }}" />
        </a>

    <!-- start: search & user box -->

    <div class="header-right">


        <span class="d-xl-inline-block">
{{-- @include("includes/partials/lang") --}}
            @auth
                @if(auth()->user()->hasRole(3))
                    @if(auth()->user()->getUserTourBookings()->count()>0)
                        <a href="{{route('touristBookings.show')}}" class="btn btn-outline-primary btn-sm">Custom Bookings</a>
                        @else
                        <a href="#" onclick="alert('You have not made booking. Book please')"><button class="btn btn-outline-danger" title="No bookings made yet">Custom Bookings</button></a>
                    @endif
                        @if(auth()->user()->getUserSoloTourBookings()->count()>0)
                            <a href="{{route('soloBookings.show')}}" class="btn btn-primary btn-sm">Solo Bookings</a>
                            @else
                            <a href="#" onclick="alert('You have not made solo booking. Book please')"><button class="btn btn-danger btn-sm">Solo Bookings</button></a>
                        @endif
                @endif
            @endauth

        </span>
        <!-- <span class="separator"></span> -->

        @guest
            <br>
            <span class="">
            @lang("label.account?")
                {{ link_to('/login', __("Login"), ['class' => 'btn btn-sm btn-primary']) }}
                {{ link_to('/register', __("Register"), ['class' => 'btn btn-sm btn-outline-primary']) }}
                &nbsp;
        </span>
        @endguest




            @auth


                <span class="separator"></span>

                <div id="userbox" class="userbox">
                    <a href="#" data-toggle="dropdown">
                        <div class="profile-info" data-lock-name="{{ access()->user()->username }}" data-lock-email="{{ access()->user()->email }}">
                            <span class="name"></span>
                            @auth
                                <span class="name"> <span class="badge badge-pill badge-success">&nbsp;</span> {{  access()->user()->username }}</span>
                            @endauth
                        </div>
                        <i class="fa custom-caret"></i>
                    </a>

                    <div class="dropdown-menu">
                        <ul class="list-unstyled">
                            <li class="divider"></li>
                            <li>
                                <a role="menuitem" tabindex="-1" href="{{ route('user.profile', access()->user()) }}"><i class="fas fa-user"></i> @lang('label.my_profile')</a>
                            </li>
                            <li>
                                {{ Form::open(['route' => 'logout', 'id' => 'logout-form']) }}
                                {{ Form::close() }}
                                <a role="menuitem" tabindex="-1" href="{{ route("logout") }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-power-off"></i> @lang("label.logout") </a>
                            </li>
                        </ul>
                    </div>
                </div>

        @endauth
    </div>
<!-- end: search & user box -->


</header>
