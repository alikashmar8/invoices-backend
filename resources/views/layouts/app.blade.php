<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Sync is a mobile app ...">
    <meta name="author" content="WebSide.com.au">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- fa fas -->
    <!link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <!-- OG Meta Tags to improve the way the post looks when you share the page on LinkedIn, Facebook, Google+ -->
	<meta property="og:site_name" content="" /> <!-- website name -->
	<meta property="og:site" content="" /> <!-- website link -->
	<meta property="og:title" content=""/> <!-- title shown in the actual shared post -->
	<meta property="og:description" content="" /> <!-- description shown in the actual shared post -->
	<meta property="og:image" content="" /> <!-- image link, make sure it's jpg -->
	<meta property="og:url" content="" /> <!-- where do you want your post to link to -->
	<meta property="og:type" content="article" />

    <!-- Webpage Title -->
    <title>@yield('title') | Sync</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/fontawesome-all.css')}}" rel="stylesheet">
    <link href="{{asset('css/swiper.css')}}" rel="stylesheet">
	<link href="{{asset('css/magnific-popup.css')}}" rel="stylesheet">
	<link href="{{asset('css/styles.css')}}" rel="stylesheet">

	<!-- Favicon  -->
    <link rel="icon" href="{{asset('images/favicon.png')}}">

    <style>
    .wbsd-notification {
        position:fixed;
        left: 40px;
        top: 60px;
        z-index: 15;
        animation: notification-opacity forwards;
        animation-delay: 3s;
        animation-duration: 2s;

    }

    @keyframes notification-opacity {
        from {opacity: 1;}
        to {opacity: 0;}
    }
    </style>


</head>
<body data-spy="scroll" data-target=".fixed-top">

    <!-- Preloader -->
	<div class="spinner-wrapper">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>
    <!-- end of preloader -->
    @php
        $currentURL = "{$_SERVER['REQUEST_URI']}" ;
    @endphp

    <div class=" wbsd-notification">
    @if(session()->has('messageSuc'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('messageSuc') }}
        </div>
    @elseif(session()->has('messageDgr'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('messageDgr') }}
        </div>
    @elseif(session()->has('messageWrg'))
        <div class="alert alert-warning" role="alert">
            {{ session()->get('messageWrg') }}
        </div>
    @elseif(session()->has('messageInf'))
        <div class="alert alert-info" role="alert">
            {{ session()->get('messageInf') }}
        </div>
    @endif
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top" >
        <div class="container">
            <!-- Text Logo - Use this if you don't have a graphic logo -->
            <!-- <a class="navbar-brand logo-text page-scroll" href="index.html">Sync</a> -->

            <!-- Image Logo -->
            <a class="navbar-brand logo-image" href="/"><img src="{{asset('images/logo.svg')}}" alt="alternative"></a>

            <!-- Mobile Menu Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-awesome fas fa-bars"></span>
                <span class="navbar-toggler-awesome fas fa-times"></span>
            </button>
            <!-- end of mobile menu toggle button -->

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-auto">

                    @guest

                        <li class="nav-item">
                            <a class="nav-link page-scroll @if( str_contains( $currentURL , '/description' )) active @endif" href="/#description">DESCRIPTION <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link page-scroll @if( str_contains( $currentURL , '/features' )) active @endif" href="/#features">FEATURES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link page-scroll @if( str_contains( $currentURL , '/screens' )) active @endif" href="/#screens">SCREENS</a>
                        </li>

                        <li class="nav-item px-2">
                        &nbsp;
                        </li>
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link @if( str_contains( $currentURL , '/login' )) active @endif" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link @if( str_contains( $currentURL , '/register' )) active @endif" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif

                        <!-- Dropdown Menu ->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle page-scroll" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">EXTRA</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="article-details.html"><span class="item-text">ARTICLE DETAILS</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="terms-conditions.html"><span class="item-text">TERMS CONDITIONS</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="privacy-policy.html"><span class="item-text">PRIVACY POLICY</span></a>
                            </div>
                        </li>
                        <!-- end of dropdown menu -->

                    @else
                        <li class="nav-item">
                            <a class="nav-link page-scroll @if( str_contains( $currentURL , '/profile' )) active @endif" href="/profile/{{Auth::user()->id}}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link page-scroll @if( str_contains( $currentURL , '/my-businesses' )) active @endif" href="/my-businesses">Businesses <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link page-scroll "  href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                        {{--<!-- Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle page-scroll" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/profile/{{Auth::user()->id}}">
                                    <span class="item-text">Profile</span>
                                </a>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item"  href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    <span class="item-text">
                                        {{ __('Logout') }}
                                    </span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="privacy-policy.html"><span class="item-text">PRIVACY POLICY</span></a>
                            </div>
                        </li>
                        <!-- end of dropdown menu -->--}}

                    @endguest


                </ul>
                <span class="nav-item">
                    @guest
                    <a class="btn-outline-sm page-scroll" href="/#download">DOWNLOAD</a>
                    @else
                    <a class="btn-outline-sm page-scroll" href="/newInvoice">Submit Invoice</a>
                    @endguest
                </span>
            </div>
        </div> <!-- end of container -->
    </nav> <!-- end of navbar -->
    <!-- end of navigation -->

    <main  style=" margin-top:7rem ">
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- Scripts -->
    <script src="{{asset('js/jquery.min.js')}}"></script> <!-- jQuery for Bootstrap's JavaScript plugins -->
    <script src="{{asset('js/popper.min.js')}}"></script> <!-- Popper tooltip library for Bootstrap -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script> <!-- Bootstrap framework -->
    <script src="{{asset('js/jquery.easing.min.js')}}"></script> <!-- jQuery Easing for smooth scrolling between anchors -->
    <script src="{{asset('js/swiper.min.js')}}"></script> <!-- Swiper for image and text sliders -->
    <script src="{{asset('js/jquery.magnific-popup.js')}}"></script> <!-- Magnific Popup for lightboxes -->
    <script src="{{asset('js/validator.min.js')}}"></script> <!-- Validator.js - Bootstrap plugin that validates forms -->
    <script src="{{asset('js/scripts.js')}}"></script> <!-- Custom scripts -->
</body>
</html>
