@extends('../layouts.app')

@section('menu_dashboard' , 'active')

@section('css')
<!-- apex charts -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/apexcharts/apexcharts.css') }}" />

<style>
.breadcrumb {
    background-color: transparent !important;
    padding-left: 0;
    margin-bottom: 0;
}
.card {
    /* border-top: 0 !important; */
    /* background-color: transparent; */
    /* box-shadow: 0 0 0 0;
    margin-top: 0;
    margin-left: 0;
    margin-right: 0;
    z-index: 2; */
    margin-top: 0;
}
.card-body {
    background-color: #fff;
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    border-top-left-radius: 20px;
}

</style>
@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="">
      <div class="container-fluid">
        <div class="row mb-2 w-100">
            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12 pt-4 pl-4 ">
                <font id="header_title" class="header_title">Dashboard </font>
                <ol class="breadcrumb ">
                  <li class="breadcrumb-item active">Hi, {{ Auth::user()->name }}</li>
                </ol>
            </div>            
            <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12 pt-4 ">
              <div class="float-right box_today text-center">
                  <font id="" class="header_title text_color_2">{{ Carbon\Carbon::now()->day }}</font>
                    <p>{{ Carbon\Carbon::now()->format('M') }} {{ Carbon\Carbon::now()->year }} </p>
              </div>
            
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="justify-content-center ml-4 mr-4 ">
        <div class="">
          <div class="row" >
            <div class="col-lg-6">
              <div class="row" style="margin:0;padding:0">
                  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                    <div class="box_dash dash_wait_pay">
                      <div class="div_in_dash">
                        <div class="">
                          <div class="style_img_wait_pay d-inline float-left">
                            <img src="{{ url('img/icon_pages/dash_wait_pay.png')}}" alt="" sizes="" srcset="" >
                          </div>
                          <div class=" d-inline float-right bg-white">
                              <a class="style_img_right" href="{{ url('admin/order/status/wait-for-pay') }}">
                                <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                              </a>                
                          </div>                
                        </div>
                        <br><br>                  
                        <div class="padding_top_style">
                          <font class="style_number_main">{{ $order_new_count->order_new_count }}</font>
                        </div>
                        <div>
                          <font class="style_number_small">รอชำระเงิน</font>
                        </div>
                      </div>
                    </div>                
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                    <div class="box_dash dash_check">
                      <div class="div_in_dash">
                        <div class="">
                          <div class="style_img_check d-inline float-left">
                            <img src="{{ url('img/icon_pages/dash_check.png')}}" alt="" sizes="" srcset="" >
                          </div>
                          <div class=" d-inline float-right bg-white">
                              <a class="style_img_right" href="{{ url('admin/order/status/check') }}">
                                <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                              </a>                
                          </div>                
                        </div>
                        <br><br>                  
                        <div class="padding_top_style">
                          <font class="style_number_main">{{ $tranfer_new_count->tranfer_new_count }}</font>
                        </div>
                        <div>
                          <font class="style_number_small">แจ้งชำระเงิน</font>
                        </div>
                      </div>
                    </div>                
                  </div>
                  <!-- ./col -->

                  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                    <div class="box_dash dash_paid">
                      <div class="div_in_dash">
                        <div class="">
                          <div class="style_img_paid d-inline float-left">
                            <img src="{{ url('img/icon_pages/dash_paid.png')}}" alt="" sizes="" srcset="" >
                          </div>
                          <div class=" d-inline float-right bg-white">
                              <a class="style_img_right" href="{{ url('admin/order/status/paid') }}">
                                <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                              </a>                
                          </div>                
                        </div>
                        <br><br>                  
                        <div class="padding_top_style">
                          <font class="style_number_main">{{ $order_payed_count->order_payed_count }}</font>
                        </div>
                        <div>
                          <font class="style_number_small">ชำระเงินแล้ว</font>
                        </div>
                      </div>
                    </div>                
                  </div>
                  <!-- ./col -->

                  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                    <div class="box_dash dash_sended">
                      <div class="div_in_dash">
                        <div class="">
                          <div class="style_img_sended d-inline float-left">
                            <img src="{{ url('img/icon_pages/dash_sended.png')}}" alt="" sizes="" srcset="" >
                          </div>
                          <div class=" d-inline float-right bg-white">
                              <a class="style_img_right" href="{{ url('admin/order/status/sent') }}">
                                <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                              </a>                
                          </div>                
                        </div>
                        <br><br>                  
                        <div class="padding_top_style">
                          <font class="style_number_main">{{ $order_sended_count->order_sended_count }}</font>
                        </div>
                        <div>
                          <font class="style_number_small">ส่งสินค้าแล้ว</font>
                        </div>
                      </div>
                    </div>                
                  </div>
                  <!-- ./col -->
                
              </div>
                
                
            </div>


            <!-- col -lg -6 start -->
            <div class="col-lg-6">
              <div class="row" >
                    

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                      <div class="box_dash dash_refund">
                        <div class="div_in_dash">
                          <div class="">
                            <div class="style_img_refund d-inline float-left">
                              <img src="{{ url('img/icon_pages/dash_refund.png')}}" alt="" sizes="" srcset="" >
                            </div>
                            <div class=" d-inline float-right bg_style_black">
                                <a class="style_img_right" href="{{ url('admin/approve/status/reject') }}">
                                  <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                                </a>                
                            </div>                
                          </div>
                          <br><br>                  
                          <div class="padding_top_style">
                            <font class="style_number_main">0</font>
                          </div>
                          <div>
                            <font class="style_number_small">ขอคืนเงิน</font>
                          </div>
                        </div>
                      </div>                
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                      <div class="box_dash dash_expired">
                        <div class="div_in_dash">
                          <div class="">
                            <div class="style_img_expired d-inline float-left">
                              <img src="{{ url('img/icon_pages/dash_expired.png')}}" alt="" sizes="" srcset="" >
                            </div>
                            <div class=" d-inline float-right bg_style_black">
                                <a class="style_img_right" href="{{ url('admin/order/status/cancelPeriod') }}">
                                  <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                                </a>                
                            </div>                
                          </div>
                          <br><br>                  
                          <div class="padding_top_style">
                            <font class="style_number_main">{{ $order_cancel_period->order_cancel_period }}</font>
                          </div>
                          <div>
                            <font class="style_number_small">คำสั่งซื้อหมดอายุ</font>
                          </div>
                        </div>
                      </div>                
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                      <div class="box_dash dash_approved">
                        <div class="div_in_dash">
                          <div class="">
                            <div class="style_img_approved d-inline float-left">
                              <img src="{{ url('img/icon_pages/dash_approved.png')}}" alt="" sizes="" srcset="" >
                            </div>
                            <div class=" d-inline float-right bg_style_black">
                                <a class="style_img_right" href="{{ url('admin/approve/status/approved') }}">
                                  <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                                </a>                
                            </div>                
                          </div>
                          <br><br>                  
                          <div class="padding_top_style">
                            <font class="style_number_main">{{ $order_ebook_approve_count->order_ebook_approve_count }}</font>
                          </div>
                          <div>
                            <font class="style_number_small">อนุมัติอ่านแล้ว</font>
                          </div>
                        </div>
                      </div>                
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 py-3">
                      <div class="box_dash dash_reject">
                        <div class="div_in_dash">
                          <div class="">
                            <div class="style_img_reject d-inline float-left">
                              <img src="{{ url('img/icon_pages/dash_reject.png')}}" alt="" sizes="" srcset="" >
                            </div>
                            <div class=" d-inline float-right bg_style_black">
                                <a class="style_img_right" href="{{ url('admin/approve/status/reject') }}">
                                  <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" >                          
                                </a>                
                            </div>                
                          </div>
                          <br><br>                  
                          <div class="padding_top_style">
                            <font class="style_number_main">{{ $order_ebook_reject_count->order_ebook_reject_count }}</font>
                          </div>
                          <div>
                            <font class="style_number_small">ไม่อนุมัติการอ่าน</font>
                          </div>
                        </div>
                      </div>                
                    </div>
                    <!-- ./col -->
              </div>
              
            </div>

            <!-- end -->
          </div>
          
        </div>
        <div class="row" style="margin:0;padding:0">
          <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 py-4">
            <div class="box_dash chart_style">
              <div class="box_header_chart_dash">
                <div class="row" style="margin:0;padding:0">
                  <div class="col-lg-8">
                    <p class="topic_chart">Order</p>
                    <p class="topic_subtext_chart">ประจำสัปดาห์</p>
                  </div>
                  <div class="col-lg-4  text-middle">
                    <div class="dropdown text-right ">
                        <button class="btn btn-default  dropdownFiltersDashStyle " type="button" id="dropdownMenu1" role="button" type="button" data-toggle="dropdown">
                            <font class="float-left pl-2"><img src="{{ url('img/icon_pages/filters.png') }}">    <font class="pl-2" id="filterText">Filters</font> <small class="noti_filters"></small>   </font> 
                            <font class="float-right pt-2"><img src="{{ url('img/icon_pages/arrow_down.png') }}"></font>        
                                  
                        </button>
                        <ul class="dropdown-menu dropdownOptionFiltersStyle">
                            <li class="dropdownFiltersli">
                                <a href="javascript:void(0)" class="checkboxFilters dashOrderFilterBtn" data-val="Weekly">
                                <font class=""> Weekly ({{ Carbon\Carbon::now()->year }})</font></a>
                            </li>
                            <li class="dropdownFiltersli">
                                <a href="javascript:void(0)" class="checkboxFilters dashOrderFilterBtn" data-val="Monthly">
                                <font class=""> Monthly ({{ Carbon\Carbon::now()->year }})</font></a>
                            </li>
                            <li class="dropdownFiltersli">
                                <a href="javascript:void(0)" class="checkboxFilters dashOrderFilterBtn" data-val="Yearly">
                                <font class=""> Yearly ({{ Carbon\Carbon::now()->year }})</font></a>
                            </li>
                        </ul>
                    </div>
                  </div>
                </div>
                
                
              </div>
              <div>
                  <div id="chart">
                  </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 py-4">
            <div class="box_dash box_new_order_style">
              <div class="box_header_chart_dash">
                <div class="row">
                  <div class="col-lg-8 col-md-12">
                    <font class="topic_chart">New Order</font>
                  </div>
                  <div class="col-lg-4 col-md-12">
                    <a class="float-right see_all_order" href="{{ url('admin/order/status/all') }}">
                      ดูทั้งหมด                              
                    </a> 
                  </div>
                </div>
                
                
              </div>
              <div class="box_new_order">

              @foreach ($orderNew as $val)
                @if($loop->first)
                <div class="box_sub active">
                  <div class="row" style="padding:10px">
                    <div class="box_img text-center col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
                      <img src="{{ url('img/icon_pages/dash_bag.png')}}" alt="" sizes="" srcset="" >  
                    </div>
                    <div class="box_content col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                        <font class="text_order">Order : {{ $val->id }}</font> <br>
                        <small>{{ $val->created_at->format('M') }} {{ $val->created_at->day }} {{ $val->created_at->year }}</small> <strong>&middot;</strong> <small>{{ $val->created_at->format('h:i A') }}</small>
                    </div>
                    <div class="box_content_footer col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
                        <a class="" href="{{ url('admin/order/search/'.$val->id) }}">
                            <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" class="arrow_right" >                    
                        </a>                   
                    </div>
                  </div>                     
                </div>
                @else
                <div class="box_sub ">
                  <div class="row" style="padding:10px">
                    <div class="box_img text-center col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
                      <img src="{{ url('img/icon_pages/dash_bag.png')}}" alt="" sizes="" srcset="" >  
                    </div>
                    <div class="box_content col-lg-8 col-md-8 col-sm-8 col-xs-8 col-8">
                        <font class="text_order">Order : {{ $val->id }}</font> <br>
                        <small>{{ $val->created_at->format('M') }} {{ $val->created_at->day }} {{ $val->created_at->year }}</small> <strong>&middot;</strong> <small>{{ $val->created_at->format('h:i A') }}</small>
                    </div>
                    <div class="box_content_footer col-lg-2 col-md-2 col-sm-2 col-xs-2 col-2">
                        <a class="" href="{{ url('admin/order/search/'.$val->id) }}">
                            <img src="{{ url('img/icon_pages/arrow_right.png')}}" alt="" sizes="" srcset="" class="arrow_right" >                    
                        </a>                   
                    </div>
                  </div>                     
                </div>
                @endif
              @endforeach

              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

<!-- apex charts -->
<script type="text/javascript" src="{{ asset('plugins/apexcharts/apexcharts.min.js') }}"></script>

@section('js')
<script>
$(function() {

  var options = null ;
  chartWeekly();
  // chartUpdate("Weekly");

  var chart = new ApexCharts(document.querySelector("#chart"),options );

  chart.render();
  // chartUpdate("Weekly" , chart);

  $('body').on('click', '.dashOrderFilterBtn', function() {
      let val = $(this).data('val');
      switch (val) {
        case "Weekly":
          chartWeekly();
          chart.updateOptions(options);
          $("#filterText").html("Weekly ({{ Carbon\Carbon::now()->year }})");
          $(".topic_subtext_chart").html("ประจำสัปดาห์");
          break;
        case "Monthly":
          chartMonthly();
          chart.updateOptions(options);
          $("#filterText").html("Monthly ({{ Carbon\Carbon::now()->year }})");
          $(".topic_subtext_chart").html("ประจำเดือน");
          break;
        case "Yearly":
          chartYearly();
          chart.updateOptions(options);
          $("#filterText").html("Yearly ({{ Carbon\Carbon::now()->year }})");
          $(".topic_subtext_chart").html("ประจำปี");
          break;
      }
  });


  function chartWeekly(){
    options = {
      chart: {
        type: 'line' ,
        height:350 ,
        zoom: { enabled: false} ,
        toolbar: {
          show: true,
          tools: {
            download: false
          }
        },
        type: "area" ,
        fontSize: '30px',
        fontWeight: 400,
      },
      stroke:{
        width:3 ,
        curve:'smooth'  //(smooth , straight , stepline)
      },
      fill:{
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.4,
          opacityTo: 0.6,
          stops: [0, 90, 100]
        }
        
      },
      animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 1000,
          animateGradually: {
              enabled: true,
              delay: 1000
          },
          dynamicAnimation: {
              enabled: true,
              speed: 1000
          }
      },
      dataLabels: {
        // enabled: false ,
        textAnchor: 'middle',
        style: {
          fontSize: '14px',
        },
        background: {
          enabled: true,
          foreColor: '#fff',
          padding: 5,
          borderRadius: 20,
          borderWidth: 1,
          borderColor: '#fff',
          opacity: 0.9,
          dropShadow: {
            enabled: false,
            top: 1,
            left: 1,
            blur: 1,
            color: '#000',
            opacity: 0.45
          }
        },
        dropShadow: {
          enabled: false,
          top: 1,
          left: 1,
          blur: 1,
          color: '#000',
          opacity: 0.45
        }
      },
      series: [{
                name: [
                  "{{ $dateOfFocus[0] }}" , 
                  "{{ $dateOfFocus[1] }}" , 
                  "{{ $dateOfFocus[2] }}" , 
                  "{{ $dateOfFocus[3] }}" , 
                  "{{ $dateOfFocus[4] }}" , 
                  "{{ $dateOfFocus[5] }}" , 
                  "{{ $dateOfFocus[6] }}" , 
                ],
                data: {{ json_encode($orderDateOfWeek,TRUE) }},
            }],
      xaxis: {
        categories: ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"],
        tooltip: {
          enabled: false
        },
        labels: {
          style: {
              colors: "#7F92A3",
              fontSize: '16px',
              fontWeight: 400,
          },
        }
      },
      
      tooltip: {
        custom: function({ series, seriesIndex, dataPointIndex, w }) {
          // console.log(w.globals.seriesNames[0][dataPointIndex])
          // w.globals.categoryLabels[dataPointIndex]
          return (
            `<div class="box_chart_dash">
              ${series[seriesIndex][dataPointIndex]} Order  
              <div class="subtext">${w.globals.seriesNames[0][dataPointIndex]}</div>
            </div>`        
          );
        }
      },
      // legend:{    
      //   horizontalAlign:'left'
      //   , width:250
      //   , markers:{height:12 , width:12}
      //   ,  formatter: function(seriesName, opts) {
      //     var optArray =   opts.w.globals.series[opts.seriesIndex] ;
      //     var optMax  = Math.max.apply(null, optArray);
      //     var optMin  = Math.min.apply(null, optArray);
      //     var optAvg = optArray.reduce((p, c) => p + c, 0) / optArray.length ;
          
      //     return [seriesName, "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ",  optMin.toFixed(0)  ,"&nbsp; &nbsp; &nbsp; ", optMax.toFixed(0) ,"&nbsp; &nbsp; &nbsp; ", optAvg.toFixed(0) ,"<br>" ]
      //   } 
      // },
      noData:{
        text: "No Data" 
        ,align: 'center' 
        ,verticalAlign:'top'
      }
    }
  }

  function chartMonthly(){
    options = {
      chart: {
        type: 'line' ,
        height:350 ,
        zoom: { enabled: false} ,
        toolbar: {
          show: true,
          tools: {
            download: false
          }
        },
        type: "area" ,
        fontSize: '30px',
        fontWeight: 400,
      },
      stroke:{
        width:3 ,
        curve:'smooth'  //(smooth , straight , stepline)
      },
      fill:{
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.4,
          opacityTo: 0.6,
          stops: [0, 90, 100]
        }
        
      },
      animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 1000,
          animateGradually: {
              enabled: true,
              delay: 1000
          },
          dynamicAnimation: {
              enabled: true,
              speed: 1000
          }
      },
      dataLabels: {
        // enabled: false ,
        textAnchor: 'middle',
        style: {
          fontSize: '14px',
        },
        background: {
          enabled: true,
          foreColor: '#fff',
          padding: 5,
          borderRadius: 20,
          borderWidth: 1,
          borderColor: '#fff',
          opacity: 0.9,
          dropShadow: {
            enabled: false,
            top: 1,
            left: 1,
            blur: 1,
            color: '#000',
            opacity: 0.45
          }
        },
        dropShadow: {
          enabled: false,
          top: 1,
          left: 1,
          blur: 1,
          color: '#000',
          opacity: 0.45
        }
      },
      series: [{
                name: [
                  "{{ $dateOfFocusOfMonth[0] }}" , 
                  "{{ $dateOfFocusOfMonth[1] }}" , 
                  "{{ $dateOfFocusOfMonth[2] }}" , 
                  "{{ $dateOfFocusOfMonth[3] }}" , 
                  "{{ $dateOfFocusOfMonth[4] }}" , 
                  "{{ $dateOfFocusOfMonth[5] }}" , 
                  "{{ $dateOfFocusOfMonth[6] }}" , 
                  "{{ $dateOfFocusOfMonth[7] }}" , 
                  "{{ $dateOfFocusOfMonth[8] }}" , 
                  "{{ $dateOfFocusOfMonth[9] }}" , 
                  "{{ $dateOfFocusOfMonth[10] }}" , 
                  "{{ $dateOfFocusOfMonth[11] }}" , 
                ],
                data: {{ json_encode($orderDateOfMonth,TRUE) }},
            }],
      xaxis: {
        categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        tooltip: {
          enabled: false
        },
        labels: {
          style: {
              colors: "#7F92A3",
              fontSize: '16px',
              fontWeight: 400,
          },
        }
      },
      
      tooltip: {
        custom: function({ series, seriesIndex, dataPointIndex, w }) {
          // console.log(w.globals.seriesNames[0][dataPointIndex])
          // w.globals.categoryLabels[dataPointIndex]
          return (
            `<div class="box_chart_dash">
              ${series[seriesIndex][dataPointIndex]} Order  
              <div class="subtext">${w.globals.seriesNames[0][dataPointIndex]}</div>
            </div>`        
          );
        }
      },
      noData:{
        text: "No Data" 
        ,align: 'center' 
        ,verticalAlign:'top'
      }
      
    }
    
  }

  function chartYearly(){
    options = {
      chart: {
        type: 'line' ,
        height:350 ,
        zoom: { enabled: false} ,
        toolbar: {
          show: true,
          tools: {
            download: false
          }
        },
        type: "area" ,
        fontSize: '30px',
        fontWeight: 400,
      },
      stroke:{
        width:3 ,
        curve:'smooth'  //(smooth , straight , stepline)
      },
      fill:{
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.4,
          opacityTo: 0.6,
          stops: [0, 90, 100]
        }
        
      },
      animations: {
          enabled: true,
          easing: 'easeinout',
          speed: 1000,
          animateGradually: {
              enabled: true,
              delay: 1000
          },
          dynamicAnimation: {
              enabled: true,
              speed: 1000
          }
      },
      dataLabels: {
        // enabled: false ,
        textAnchor: 'middle',
        style: {
          fontSize: '14px',
        },
        background: {
          enabled: true,
          foreColor: '#fff',
          padding: 5,
          borderRadius: 20,
          borderWidth: 1,
          borderColor: '#fff',
          opacity: 0.9,
          dropShadow: {
            enabled: false,
            top: 1,
            left: 1,
            blur: 1,
            color: '#000',
            opacity: 0.45
          }
        },
        dropShadow: {
          enabled: false,
          top: 1,
          left: 1,
          blur: 1,
          color: '#000',
          opacity: 0.45
        }
      },
      series: [{
                name: [
                  "{{ $bottomYear[0] }}" , 
                  "{{ $bottomYear[1] }}" , 
                  "{{ $bottomYear[2] }}" , 
                  "{{ $bottomYear[3] }}" , 
                  "{{ $bottomYear[4] }}" , 
                ],
                data: {{ json_encode($orderDateOfYear,TRUE) }},
            }],
      xaxis: {
        categories: ["{{ $bottomYear[0] }}","{{ $bottomYear[1] }}","{{ $bottomYear[2] }}","{{ $bottomYear[3] }}","{{ $bottomYear[4] }}"],
        tooltip: {
          enabled: false
        },
        labels: {
          style: {
              colors: "#7F92A3",
              fontSize: '16px',
              fontWeight: 400,
          },
        }
      },
      
      tooltip: {
        custom: function({ series, seriesIndex, dataPointIndex, w }) {
          // console.log(w.globals.seriesNames[0][dataPointIndex])
          // w.globals.categoryLabels[dataPointIndex]
          return (
            `<div class="box_chart_dash">
              ${series[seriesIndex][dataPointIndex]} Order  
              <div class="subtext">${w.globals.seriesNames[0][dataPointIndex]}</div>
            </div>`        
          );
        }
      },
      noData:{
        text: "No Data" 
        ,align: 'center' 
        ,verticalAlign:'top'
      }
      
    }
  }

});
  



</script>
@endsection