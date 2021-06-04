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
        html,
body {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: 'Prompt', sans-serif;
}


img ,a ,* {
  -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
  user-drag: none;
}
.wrapper {
  min-height: 100%;
  position: relative;
}
/* #header {
  background: #ededed;
  padding: 10px;
}
#content {
  padding-bottom: 100px;
  /* Height of the footer element */
} */
#footer {
  background: #ffab62;
  width: 100%;
  height: 100px;
  position: absolute;
  bottom: 0;
  left: 0;
}
      
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
            /* background-color: MintCream; */
            /* background: rgb(220,244,255); */
            /* background: linear-gradient(90deg, rgba(220,244,255,1) 0%, rgba(255,218,242,1) 50%, rgba(255,228,190,1) 100%); */
            /* font-family: 'Prompt', sans-serif; */
            /* font-size: 20px; */
        }
        /* .wrapper {
            min-height: 100%;
            display: grid;
            grid-template-rows: auto 1fr auto;
        } */
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
        .cropped1 {
            width: 1000px; /* width of container */
            /* height: 325px; height of container */
            height: 100%; /* height of container */
            object-fit: cover;
            /* border: 5px solid black; */
        }
        .cropped {
            width: 100%; /* width of container */
            height: 300px; /* height of container */
            object-fit: cover;
            /* border: 5px solid black; */
        }

            .pics_in_a_row {
            display: flex;
            }

            .img1 { flex: 1.3344; }
            .img2 { flex: 1.3345; }
            .img3 { flex: 0.7505; }
            .img4 { flex: 1.5023; }
            .img5 { flex: 0.75; }

        

        .select_hover:hover
        {
            background-color:LightCyan;
            color: blue;

            /* color: LightCyan; */
        }
        .select_icon_hover:hover
        {
            /* background-color:yellow; */
        }
        .navbar-sticky-top
        {
            position: fixed;
            z-index: 999;
            opacity:1;
            width: 100%;
        }
        .btn-outline-success:hover {
    /* background-color: #5fdf00 !important;
    border-color: #01411C; */
    background: rgb(180,255,91);
    background: radial-gradient(circle, rgba(180,255,91,1) 0%, rgba(220,255,195,1) 100%);
}
.row.display-flex {
  display: flex;
  flex-wrap: wrap;
}
.row.display-flex > [class*='col-'] {
  display: flex;
  flex-direction: column;
}

 /* not requied only for demo * */
.row [class*='col-'] {
  background-colo: #cceeee;
  background-clip: content-box;
}
.panel , .panel-body{
    height: 100%;
}
.card, .card-body{
    height: 100%;
}



#page-container {
  position: relative;
  min-height: 100vh;
}

#content-wrap {
  padding-bottom: 2.5rem;    
  margin-top: 72px;
  /* Footer height */
}

#footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 2.5rem;            
  /* Footer height */
}
#nav-center{
  list-style-type:none;
  display:flex;
  justify-content: center;
}
.nav_hover_head:hover h6{
    color:red;
}
.hvr-underline-from-center:before {
  background: red;
}
.active_nav h6{
    /* border-bottom: 5px solid red;  */
    font-weight: bold;
    color: red;
}
a:hover{
    /* background-color: #7CFC00 !important; */
    text-shadow: 0 0 0.9em #F9629F;
}
#header-wrap {
    background: white;
    position: fixed;
    width: 100%;
    height: auto;
    top: 0;
    z-index: 1;
}

    </style>
    @yield('css')

    
</head>

<body>
<div class="wrapper" id="page-container">
    <!-- Page Preloder -->
     <div id="preloder">
        <div class="loader"></div>
    </div> 

    <!-- Header Section Begin -->
    <header class="header-section" id="header-wrap">
        <nav class="@auth main-header @endauth navbar navbar-expand-md navbar-light  shadow-sm " style="">

            <a class="navbar-brand hvr-grow-shadow pl-3" style="color: black;text-shadow: 0 0 0.9em red" href="{{ url('ebook') }}">
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
                <ul class="nav navbar-nav navbar-center " id="nav-center">
                    <li class="@yield('menu_home_ebook') hvr-underline-from-center nav_hover_head p-3 ml-3 mr-3 " style="color: black;"><a href="{{ url('ebook') }}"><h6>หน้าแรก</h6></a></li>
                    <li class="@yield('menu_products_ebook') hvr-underline-from-center nav_hover_head p-3 ml-3 mr-3" style="color: black;"><a href="{{ url('ebook/productsEbook') }}"><h6>E-Books</h6></a></li>
                    <li class="@yield('menu_my_ebook') hvr-underline-from-center nav_hover_head p-3 ml-3 mr-3" style="color: black;"><a href="{{ url('ebook/myEbook') }}"><h6>My E-Book</h6></a></li>
                    <li class="@yield('menu_order_ebook') hvr-underline-from-center nav_hover_head p-3 ml-3 mr-3" style="color: black;"><a href="{{ url('ebook/order') }}"><h6>รายการสั่งซื้อ</h6></a></li>
                    <li class="@yield('menu_rule_ebook') hvr-underline-from-center nav_hover_head p-3 ml-3 mr-3" style="color: black;"><a href="{{ url('ebook/rule') }}"><h6>กฎกติกา</h6></a></li>
                    <li class="@yield('menu_contact_ebook') hvr-underline-from-center nav_hover_head p-3 ml-3 mr-3" style="color: black;"><a href="{{ url('ebook/contact/create') }}"><h6>ติดต่อเรา</h6></a></li>                
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                
                <li class="nav-depart align-self-center p-2 ml-2 mr-2">
                    <a class="nav-link hvr-underline-reveal" href="{{ route('login') }}" style="color: black">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-depart align-self-center p-2 ml-2 mr-2">
                    <a class="nav-link hvr-underline-reveal" href="{{ route('register') }}" style="color: black">{{ __('Register') }}</a>
                </li>
                @endif
                <!-- <li class="nav-depart">
                    <div class="inner-header">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                
                                
                            </li>
                            <li class="cart-icon ">
                                            
                            </li>
                        </ul>
                    </div>
                </li> -->
                @else
                
                
                <li class="nav-depart dropdown align-self-center p-2" >
                    
                    <a id="navbarDropdown hvr-underline-reveal"  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre style="color: black">
                    {{ Auth::user()->username }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->class_user === "admin") 
                            <a class="dropdown-item hvr-underline-reveal" href="{{ url('admin/dashboard') }}" target="_blank" style="color: black">
                                {{ __('Admin') }}
                            </a>
                        @endif
                    <a class="dropdown-item hvr-underline-reveal" href="{{ url('profile').'/'.Auth::user()->id.'/edit' }} " style="color: black">
                        {{ __('Profile') }}
                    </a>
                    <a class="dropdown-item hvr-underline-reveal" href="{{ route('logout') }}" style="color: black" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    </div>
                </li>
                <li class="nav-depart align-self-center p-2 ">
                    <div class="inner-header">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                
                                
                            </li>
                            <li class="cart-icon ">
                                            
                            </li>
                        </ul>
                    </div>
                </li>
                @endguest
                </ul>
            </div>
        </nav>
    </header>
    <!-- Header End -->
    <div id="content-wrap" >
        @yield('content')
    </div>
    

    <!-- Partner Logo Section Begin -->
    <div class="" id="footer">
        <div class="">
            <div class="container">
                
            </div>
        </div>
        <!-- Partner Logo Section End -->
    
        <!-- Footer Section Begin -->
        <footer class="footer-section" style="background-image: url({{url('images/bg/bg_foot.png')}}) ;background-size: 100% 100%;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">

                        <div class="swiper2 swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=450338&amp;id=450338" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_Light.jpg') }}" width="220"></a></div>
                                <div class="swiper-slide"><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=969867&amp;id=969867" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_SanRuk.jpg') }}" width="220"></a></div>
                                <div class="swiper-slide"><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=1234514&amp;id=1234514" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_KheanFun.jpg') }}" width="220"></a></div>
                                <div class="swiper-slide"><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=1234521&amp;id=1234521" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_KaewChawala.jpg') }}" width="220"></a></div>
                                <div class="swiper-slide"><a href="https://bit.ly/2g4twWY" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Logo-Pann-Final.jpg') }}" width="220"></a></div>
                                <div class="swiper-slide"><a href="http://www.hytexts.com/profile/publisher-lightoflove" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/left/hytexts1.jpg') }}" width="220"></a></div>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>
                        </div>

                    </div>
                    
                    <div class="col-md-12 col-lg-12 " style="padding-top : 20%">
                        <div class="row">
                            <div class="col-md-2 col-lg-2">
                            <div class="footer-widget text-center">
                                <a href="{{ url('ebook') }}" class="hvr-underline-from-center"><h5>หน้าแรก</h5></a>
                            </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="footer-widget text-center">
                                    <a href="{{ url('ebook/productsEbook') }}" class="hvr-underline-from-center"><h5>E-Books</h5></a>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="footer-widget text-center">
                                    <a href="{{ url('ebook/myEbook') }}" class="hvr-underline-from-center"><h5>My E-Books</h5></a>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="footer-widget text-center">
                                    <a href="{{ url('ebook/order') }}" class="hvr-underline-from-center"><h5>รายการสั่งซื้อ</h5></a>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="footer-widget text-center">
                                    <a href="{{ url('ebook/rule') }}" class="hvr-underline-from-center"><h5>กฎกติกา</h5></a>
                                </div>
                            </div>
                            <div class="col-md-2 col-lg-2">
                                <div class="footer-widget text-center">
                                    <a href="{{ url('ebook/contact/create') }}" class="hvr-underline-from-center"><h5>ติดต่อเรา</h5></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                  
                </div>
            </div>
        </footer>
    </div>
    
</div> 
    <!-- Footer Section End -->

   <!-- Js Plugins -->
      <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery-loading/loadingoverlay.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap4.min.js') }}"></script>
    
    {{-- <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script> --}}
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
    {{-- <script type="text/javascript" src="{{ asset('plugins/swiper/js/swiper-bundle.min.js') }}"></script> --}}
    {{-- <!-- <script type="text/javascript" src="{{ asset('plugins/swiper/js/swiper-bundle.js') }}"></script> --> --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- Select2 -->
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script> 
    
    <script type="text/javascript" src="{{ asset('plugins/aos/aos.js') }}"></script>

    <script src="{{ asset('plugins/tilt/tilt.jquery.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('plugins/template-front/js/main.js') }}"></script>
    <!-- <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/jquery.dd.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script> -->

    <script>
    $(function() {
        // $(".js-example-basic-multiple").select2({ 
        //     // width: '100%' ,
        //     width: 'resolve' , 
        //     // dropdownAutoWidth: true ,
        //     // tags: true ,
        //     minimumResultsForSearch: Infinity,  
        //  });
        
        var swiper = new Swiper('.swiper2', {
        slidesPerView: 5,
        spaceBetween: 30,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {

            0:{
                slidesPerView:1
            },
            320: {
                slidesPerView: 2,
            },
            480: {
                slidesPerView: 2,
            },
            640:{
                slidesPerView:3
            },
            960:{
                slidesPerView:5
            },
            1200:{
                slidesPerView:5
            }
         },
        
    });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        AOS.init();
        mini_cart('show','','ebook');  
        mini_heart('show','','ebook');     
        $('.el-tilt').tilt();

        $('body').on('click', '.delete_mini', function() {
            var id_cart = $(this).data('id-cart');
            var id_book = $(this).data('id-book');
            var qua = $(this).data('value');
            var type = $(this).data('type');
            if(type == "ebook"){
                $url = "{{ url('ebook/cart') }}";
            }else{
                $url = "{{ url('cart') }}";
            }
            //alert(id_book)
            mini_cart('delete_mini',id_book ,type).then(
                $.ajax({
                    url: $url ,
                    type: "GET",
                    dataType: 'JSON',
                    cache: false,
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            // console.log(response);
                            // console.log(response.success);
                            $('#html').html(response.html);
                            $('.line-single').html(response.html_total_book_price_all);
                            $('#html_quantity_all').html(response.sum_quantity_all);
                            $(".transport_name").html(response.html_transport);
                            $('.double').html(response.html_total_final);       
                            Swal.fire({
                                position: 'top-end',
                                icon: 'info',
                                title: 'คุณได้ลบสินค้าออกเรียบร้อยแล้วค่ะ',
                                showConfirmButton: false,
                                timer: 800,                     
                            }).then((result) => {
                                mini_cart('show','','ebook');  
                                location.reload()
                            });
                        } 
                    }
                })   
            ); 
            // Swal.fire({
            //     position: 'top-end',
            //     icon: 'info',
            //     title: 'คุณได้ลบสินค้าออกเรียบร้อยแล้วค่ะ',
            //     showConfirmButton: false,
            //     timer: 800,
            // }).then((result) => {
            //     mini_cart('delete_mini',id_book);
            //     $.ajax({
            //         url: "{{ url('cart') }}",
            //         type: "GET",
            //         dataType: 'JSON',
            //         cache: false,
            //         success: (response) => {
            //             if ($.isEmptyObject(response.error)) {
            //                 console.log(response);
            //                 console.log(response.success);
            //                 $('#html').html(response.html);
            //                 $('.line-single').html(response.html_total_book_price_all);
            //                 $('#html_quantity_all').html(response.sum_quantity_all);
            //                 $(".transport_name").html(response.html_transport);
            //                 $('.double').html(response.html_total_final);                  
            //             } 
            //         }
            //     });
            // });
        });

        $('body').on('click', '.delete_mini_heart', function() {
            var id_cart = $(this).data('id-cart');
            var id_book = $(this).data('id-book');
            var type = $(this).data('type') ?? '' ;

            mini_heart('delete_mini_heart',id_book,type).then(
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'คุณได้ลบหนังสือโปรดออกเรียบร้อยแล้วค่ะ',
                    showConfirmButton: false,
                    timer: 800,                       
                }).then(
                    location.reload()
                )
            );         
        });
    });

    const mini_cart = async(fn='',book_id='',type='') => { 
        $.ajax({
            url: "{{ url('mini') }}",
            type: "POST",
            data:{fn:fn , book_id:book_id , type:type},
            dataType: 'JSON',
            cache: false,
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    // console.log(response);
                    // console.log(response.success);
                    $('.cart-icon').html(response.html);
                    
                    //tableupdate();
                } else {
                    console.log(response.error);
                    Swal.fire({
                        icon: 'error',
                        title: "<strong> ERROR </strong>",
                        text: "Error: " + response.error,
                    });
                }
            }
        });
        
    }
    const mini_heart = async(fn='',book_id='',type='') => { 
        $.ajax({
            url: "{{ url('miniHeart') }}",
            type: "POST",
            data:{fn:fn , book_id:book_id,type:type},
            dataType: 'JSON',
            cache: false,
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    // console.log(response);
                    // console.log(response.success);
                    $('.heart-icon').html(response.html);
                    
                    //tableupdate();
                } else {
                    console.log(response.error);
                    Swal.fire({
                        icon: 'error',
                        title: "<strong> ERROR </strong>",
                        text: "Error: " + response.error,
                    });
                }
            }
        });
        
    }
    
    $('.select2').select2({
        multiple: false,
        ajax: { 
          url: "{{ url('/ajaxSelectTwoSearch') }}",
          type: "post",
          dataType: 'json',
          
          delay: 250,
          data: function (params) {
            return {
              
              search: params.term // search term
            };
          },
          processResults: function (response) {
            //console.log(response.blame_product);
            return {
              results: response
            };
          },
          cache: true
        },
        formatResult: function(element){
            return element.text + ' (' + element.id + ')';
        },
        formatSelection: function(element){
            return element.text + ' (' + element.id + ')';
        },
        escapeMarkup: function(m) {
            return m;
        }

    });
    $('#search').on('select2:select', function (e) {
        var data = e.params.data;
        // console.log(data.blame_product);
        if(data.blame_product == "y"){
            window.location = "{{ url('/products/blame/detail') }}"+"/"+data.id ;
        }else{
            window.location = "{{ url('/products/detail') }}"+"/"+data.id ;
        }
        //datatableSearch(data.id);
    });
    

  </script>
    @yield('js')
    
</body>

</html>