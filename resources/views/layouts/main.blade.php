<!DOCTYPE html>
@auth
    @if(Auth::user()->hasRole(1) || Auth::user()->hasRole(2))
    <html class="fixed sidebar-left-sm">
    {{--<html class="fixed">--}}
    {{-- sidebar-left-collapsed  sidebar-left-big-icons left-sidebar-panel --}}
    @endif

    @endauth

    @guest
        <html class="fixed has-top-menu">
        {{--<html class="fixed">--}}
        @endguest
        <head>
            {{--<!-- Basic -->--}}
            <meta charset="UTF-8">

            <title>{{ config("app.name") . " - " . $title }}</title>
            <meta name="keywords" content="{{ config("env.app.keywords") }}" />
            <meta name="description" content="{{ config("env.app.description") }}">
            <meta name="author" content="{{ config("env.app.vendor") }}">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
            <meta name="csrf-token" content="{{ csrf_token() }}">
            {{ Html::style(url("img/np_fav.png"), ['rel' => 'stylesheet icon', 'type' => 'image/x-icon']) }}

            @stack('before-styles')

            {{ Html::style(url("/css/fonts.googleapis.css"), ['rel' => 'stylesheet', 'type' => 'text/css']) }}

            {{ Html::style(url('vendor/bootstrap/css/bootstrap.min.css')) }}
            {{ Html::style(url('vendor/animate/animate.css')) }}
            {{ Html::style(url('vendor/font-awesome/css/fontawesome-all.min.css')) }}
            {{ Html::style(url('vendor/magnific-popup/magnific-popup.css')) }}
            {{ Html::style(url('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')) }}
            {{ Html::style(url("assets/nextbyte/plugins/jquery-ui/css/jquery-ui.min.css"), ['rel' => 'stylesheet']) }}
            @stack('after-styles')
            {{ Html::style(url('css/theme.css')) }}
            {{ Html::style(url('css/theme-elements.css')) }}
            {{ Html::style(url('css/skins/default.css')) }}
            {{ Html::style(url('css/custom.css')) }}
            {{ Html::style(url('vendor/select2/css/select2.min.css')) }}

            {{ Html::script(url('vendor/modernizr/modernizr.js')) }}

            {{--STart notification css--}}
            {{--{{ Html::style(asset_url() . "/nextbyte/plugins/AmaranJS/dist/css/amaran.min.css") }}--}}
            {{--{{ Html::style(asset_url() . "/nextbyte/plugins/AmaranJS/dist/css/animate.min.css") }}--}}
            {{--end notification css--}}
            @stack('custom')

            <style>
                .required_asterik:after {
                    content: '*';
                    color: red;
                    padding-left: 5px;
                }
                .hidden_fields {
                    display: none;
                }
            .image_container
            {
                top:0;
                background-size: cover;
                width:100%;
                position: relative;
            }
            .text_container{
                position:absolute;
                bottom: 0;
                background:rgb(0 ,0 ,0);
                background:rgba(0,0,0,0.5);
                width: 100%;
                padding: 20px;
                color:#f1f1f1;
            }
            *{
                box-sizing: border-box;
            }
            .announcement_container{
                width:100%;
                background-color:dodgerblue;
                opacity: 0.5;
                color:#f1f1f1;
                top: -50px;
                text-align: center;
                /*bottom:40px;*/
                position:relative;
                padding:20px;
            }
            .imageBackground{
                width:100%;
                height: 60%;
            }
            .home-photo{
                width:100%;
                height: 60%;
                border-radius: 5%;
            }
            .container_blog{
                width:100%;
                padding-left: 50px;
                border-radius: 20%;
            }
            .logo{
                width:50px;
                height:50px;
            }

            .blog_image{
                width: 100%;
                height:230px;
            }

            .search{
                width: 70%;
                padding-left:0;
            }
            .star{
                color: grey;
            }
            .checked{
                color:dodgerblue;
            }
            .text{
                text-align: center;
            }
            .topic{
                text-align: center;
                text-decoration: none;
                color:gray;
                font-weight:bolder;
            }
            .end_contents{
                text-align: center;
            }
            .logo_display{
                width:100px;
                height:100px;
                border-radius: 50%;
            }
            .heading{
                padding-left:10px;
                color:black;
            }
            .description{
                color: gray;
                overflow: hidden;
                text-align: center;
            }
           .showContent p{
               height: auto;
           }
           .showContent a.read-more-btn{
               background-color: red;
           }
            .honey_point_image{
                transition: 1s;
                box-shadow: 0 2px 2px 0 gainsboro;

            }
            .honey_point_image:hover{
                transition: 1s;
                transform: scale(1.1);
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            }

                .user{
                    display:flex;
                    height:40px;
                    border-bottom: 1px solid gainsboro;
                }
                .social-images{
                    width:40px;
                    height:40px;
                    transition:1s;
                }
                .social-images:hover{
                    transform:scale(1.5);
                }
                .gateway-images{
                    border-radius: 20%;
                    border: 2px solid gainsboro;
                    width:60px;
                    height:60px;
                    transition:1s;
                    padding: 10px;
                    margin-left: 10px;
                }
                .gateway-images:hover{
                    transform:scale(1.5);
                }
                .team-photo
                {
                    width:100%;
                    height:50%;
                }
                .logo
                {
                    width:40px;
                    height:40px;
                }
                .post-container{
                    opacity:1;
                    transition: 0.5s;
                    box-shadow: 0 2px 2px 0 gainsboro;
                }
                .post-container:hover{
                    transition: 0.5s;
                    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                }
                .account-container{
                    opacity:1;
                    transition: 0.5s;
                    box-shadow: 0 2px 2px 0 gainsboro;
                }
                .account-container:hover{
                    transition: 0.5s;
                    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                }
                .head{
                    text-align: center;
                    font-size: 12px;
                    font-weight: bolder;
                }


             .blog-bottom{
                 padding-top: 10px;
             }
             #content{
                 position: fixed;
                 display: none;
                 width: 100%;
                 height:100%;
                 top:0;
                 left:0;
                 right:0;
                 bottom:0;
                 background-color:rgba(0,0,0,0.5);
                 z-index:2;
                 cursor:pointer;
             }
                #text{
                    position: absolute;
                    top: 15%;
                    left: 50%;
                    font-size: 40px;
                    color: white;
                    transform: translate(-50%,-50%);
                    -ms-transform: translate(-50%,-50%);
                }
                .features{
                    cursor: pointer;
                    font-size:15px;
                }
                .message_container{
                    position:absolute;
                    align-content: center;
                    top: 50px;
                    background:rgb(0 ,0 ,0);
                    background:rgba(0,0,0,0.4);
                    width: 70%;
                    padding: 30px;
                    color:#f1f1f1;
                    margin-left: 12%;
                    text-align: center;
                }
                .search-bar{
                    float:right;
                    margin-right: 100px;
                }
                .disabled{
                    pointer-events: none;
                }
                .switch {
                    position: relative;
                    display: inline-block;
                    width: 60px;
                    height: 34px;
                }

                .switch input {
                    opacity: 0;
                    width: 0;
                    height: 0;
                }

                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #ccc;
                    -webkit-transition: .4s;
                    transition: .4s;
                }

                .slider:before {
                    position: absolute;
                    content: "";
                    height: 26px;
                    width: 26px;
                    left: 4px;
                    bottom: 4px;
                    background-color: white;
                    -webkit-transition: .4s;
                    transition: .4s;
                }

                input:checked + .slider {
                    background-color: #2196F3;
                }

                input:focus + .slider {
                    box-shadow: 0 0 1px #2196F3;
                }

                input:checked + .slider:before {
                    -webkit-transform: translateX(26px);
                    -ms-transform: translateX(26px);
                    transform: translateX(26px);
                }

                /* Rounded sliders */
                .slider.round {
                    border-radius: 34px;
                }

                .slider.round:before {
                    border-radius: 50%;
                }
            </style>


        </head>
        <body>

        @if(Auth::check())

        <section class="content-body">

            @include("includes/components/header")

            <div class="inner-wrapper">

                @auth
                    @include('includes/components/left_sidebars/index')
                @endauth

                @if(Auth::user()->hasRole(3))
                    {{--This is for the account type for only tourists--}}
                <section role="main" class="content-body">


                    {{--Hide header on home page--}}
                    @if(Auth::check())

                        @if(Auth::user()->hasRole(1) || Auth::user()->hasRole(2))
                    <header  class="page-header " style="background-color:#32464a">
                        <h2>{{ $header }}</h2>
                        <div style="margin-right: 10px"  class="right-wrapper text-right">
                            {{ Breadcrumbs::render() }}
                        </div>
                    </header>
                        @endif
                    @else
                        <header  class="page-header " style="background-color:#32464a">

                        </header>
                    @endif


                    {{--@include("includes/ads/top_advert")--}}

                    @include("includes.partials.messages")
                    @yield('content')



                </section>
<!--                    section for the tourists ends here-->

<!--                    This section is for other account type in the system-->
                    @else
                        <section role="main" class="content">


                            {{--Hide header on home page--}}
                            @auth
                                @if(Auth::user()->hasRole(1) || Auth::user()->hasRole(2))
                                    <header  class="page-header " style="background-color:#32464a">
                                        <h2>{{ $header }}</h2>
                                        <div style="margin-right: 10px"  class="right-wrapper text-right">
                                            {{ Breadcrumbs::render() }}
                                        </div>
                                    </header>
                                @endif
                            @endauth


                            {{--@include("includes/ads/top_advert")--}}
                             @include("includes.partials.messages")
                            @yield('content')



                        </section>
<!--                    Section for other accounts types ends here-->
                    @endif


            </div>
            {{--@guest--}}
            @include("includes/components/footer")
            {{--@endguest--}}



        </section>

        @else

        <section class="content">

            @include("includes/components/header")

            <div class="inner-wrapper">

                @auth
                    @include('includes/components/left_sidebars/index')
                @endauth

                <section role="main">


                    {{--Hide header on home page--}}
                    @auth
                        @if(Auth::user()->hasRole(1) || Auth::user()->hasRole(2))
                    <header  class="page-header " style="background-color:#32464a">
                        <h2>{{ $header }}</h2>
                        <div style="margin-right: 10px"  class="right-wrapper text-right">
                            {{ Breadcrumbs::render() }}
                        </div>
                    </header>
                        @endif
                    @endauth


                    {{--@include("includes/ads/top_advert")--}}

{{--                    @include("includes.partials.messages")--}}


                    @yield('content')



                </section>

            </div>
            {{--@guest--}}
            @include("includes/components/footer")
            {{--@endguest--}}



        </section>
        @endif

        <script>
            var base_url = "{{ url("/") }}";
        </script>
        {{--<!-- Scripts -->--}}
        @stack('before-scripts')
        {{ Html::script(url('vendor/jquery/jquery.js')) }}
        {{ Html::script(url('assets/nextbyte/plugins/jquery-ui/js/jquery-ui.min.js')) }}
        {{ Html::script(url('vendor/jquery-browser-mobile/jquery.browser.mobile.js')) }}
        {{ Html::script(url('vendor/popper/umd/popper.min.js')) }}
        {{ Html::script(url('vendor/bootstrap/js/bootstrap.min.js')) }}
        {{ Html::script(url('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')) }}
        {{ Html::script(url('vendor/common/common.js')) }}
        {{ Html::script(url('vendor/nanoscroller/nanoscroller.js')) }}
        {{ Html::script(url('vendor/magnific-popup/jquery.magnific-popup.min.js')) }}
        {{ Html::script(url('vendor/jquery-placeholder/jquery-placeholder.js')) }}
        <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5bdc6737afad5b00117c870d&product=inline-share-buttons' async='async'></script>
        @stack('after-scripts')
        {{ Html::script(url('js/theme.js')) }}
        {{--{{ Html::script(url('js/custom.js')) }}--}}
        {{ Html::script(url('js/theme.init.js')) }}
        {{ Html::script(url('vendor/select2/js/select2.min.js')) }}
        {{ Html::script(url('js/share.js')) }}
        {{ Html::script(url('assets/nextbyte/plugins/maskmoney/js/maskmoney.min.js')) }}
        {{ Html::script(url('vendor/jquery-maskedinput/jquery.maskedinput.js')) }}
        {{ Html::script(url('assets/nextbyte/js/custom.js')) }}
        {{--STart - Notification--}}
        {{--{{ Html::script(asset_url(). "/global/plugins/AmaranJS/dist/js/jquery.amaran.min.js") }}--}}
        {{--End notification--}}
        <script>
            $(document).ready(function () {

                $('.mobile').mask("9999999999");

            })
        </script>

        </body>
        </html>
