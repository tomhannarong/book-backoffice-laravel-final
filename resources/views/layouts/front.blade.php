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

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/template-front/css/style.css?v=2') }}" />

     <!-- Front Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/front.custom.css') }}" />
    <style>
      
      .navbar-nav-custom {
  display: contents;
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
    <header class="header-section">
    

      
<nav class="navbar navbar-expand-md flex-nowrap navbar-light ">
    
    <!-- <div class="navbar-brand"><i class="fas fa-search"></i><input type="text" name="" id=""></div> -->
    <div class="container">
    <a href="/" class="navbar-brand pl-4 "><i class="fas fa-search"></i></a>
    <div class="navbar-nav-custom navbar-collapse"  >
    
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav mr-auto  ">
                            <!-- <li><i class="fas fa-search"></i></li> -->
                            <!-- <li><input type="text" name="" id=""></li> -->                            
                        </ul>
                        <ul class="nav navbar-nav navbar-center " id="nav-center">
                            <li><img src="{{ asset('images/lolb.jpg') }}" alt="" width="100" height="100"></li>
                        </ul>
                      
        
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav ml-auto ">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-depart align-self-center">
                                <div class="inner-header">
                                    <ul class="nav-right">
                                        <li class="heart-icon">
                                            
                                            
                                        </li>
                                        <li class="cart-icon ">
                                                        
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-depart align-self-center">
                                <a class="nav-link hvr-underline-reveal" href="{{ route('login') }}" style="color: White;text-shadow: 0 0 0.5em DeepSkyBlue">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-depart align-self-center">
                                <a class="nav-link hvr-underline-reveal ml-3" href="{{ route('register') }}" style="color: White;text-shadow: 0 0 0.5em DeepSkyBlue">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @else
                            
                            <li class="nav-depart align-self-center">
                                <div class="inner-header">
                                    <ul class="nav-right">
                                        <li class="heart-icon">
                                            
                                            
                                        </li>
                                        <li class="cart-icon ">
                                                        
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-depart dropdown align-self-center" >
                                
                                <a id="navbarDropdown hvr-underline-reveal"  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre style="color: White;text-shadow: 0 0 0.5em DeepSkyBlue">
                                {{ Auth::user()->username }} <span class="caret"></span>
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
            </div>
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbar2">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<nav class="navbar navbar-expand-md">
    <div class="container-fluid">
        <div class="navbar-collapse collapse pt-2 pt-md-0 justify-content-center" id="navbar2">
                <ul class="nav navbar-nav navbar-center " id="nav-center">
                    <li class="nav_col"><a href="{{ url('/') }}" class="nav_col_text">HOME</a></li>
                    <li class="nav_col"><a href="{{ url('products') }}" class="nav_col_text">BOOKSTORE</a></li>
                    <li class="nav_col"><a href="{{ url('ebook') }}" class="nav_col_text" target="_blank">E-BOOK</a></li>
                    <li class="nav_col"><a href="{{ url('order') }}" class="nav_col_text">ACTIVITY</a></li>
                    <li class="nav_col"><a href="{{ url('contact/create') }}" class="nav_col_text">BLOG</a></li>     
                    <li class="nav_col"><a href="{{ url('contact/create') }}" class="nav_col_text">PROMOTION</a></li>     
                    <li class="nav_col"><a href="{{ url('contact/create') }}" class="nav_col_text">CONTACT US</a></li>                                  
                </ul>

        </div>
    </div>
</nav>
<div class="sidepanel">
    <div class="headerSideRight">
        <div class="d-inline ">
            <a href="javascript:void(0)" id="" class="headerIconBackMini sideSwitch"><i class="fa fa-chevron-left"></i></a>            
        </div>
        <div class="d-inline ">
            <font class="headerTextMini">ตระกร้าของฉัน</font>
        </div>
        <div class="d-inline float-right">
            <i class="fas fa-shopping-bag headerIconBagMini"></i>
        </div>
    </div>
  <div class="line"></div>
  <div class="circle">
    <!-- <i class="fa fa-chevron-left marginChevronLeftStyle" aria-hidden="true"></i>
    <i class="fa fa-chevron-right marginChevronRightStyle hide" aria-hidden="true"></i>   -->
    <i class="fas fa-shopping-cart" aria-hidden="true"></i>
  </div>
</div>

        
        
    </header>
    <!-- Header End -->
    <div id="content-wrap">
        @yield('content')
    </div>
    

    <!-- Partner Logo Section Begin -->
    <div class="" id="footer">
        <div class="partner-logo">
            <div class="container">
                <div class="logo-carousel owl-carousel">
                    <div class="logo-item">
                        <div class="tablecell-inner">
                        <p><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=450338&amp;id=450338" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_Light.jpg') }}" width="220"></a></p>
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                        <p><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=969867&amp;id=969867" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_SanRuk.jpg') }}" width="220"></a></p>
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                        <p><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=1234514&amp;id=1234514" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_KheanFun.jpg') }}" width="220"></a></p>
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                        <p><a href="https://www.mebmarket.com/index.php?action=Publisher&amp;publisher_id=1234521&amp;id=1234521" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Meb_KaewChawala.jpg') }}" width="220"></a></p>
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                        <p><a href="https://bit.ly/2g4twWY" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/Logo-Pann-Final.jpg') }}" width="220"></a></p>
                        </div>
                    </div>
                    <div class="logo-item">
                        <div class="tablecell-inner">
                        <p><a href="http://www.hytexts.com/profile/publisher-lightoflove" class="hvr-pulse-shrink" target="_blank"><img src="{{ asset('images/left/hytexts1.jpg') }}" width="220"></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Partner Logo Section End -->
    
        <!-- Footer Section Begin -->
        <footer class="footer-section">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-2">
                        <div class="footer-widget text-center">
                            <a href="{{ url('/') }}" class="hvr-underline-from-center"><h5>หน้าแรก</h5></a>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="footer-widget text-center">
                            <a href="{{ url('/products') }}" class="hvr-underline-from-center"><h5>สินค้าทั้งหมด</h5></a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer-widget text-center">
                            <a href="{{ url('/products/blame') }}" class="hvr-underline-from-center"><h5>สินค้ามือหนึ่งสภาพเก่า</h5></a>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="footer-widget text-center">
                            <a href="{{ url('/products/serie') }}" class="hvr-underline-from-center"><h5>ซีรีส์ชุด</h5></a>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="footer-widget text-center">
                            <a href="{{ url('/products/buffet') }}" class="hvr-underline-from-center"><h5>บุฟเฟ่ต์</h5></a>
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
    {{-- <script type="text/javascript" src="{{ asset('plugins/swiper/js/swiper-bundle.min.js') }}"></script> --}}
    {{-- <!-- <script type="text/javascript" src="{{ asset('plugins/swiper/js/swiper-bundle.js') }}"></script> --> --}}
    
    <script type="text/javascript" src="{{ asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <!-- Select2 -->
    <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script> 
    
    <script type="text/javascript" src="{{ asset('plugins/aos/aos.js') }}"></script>

    <script src="{{ asset('plugins/tilt/tilt.jquery.min.js') }}" type="text/javascript"></script>

    <script type="text/javascript" src="{{ asset('plugins/template-front/js/main.js?v=2') }}"></script>
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
        
        $(document).on('click', '.circle , .sideSwitch', function () {
            let spWidth = $('.sidepanel').width();
            let spMarginRight = parseInt($('.sidepanel').css('margin-right'),10);
            let w = (spMarginRight >= 0 ) ? spWidth * -1 : 0;
            let cw = (w < 0) ? -w : spWidth-22;
            $('.sidepanel').animate({
                marginRight:w
            });
            $('.sidepanel span').animate({
                marginRight:w
            });
            $('.circle').animate({
                right:cw
            },function() {
                $('.marginChevronLeftStyle').toggleClass('hide');
                $('.marginChevronRightStyle').toggleClass('hide');
            });
        });
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        AOS.init();
        mini_cart('show','','book');  
        mini_heart('show','','book');     
        $('.el-tilt').tilt();

        $('body').on('click', '.delete_mini', function() {
            var id_cart = $(this).data('id-cart');
            var id_book = $(this).data('id-book');
            var qua = $(this).data('value');
            var type = $(this).data('type');
            //alert(id_book)
            mini_cart('delete_mini',id_book ,type).then(
                $.ajax({
                    url: "{{ url('cart') }}",
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