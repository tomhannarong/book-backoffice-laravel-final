<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css2?family=Itim&family=Prompt:ital,wght@0,300;1,400&family=Sriracha&display=swap" rel="stylesheet">
      <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />

    <!-- Css Styles -->
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/themify-icons.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/elegant-icons.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/nice-select.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/slicknav.min.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/style.css" type="text/css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" />
    <!-- datatables -->
    <!--
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
    -->
    
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/themify-icons.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/elegant-icons.css') }}" /> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/nice-select.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/slicknav.min.css') }}" />
    <!-- SweetAlert2 -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}" />
  
    <!-- swiper -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/swiper/css/swiper-bundle.css') }}" /> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/swiper/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/magnific-popup/magnific-popup.css') }}" />
    <!-- Select2 -->
   <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/css/select2.min.css') }}" /> 
   <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" /> 
    
   <link rel="stylesheet" type="text/css" href="{{ asset('plugins/hover/hover.css') }}" />
   <link rel="stylesheet" type="text/css" href="{{ asset('plugins/aos/aos.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/style.css') }}" />

    
    <style>
        /* .error {
        color: red;
        border-color: red;
        padding: 1px 20px 1px 20px;
        } */
      
        .center {
            vertical-align: middle;
            justify-content: center; /* align horizontal */
            align-items: center; /* align vertical */
        }
        .centered {
            min-height: 10em;
            display: table-cell;
            vertical-align: middle
        }
        body{
            /* background-color: MintCream;
            background: rgb(220,244,255);
            background: linear-gradient(90deg, rgba(220,244,255,1) 0%, rgba(255,218,242,1) 50%, rgba(255,228,190,1) 100%); */
            font-family: 'Prompt', sans-serif;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 35px;
            height:100% ; 
            border: 2px solid Purple;
        }
        .linear-3 {
            background: rgb(131,58,180);
            background: linear-gradient(90deg, rgba(131,58,180,1) 0%, rgba(253,29,29,1) 50%, rgba(252,176,69,1) 100%);    
        }
        .linear-4 {
            background: rgb(182,255,245);
            background: linear-gradient(90deg, rgba(182,255,245,1) 0%, rgba(255,141,141,1) 50%, rgba(255,197,115,1) 100%);
        }
        .linear-5 {
            background: rgb(255,252,220);
            background: radial-gradient(circle, rgba(255,252,220,1) 0%, rgba(255,113,151,1) 50%, rgba(255,194,145,1) 100%);
        }


        
    </style>
    @yield('css')

    
</head>

<body>
    <!-- Page Preloder -->
     <div id="preloder">
        <div class="loader"></div>
    </div> 

    <!-- Header Section Begin -->
    <header class="header-section">
    <nav class="@auth main-header @endauth navbar navbar-expand-md navbar-light  shadow-sm bg-white" style="">

      <a class="navbar-brand hvr-grow-shadow pl-3" style="color: black;" href="{{ url('/') }}">
        <strong>{{ config('app.name', 'Laravel') }}</strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2"
        aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse " id="navbarSupportedContent2">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
          <li class="nav-depart">
            <a class="nav-link hvr-underline-reveal" href="{{ route('login') }}" style="color: black;">{{ __('Login') }}</a>
          </li>
          @if (Route::has('register'))
          <li class="nav-depart">
            <a class="nav-link hvr-underline-reveal ml-3" href="{{ route('register') }}" style="color: black;">{{ __('Register') }}</a>
          </li>
          @endif
          @else
          <li class="nav-depart dropdown">
            <a id="navbarDropdown hvr-underline-reveal"  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false" v-pre style="color: White;text-shadow: 0 0 0.5em DeepSkyBlue">
              {{ Auth::user()->email }} <span class="caret"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                @if(Auth::user()->class_user === "admin") 
                    <a class="dropdown-item hvr-underline-reveal" href="{{ url('admin/dashboard') }}" target="_blank" style="color: MidnightBlue;text-shadow: 0 0 0.5em DeepSkyBlue">
                        {{ __('Admin') }}
                    </a>
                @endif
              <a class="dropdown-item hvr-underline-reveal" href="{{ url('profile').'/'.Auth::user()->id.'/edit' }} " style="color: MidnightBlue;text-shadow: 0 0 0.5em DeepSkyBlue">
                {{ __('Profile') }}
              </a>
              <a class="dropdown-item hvr-underline-reveal" href="{{ route('logout') }}" style="color: MidnightBlue;text-shadow: 0 0 0.5em DeepSkyBlue" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
          @endguest
        </ul>
      </div>

    </nav>
    </header>
    <!-- Header End -->

    <main class="py-4">
        @yield('content')
    </main>
    

    <!-- Js Plugins -->
      <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery-loading/loadingoverlay.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- datatables -->
<!--    
    <script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
-->
    <!-- <script src="js/jquery-3.3.1.min.js"></script> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <!-- <script src="js/jquery-ui.min.js"></script> -->
    <!-- <script src="js/jquery.countdown.min.js"></script> -->
     <!-- jquery-validation -->
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
      <!-- SweetAlert2 -->
    <script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/template-front/js/jquery.nice-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/template-front/js/jquery.zoom.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/template-front/js/jquery.dd.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/template-front/js/jquery.slicknav.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/template-front/js/owl.carousel.min.js') }}"></script>
    <!-- swiper -->
    <script type="text/javascript" src="{{ asset('plugins/swiper/js/swiper-bundle.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('plugins/swiper/js/swiper-bundle.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- Select2 -->
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script> 
    
    <script type="text/javascript" src="{{ asset('plugins/aos/aos.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/template-front/js/main.js') }}"></script>
    <!-- <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/jquery.dd.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script> -->

    @yield('js')
    
</body>

</html>