<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Itim&family=Prompt:ital,wght@0,300;1,400&family=Sriracha&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}" />
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/adminlte.css') }}" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" />
  <!-- Select2 -->
   <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/css/select2.min.css') }}" /> 
   <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" /> 
  <!-- SweetAlert2 -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') }}" />
  <!-- bootstrap4-toggle -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap4-toggle/bootstrap4-toggle.min.css') }}" />

  <!-- datatables -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

  <!-- App Custom CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.custom.css') }}" />


  <style>






  </style>
  @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed ">
  <div id="app" class="wrapper">
    
    <nav class="@auth main-header @endauth navbar navbar-expand-md navbar-light bg-color-custom"> 
    <!-- shadow-sm -->
      @auth
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <img src="{{ url('img/icon-header-app/hamberger.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
      <!-- <i class="fas fa-hamburger fa-2x" style="color:black"></i> -->
      </a>
      @endauth
      <!-- <a class="navbar-brand pl-3" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
      </a> -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2"
        aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse " id="navbarSupportedContent2">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto justify-content-center">
          <!-- Authentication Links -->
          @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          @if (Route::has('register'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
          </li>
          @endif
          @else
          <li class="nav-item pt-2">
            <a class="nav-link " href="{{ route('register') }}"><i class="fas fa-shopping-bag fa-lg"></i></a>
          </li>
          <li class="nav-item pt-2">
            <a class="nav-link " href="{{ route('register') }}"><i class="far fa-comment-alt fa-flip-horizontal fa-lg"></i></a>
          </li>
          <li class="nav-item dropdown justify-content-center">            
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false" v-pre>
              <img src="{{ asset('storage/profile-uploads/'.Auth::user()->avatar) }}" width="40px" height="40px" class="rounded" style="background-color:white;object-fit: cover;">
              <font class="header_title_name p-2">{{ Auth::user()->name }}</font>     
              <!-- <span class="caret rounded" style="background-color:red"></span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ url('profile/'.Auth::user()->id.'/edit') }}">
                {{ __('Profile') }}
              </a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
    <nav class="main-header-dummy navbar navbar-expand-md "> 
      <!-- shadow-sm -->
      @auth
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <img src="{{ url('img/icon-header-app/hamberger.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
      <!-- <i class="fas fa-hamburger fa-2x" style="color:black"></i> -->
      </a>
      @endauth
    </nav>

    @auth
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('images/lolb.jpg') }}" alt="{{ config('app.name', 'Laravel') }}" class="brand-image img-circle elevation-3 "
          style="opacity: .8">
        <span class="brand-text font-weight-light ">{{ config('app.name', 'Laravel') }}</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
      

        <!-- Sidebar Menu -->
        
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
            <li class="nav-item">
              <a href="{{ route('dashboard') }}" class="nav-link text-white @yield('menu_dashboard')">
                <!-- <i class="nav-icon fas fa-tachometer-alt"></i> -->
                <img src="{{ url('img/icon-header-app/dashboard.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                <p>
                  Dashboard
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>
            <li class="nav-header">Products Menu</li>
            <li class="nav-item  @yield('menu_product_menu_open')">
              <a href="#" class="nav-link @yield('menu_product_menu_open_active')">
                <!-- <i class="nav-icon fas fa-book"></i> -->
                <img src="{{ url('img/icon-header-app/books.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                <p>
                  Books 
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('products.create') }}" class="nav-link @yield('menu_add_product') paddingLeftSlideBar">
                    <img src="{{ url('img/icon-header-app/add_book.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">                     
                    <p>Add Book</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('products.index') }}" class="nav-link @yield('menu_product') paddingLeftSlideBar">
                    <img src="{{ url('img/icon-header-app/book_products.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <p>Book Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('stock.index') }}" class="nav-link @yield('menu_stock') paddingLeftSlideBar">
                    <img src="{{ url('img/icon-header-app/stock_products.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <p>Stock Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('bestSeller.index') }}" class="nav-link @yield('menu_best_seller') paddingLeftSlideBar">
                    <img src="{{ url('img/icon-header-app/book_best_seller.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <p>Books Best Seller</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('preProducts.index') }}" class="nav-link @yield('menu_pre_product') paddingLeftSlideBar">
                    <img src="{{ url('img/icon-header-app/pre_products.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <p>Pre-Products</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item @yield('menu_product_ebooks_menu_open')">
              <a href="#" class="nav-link @yield('menu_product_ebooks_menu_open_active')">
                <!-- <i class="nav-icon fas fa-book-reader"></i> -->
                <img src="{{ url('img/icon-header-app/ebooks.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                <p>
                  E-Books
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('productsEbook.create') }}" class="nav-link @yield('menu_add_product_ebooks') paddingLeftSlideBar">
                    <i class="fas fa-plus nav-icon"></i>
                    <p>Add E-Book</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('productsEbook.index') }}" class="nav-link @yield('menu_product_ebooks') paddingLeftSlideBar">
                  <i class="fab fa-product-hunt nav-icon"></i>
                    <p>E-Book Products</p>
                  </a>
                </li>
                
                {{-- <li class="nav-item">
                  <a href="{{ route('bestSeller.index') }}" class="nav-link @yield('menu_best_seller')">
                    <i class="fas fa-dollar-sign nav-icon"></i>
                    <p>E-Books Best Seller</p>
                  </a>
                </li> --}}
                
              </ul>
            </li>

            <li class="nav-header">Order Master Menu</li>
            <li class="nav-item menu-open @yield('menu_order_open')">
              <a href="#" class="nav-link @yield('menu_order_open_active')">
                <img src="{{ url('img/icon-header-app/bag.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                <!-- <i class="nav-icon fas fa-box-open"></i> -->
                <p>
                  Customer Order
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item nav-item-sub">
                  <a href="{{ url('admin/order/status/check') }}" class="nav-link @yield('menu_order_check') paddingLeftSlideBar">
                  <img src="{{ url('img/icon-header-app/time.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <!-- <i class="nav-icon fas fa-receipt"></i> -->
                    <p>
                      รอตรวจสอบสลิป
                      <span class="right badge badge-danger noti-order noti-order-check">0</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item nav-item-sub">
                  <a href="{{ url('admin/order/status/paid') }}" class="nav-link @yield('menu_order_paid') paddingLeftSlideBar">
                  <img src="{{ url('img/icon-header-app/car.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <!-- <i class="nav-icon fas fa-receipt"></i> -->
                    <p>
                      รอการจัดส่ง
                      <span class="right badge badge-danger noti-order noti-order-success">0</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item nav-item-sub">
                  <a href="{{ url('admin/approve') }}" class="nav-link @yield('menu_order_ebook_approve') paddingLeftSlideBar">
                  <img src="{{ url('img/icon-header-app/wait_approve.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2" style="opacity: 1;"> 
                    <!-- <i class="nav-icon fas fa-receipt"></i> -->
                    <p >
                      รออนุมัติ E-Book
                      <span class="right badge badge-danger noti-order noti-order-wait-approve">0</span>
                    </p>
                  </a>
                </li>
              </ul>

<!-- 
            <li class="nav-item">
              <a href="{{ route('order.index') }}" class="nav-link @yield('menu_order')">
                
                <p>Customer Order</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('payInSlip.index') }}" class="nav-link @yield('menu_pay_in_slip')">
                
                <p>Pay-in Slip</p>
                <span class="right badge badge-danger"></span>
              </a>
            </li> -->
            <li class="nav-header">Member Menu</li>
            <li class="nav-item @yield('menu_member_menu_open')">
              <a href="#" class="nav-link @yield('menu_member_menu_open_active')">
                <!-- <i class="nav-icon fas fa-users-cog"></i> -->
                <img src="{{ url('img/icon-header-app/members.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                
                <p>
                  Members
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('member.create') }}" class="nav-link @yield('menu_add_member') paddingLeftSlideBar">
                    <i class="fas fa-user-plus nav-icon"></i>
                    <p>Add Members</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('member.index') }}" class="nav-link @yield('menu_member') paddingLeftSlideBar">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Members</p>
                  </a>
                </li>
              </ul>
            <li class="nav-item">
                <a href="{{ url('admin/contact') }}" class="nav-link @yield('menu_contact')">
                  <!-- <i class="fas fa-file-signature nav-icon"></i> -->
                  <img src="{{ url('img/icon-header-app/contact.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                  <p>Contact</p>
                </a>
                </li>
            </li>
            <li class="nav-header">Category Menu</li>
            <li class="nav-item">
              <a href="{{ route('publisher.index') }}" class="nav-link @yield('menu_publisher')">
                <img src="{{ url('img/icon-header-app/publisher.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Publisher</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('bookCategory.index') }}" class="nav-link @yield('menu_book_type')">
                <img src="{{ url('img/icon-header-app/book_category.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Book Category</p>
              </a>
            </li>
            <li class="nav-item @yield('menu_ebook_consignment_open')">
              <a href="#" class="nav-link @yield('menu_ebook_consignment_open_active')">
                <!-- <i class="nav-icon fas fa-users-cog"></i> -->
                <img src="{{ url('img/icon-header-app/ebook_consignment.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                
                <p>
                  E-Book Consignment
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('ebookConsignment.index') }}" class="nav-link @yield('menu_ebook_consignment') paddingLeftSlideBar">
                    <img src="{{ url('img/icon-header-app/time.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <p>รออนุมัติฝากขาย
                    <span class="right badge badge-danger noti-order noti-order-success">0</span>
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('member.index') }}" class="nav-link @yield('menu_member') paddingLeftSlideBar">
                    <img src="{{ url('img/icon-header-app/time.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2"> 
                    <p>รออนุมัติแก้ไขฝากขาย
                    <span class="right badge badge-danger noti-order noti-order-success">0</span>
                    </p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="{{ route('transport.index') }}" class="nav-link @yield('menu_transport')">
                <img src="{{ url('img/icon-header-app/transport.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Transport</p>
              </a>
            </li>

            <li class="nav-header">Promotion & Payment</li>

            <li class="nav-item">
              <a href="{{ route('discount.index') }}" class="nav-link @yield('menu_discount')">
                <img src="{{ url('img/icon-header-app/discount.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Discount</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('buffet.index') }}" class="nav-link @yield('menu_buffet')">
                <img src="{{ url('img/icon-header-app/buffet.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Buffet</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('payment.index') }}" class="nav-link @yield('menu_payment')">
                <img src="{{ url('img/icon-header-app/payment.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Payment</p>
              </a>
            </li>

            <li class="nav-header">Settings & Privacy</li>

            <li class="nav-item">
              <a href="{{ route('slide.index') }}" class="nav-link @yield('menu_slide')">
                <img src="{{ url('img/icon-header-app/slide.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Slide</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('news.index') }}" class="nav-link @yield('menu_news')">
                <img src="{{ url('img/icon-header-app/news.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>News</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('board.index') }}" class="nav-link @yield('menu_board')">
                <img src="{{ url('img/icon-header-app/webboard.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Webboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('privacy.index') }}" class="nav-link @yield('menu_privacy')">
                <img src="{{ url('img/icon-header-app/privacy.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Privacy</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('config.index') }}" class="nav-link @yield('menu_config')">
                <img src="{{ url('img/icon-header-app/privacy.png')}}" alt="" sizes="30" srcset="" class="mb-1 mr-2">
                <p>Config</p>
              </a>
            </li>

          </ul>
        </nav>
        <div class="text-center" style="margin-top:50px;margin-bottom:50px">
        <a href="#" class="" style="">
          <span class="text-white text-center" style="font-size:16px">Version 1.0.0 Pre</span>
        </a>
        </div>
        <br>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    @endauth
    <!-- <main class="py-4">  -->
    <main class=""> 

      @yield('content')
    </main>


    @auth
    <!-- <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0-pre
      </div>
      <strong>Copyright &copy; 2020 <a href="https://www.adesso.co.th/">
Adesso Technology Co.,Ltd.</a></strong> All rights reserved.
    </footer> -->
    @endauth

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>

  </div>

  <!-- jQuery -->
  <script type="text/javascript" src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/jquery-loading/loadingoverlay.min.js') }}"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    
  <!-- Bootstrap 4 -->
  <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
  <!-- bootstrap4-toggle -->
  <script type="text/javascript" src="{{ asset('plugins/bootstrap4-toggle/bootstrap4-toggle.min.js') }}"></script>

  <!-- niceScroll -->
  <script type="text/javascript" src="{{ asset('plugins/jquery-nicescroll/jquery.nicescroll.min.js') }}"></script>

  <!-- overlayScrollbars -->
  <script type="text/javascript" src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script type="text/javascript" src="{{ asset('dist/js/adminlte.js') }}"></script>
  <!-- jquery-validation -->
  <script type="text/javascript" src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>
  <!-- Select2 -->
  <script type="text/javascript" src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script> 
  <!-- SweetAlert2 -->
  <script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.js') }}"></script>

  <!-- dataTables JS -->

  <script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

  <script type="text/javascript" src="{{ asset('plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

  <!-- tinymce -->
  <script type="text/javascript" src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script> 
  <!-- xZoom -->
  <script type="text/javascript" src="{{ asset('plugins/xZoom/js/xzoom.min.js') }}"></script> 

  
  

  <script>
    $(function() {
      $('[data-toggle="popover"]').popover();
      countNotiSidebar();


      $.LoadingOverlaySetup({
               background: "rgba(9,44,76,1) 100%) none repeat scroll 0% 0%",
               image: '',
               textAutoResize: true,
               fontawesome: 'fas fa-sync-alt',
               fontawesomeAnimation: true,
               fontawesomeAutoResize: true,
               fontawesomeResizeFactor: 1,
               fontawesomeColor: "#202020",
               direction: "column", // String
               fade: [400, 200], // Array/Boolean/Integer/String
               resizeInterval: 50, // Integer
               zIndex: 2147483647, // Integer
          });

      $.fn.DataTable.ext.pager.numbers_length = 7;
      $.extend( true, $.fn.dataTable.defaults, {
          lengthChange: false,
          searching: true,
          bFilter: true,
          dom: "<'row'<'col-sm-12 col-md-12 col-lg-8'l><'col-sm-12 col-md-12 col-lg-4'f>>" +
                "<'row'<'col-sm-12 col-md-12 col-lg-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5 col-lg-6'i><'col-sm-12 col-md-7 col-lg-6'p>>",
          pagingType: "simple_numbers",
          language: {
                lengthMenu: 'แสดงข้อมูล _MENU_ ข้อมูล',
                emptyTable: '<font style="color:#536476;font-size:18px;font-weight: 600;">ไม่มีข้อมูล</font>',
                zeroRecords: '<font style="color:#536476;font-size:18px;font-weight: 600;">ไม่มีข้อมูล</font>',
                info: '<font style="color:#7F92A3;font-size:16px;font-weight: 500;">แสดงข้อมูลตั้งแต่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล</font>',
                infoEmpty: '<font style="color:#7F92A3;font-size:16px;font-weight: 500;">ไม่มีข้อมูลที่แสดงอยู่</font>',
                infoFiltered: '<font style="color:#7F92A3;font-size:16px;font-weight: 500;">(ค้นหาจาก _MAX_ จำนวนทั้งหมด)</font>',
                search: "", //ค้นหา :
                searchPlaceholder: "Search...",
                loadingRecords: "กำลังโหลด...",
                //processing: "กำลังประมวลผล...",
                processing: '<i class="fas fa-sync-alt fa-spin fa-3x fa-fw" style="color:#FFC258;"></i>',
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>',
                },
             
            },
      } );
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
    });

    const countNotiSidebar = () =>{
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"count_noti_sidebar"},
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    $(".noti-order-check").html(response.noti_wait_pay);
                    $(".noti-order-success").html(response.noti_paid);
                    $(".noti-order-wait-approve").html(response.noti_wait_approve);
                }
            }
        });    
    }
    
  </script>

  @yield('js')
</body>

</html>