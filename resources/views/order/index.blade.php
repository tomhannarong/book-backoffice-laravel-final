@extends('../layouts.app')

@section('menu_order_open' , 'menu-open')
@section('menu_order_open_active' , 'active')

@if(!empty($status))
    @if($status == "paid")
        @section('menu_order_paid' , 'active')
    @elseif($status == "check")
        @section('menu_order_check' , 'active')
    @else
        @section('menu_order_check' , 'active')
    @endif

@endif



@section('css')
<!-- App Custom CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/back-office/order.style.css') }}" />
<!-- Jquery image zoom -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/Jquery-image-zoom/css/main.css') }}" />
<!-- photoviewer -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/photoviewer/photoviewer.css') }}" />

<style>
.photoviewer-modal {
      box-shadow: 0 0 6px 2px rgba(0, 0, 0, .3);
    }

    .photoviewer-inner {
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background-color: transparent;
      border: none;
      border-radius: 0;
      backdrop-filter: unset;
    }

    .photoviewer-header .photoviewer-toolbar {
      background-color: rgba(0, 0, 0, .5);
    }

    .photoviewer-stage {
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background-color: rgba(0, 0, 0, .85);
      border: none;
    }

    .photoviewer-footer .photoviewer-toolbar {
      background-color: rgba(0, 0, 0, .5);
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }

    .photoviewer-header,
    .photoviewer-footer {
      pointer-events: none;
    }

    .photoviewer-title {
      color: #ccc;
    }

    .photoviewer-button {
      color: #ccc;
      pointer-events: auto;
    }

    .photoviewer-footer .photoviewer-button:hover {
      color: white;
    }
</style>
@endsection

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-4 pl-4">
            <font id="header_title" class="header_title">Order Master Menu </font>
          </div>
           
          <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
            <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Custommer Order</ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
    <div class="justify-content-center py-4">
    
        <div >
        
            <div class="card " style="border: none">
                <div class="card-header text-center">
                <ul class="nav nav-tabs card-header-tabs ">
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header active nav-item-left"   href="{{ url('admin/order') }}">
                            <strong class="span_vertical_active">
                                Orders 
                                <span class="right badge badge-danger noti-header-order noti-header-order-all">0</span>
                            </strong>  
                            
                        </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header text-white color_span_active" href="{{ url('admin/approve') }}">
                            <strong class="span_vertical">
                                Approved E-Book
                                <span class="right badge badge-danger noti-header-order noti-header-approve-ebook">0</span>
                            </strong>
                        </a>
                    </li>
                </ul>
                </div>
                
                <div class="card-body text-middle">
                
                <!-- text-middle -->
                    <div class=" text-middle">
                        <table id="example" class="table text-left  table-fixed" cellspacing="0" style="width:100% ">
                        <thead class="" style="background-color:#ebeef3;color:#7F92A3">
                        <!-- style="background-color:#d7e0e7" -->
                            <tr class="">
                                <th width="2%"  class="border_conner_left text-left" ></th>
                                <th width="">Order ID</th>
                                <th width="">Date</th>
                                <th width="">Username</th>
                                <th width="">Price</th>
                                <th width="10%">Book Type</th>
                                <th width="18%">Payment Status</th>
                                <th width="15%">Order Status</th>
                                
                                
                                <th  width="15%" class="border_conner_right">Action</th>
                            </tr>
                        </thead>
                       <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                       </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


      <!-- <a data-gallery="photoviewer" data-title="Slipping Away by Jerry Fryer" data-group="a"
         href="https://farm1.staticflickr.com/313/31812080833_297acfbbd9_z.jpg">
        <img src="https://farm1.staticflickr.com/313/31812080833_297acfbbd9_s.jpg" alt="">
      </a> -->
      <!-- <a data-gallery="photoviewer" data-title="Mi Fuego by albert dros" data-group="a"
         href="https://farm4.staticflickr.com/3804/33589584740_b0fbdcd4aa_z.jpg">
        <img src="https://farm4.staticflickr.com/3804/33589584740_b0fbdcd4aa_s.jpg" alt="">
      </a>
      <a data-gallery="photoviewer" data-title="Winter Fairytale by Achim Thomae" data-group="a"
         href="https://farm1.staticflickr.com/470/31340603494_fb7228020d_z.jpg">
        <img src="https://farm1.staticflickr.com/470/31340603494_fb7228020d_s.jpg" alt="">
      </a>

      <a data-gallery="photoviewer"
         href="https://farm5.staticflickr.com/4267/34162425794_1430f38362_z.jpg" data-group="b">
        <img src="https://farm5.staticflickr.com/4267/34162425794_1430f38362_s.jpg" alt="">
      </a>
      <a data-gallery="photoviewer"
         href="https://farm1.staticflickr.com/4160/34418397675_18de1f7b9f_z.jpg" data-group="b">
        <img src="https://farm1.staticflickr.com/4160/34418397675_18de1f7b9f_s.jpg" alt="">
      </a>
      <a data-gallery="photoviewer"
         href="https://farm1.staticflickr.com/512/32967783396_a6b4babd92_z.jpg" data-group="b">
        <img src="https://farm1.staticflickr.com/512/32967783396_a6b4babd92_s.jpg" alt="">
      </a> -->


    </div>


    <!-- The Modal View Data -->
    <div class="modal fade" id="viewDataModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-container">
            
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Order Status</h4>
                <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body order_status_body" >                  
                    
                </div>
                
            </div>
            <!-- Modal footer -->
            <div class="modal_footer_ap">
                
            </div>
            
        </div>
        </div>
    </div>
    
    <!-- The Modal View Order Detail Data -->
    <div class="modal fade" id="orderDetailModal">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
        <div class="modal-content">
            <div class="modal-container">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h3 class="modal-title"><font class="pl-2">Order Detail</font></h3>
                <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body order_detail_body row py-2" >

                </div>
            </div>
        </div>
        </div>
    </div>
    
     <!-- The Modal Check Slip Data -->
     <div class="modal fade" id="checkSlipModal">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
        <div class="modal-content">
            <div class="modal-container">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h3 class="modal-title"><img src="{{ url('img/icon_pages/icon_slip.png') }}"> <font class="pl-2">?????????????????????????????????</font></h3>
                <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body order_check_slip_body row py-2" >

                </div>
            </div>
        </div>
        </div>
    </div>
    
    <!-- The Modal View EMS Data -->
    <div class="modal fade" id="viewEMSModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-container">
        
                <!-- Modal Header -->
                <div class="modal-header">
                <h3 class="modal-title"><img src="{{ url('img/icon_pages/car_large.png') }}"> <font class="pl-2">???????????????????????????</font></h3>
                <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body order_ems_body row py-2" >

                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal EMS -->
    
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('js')
  <!-- Jquery image zoom -->
  <script type="text/javascript" src="{{ asset('plugins/Jquery-image-zoom/js/zoom-image.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/Jquery-image-zoom/js/main.js') }}"></script>

  <!-- photoviewer -->  
  <script type="text/javascript" src="{{ asset('plugins/photoviewer/photoviewer.js') }}"></script>
  
<script>    



$(function() {
    let theForm = $("#theForm");
    let table, Item_id , Item_val, Item, Item_id_order, Item_fn = null;
    let ACTION ='';
    let status = "{{ $status ?? '' }}" ;
    let keyword = "{{ $keyword ?? '' }}" ;

    // $("#viewDataModal").modal('show');

    // Swal.fire({
    //                             position: 'center',
    //                             icon: 'success',
    //                             title: '??????????????????????????????????????????',
    //                             showConfirmButton: false,
    //                             iconColor: '#ffffffff',
    //                             timer: 1500,
    //                         })

    var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
    if(status){
        if(status ==='sent'){
            // ACTION = 'trash';
        }
        if(status ==='paid'){
            $("#example").DataTable().clear().destroy();
            datatableFilter(ACTION,'paid','filtersCheckWaitSend');
        }else if(status === 'cancelPeriod'){
            $("#example").DataTable().clear().destroy();
            datatableFilter(ACTION,'wait-for-pay','filtersCheckCancelPeriod');
        }else if(status === 'sent'){
            $("#example").DataTable().clear().destroy();
            datatableFilter(ACTION,'paid','filtersCheckSended');
        }else if (status ==='all'){
            datatableFilter(ACTION,'all');
        }else{
            $("#example").DataTable().clear().destroy();
            datatableFilter(ACTION ,status);  
        }
        
    }else{
        $("#example").DataTable().clear().destroy();
        datatableFilter();
        
    }
    if(keyword){
        $("#example").DataTable().search(keyword).draw();
    }
    
    // $('#theModal').modal('show');
    
    // $('body').$("#theForm").on('submit', function (e) {
    //     //ajax call here

    //     //stop form submission
    //     e.preventDefault();
    //     console.log("123");
    // });
    $('body').on('click', '.submitEMS', function(e) {
        // e.preventDefault();
        let channel = $(this).data('channel-ems');
        let emsVal = null ;
        if(channel == "cViewModal"){
                emsVal = $("#tracking_number").val();
        }else if(channel == "cTransport"){
                emsVal = $("#tracking_number_transport").val();
        }
        
        // console.log(emsVal);
        let order_id = $(this).data('id');
        if(emsVal){
        
            Swal.fire({
                title: '???????????????????????????????????????????',
                html: `<p>???????????????????????????????????? : <font class="color_ems_check">${emsVal}</font></p> 
                    <p>???????????????????????????????????????????????????????????????????????????????????????????????????</p>`, 
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2DC8A8',
                cancelButtonColor: 'dark',
                confirmButtonText: '??????????????????' ,
                cancelButtonText: '?????????'
            }).then((result) => {
                if (result.value) {
                   
                    // $.LoadingOverlay("show");
                    let title = "Cannot update this record.";
                    var url = theForm.attr('action');
                    $.ajax({
                        url: "{{ url('admin/order') }}" + '/' + order_id,
                        type: "POST",
                        data: {_token: "{{ csrf_token() }}" , _method: 'PUT' , 'tracking_number':emsVal },
                        success: (response) => {
                            if ($.isEmptyObject(response.error)) {
                                console.log(response);
                                console.log(response.success);
                                $("#tracking_number").val("");
                                $("#viewEMSModal").modal('hide');
                                // $.LoadingOverlay("hide");
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: '??????????????????????????????????????????',
                                    showConfirmButton: false,
                                    iconColor: '#ffffffff',
                                    timer: 1500,
                                }).then((value) => {
                                    // window.history.back();
                                    table.ajax.reload(null, false);
                                });
                            } else {
                                console.log(response.error);
                                // $.LoadingOverlay("hide");
                                Swal.fire({
                                    icon: 'error',
                                    title: "<strong>" + title + "</strong>",
                                    text: "Error: " + response.error,
                                });
                            }
                        },
                        complete: function(){
                            $('#viewDataModal').modal('hide');
                            $('#viewEMSModal').modal('hide');
                        },                        
                        error: (response) => {
                            console.log('Error:', response);
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                icon: 'error',
                                title: "<strong>" + title + "</strong>",
                                html: "<strong>Error Code: </strong>" + response
                                    .status + "<p><strong>Message: </strong>" + JSON
                                    .stringify(response.responseJSON.message) +
                                    "</p>",
                            })
                        }
                    });
                    
                }
            });
        }
    });

    // if (theForm.length > 0) {
    //     theForm.validate({
    //         rules: {
    //             tracking_number: {
    //                 required: true,
    //             },
    //         },
    //         messages: {
    //             tracking_number: {
    //                 required: "Please enter tracking number",
    //             },
    //         },
    //         errorElement: 'span',
    //         errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.closest('.form-group').append(error);
    //         },
    //         highlight: function (element, errorClass, validClass) {
    //         $(element).addClass('is-invalid');
    //         },
    //         unhighlight: function (element, errorClass, validClass) {
    //         $(element).removeClass('is-invalid');
    //         },
            
    //         submitHandler: function(form) {
    //             // var form_data = new FormData(form);
    //             $.LoadingOverlay("show");
    //             var url = theForm.attr('action');
    //             var type = theForm.attr('method');
    //             var title = "Cannot add new records.";
    //             if (theForm.attr("typeForm") === "update") {
    //                 url += '/' + Item_id;
    //                 type = "POST";
    //                 // form_data.append('_method': 'PUT');
    //                 title = "Cannot update records.";
    //             }
    //             $.ajax({
    //                 url: url,
    //                 type: "POST",
    //                 data: {_token: "{{ csrf_token() }}" , _method: 'PUT' , 'tracking_number':$('#tracking_number').val() },
    //                 success: (response) => {
    //                     if ($.isEmptyObject(response.error)) {
    //                         console.log(response);
    //                         console.log(response.success);
    //                         theForm.trigger("reset");
    //                         $('#theModal').modal('hide');
    //                         $.LoadingOverlay("hide");
    //                         Swal.fire({
    //                             position: 'top-end',
    //                             icon: 'success',
    //                             title: 'Your work has been saved',
    //                             showConfirmButton: false,
    //                             timer: 800,
    //                         }).then((result) => table.ajax.reload(null, false));
    //                     } else {
    //                         console.log(response.error);
    //                         $.LoadingOverlay("hide");
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: "<strong>" + title + "</strong>",
    //                             text: "Error: " + response.error,
    //                         });
    //                     }
    //                 },
    //                 error: (response) => {
    //                     console.log('Error:', response);
    //                     $.LoadingOverlay("hide");
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: "<strong>" + title + "</strong>",
    //                         html: "<strong>Error Code: </strong>" + response
    //                             .status + "<p><strong>Message: </strong>" + JSON
    //                             .stringify(response.responseJSON.message) +
    //                             "</p>",
    //                     })
    //                 }
    //             });
    //         }
    //     });
    // }
    
    $('body').on('click', '.changeStatusBtn', function() {
        
        Item_id = $(this).data("id");
        Item = $(this).data("val");
        Item_ems = $(this).data("ems");
        Item_fn = $(this).data("fn");
        //alert(Item);
        if(Item === "??????????????????????????????"){
            Toast.fire({
                icon: 'error',
                title: 'Please Pending Payment.'
            });
           // alert("??????????????? ????????????");
        }else if(Item === "???????????????????????????"){
            Toast.fire({
                icon: 'error',
                title: 'Please check pay-in-slip.'
            });
           // alert("??????????????? ????????????");
        }else if(Item === "????????????????????????????????????"){
            showNextStage();
            // if(!Item_ems){
            //     //alert("ems ????????????");
            //     Toast.fire({
            //         icon: 'error',
            //         title: 'Please enter tracking number.'
            //     });
            // }else{
            //     showNextStage();
            // }
        }else if(Item === "???????????????????????????????????????") {
            Toast.fire({
                icon: 'error',
                title: 'Order Completed.'
            });
        }

        function showNextStage(){
            Swal.fire({
                title: '????????????????????????????????????  <i class="fas fa-truck pl-3 pt-1"></i>',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (res) => {
                    if(res){
                        // alert(res)
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/order') }}" + '/' + Item_id,
                            data: {_token: "{{ csrf_token() }}" , _method: 'PUT' , 'tracking_number':res },
                        });
                    }else{
                        Swal.showValidationMessage(
                        `?????????????????????????????????????????????????????????`
                        )
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            type: "POST",
                            url: "{{ url('admin/order') }}" + '/' + Item_id,
                            data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item , fn:Item_fn},// success: (response) => {
                            success: (response) => {
                                if ($.isEmptyObject(response.error)) {
                                    console.log(response);
                                    console.log(response.success);
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: '?????????????????????????????????????????????????????????????????????????????????????????????',
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then((value) => {
                                        // window.history.back();
                                        window.location='{{ url("admin/order") }}'
                                    });
                                    
                                } else {
                                    console.log(response.error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: "Cannot update records.",
                                        text: "ERROR: " + response.error,
                                    });
                                }
                            },
                            error: (response) => {
                                console.log('Error:', response);
                                Swal.fire({
                                    icon: 'error',
                                    title: "<strong>Cannot update records.</strong>",
                                    html: "<strong>Error Code: </strong>" + response
                                        .status + "<p><strong>Message: </strong>" +
                                        JSON.stringify(response.responseJSON
                                            .message) + "</p>",
                                });
                            }
                    });
                    
                }
            })




            // Swal.fire({
            // title: '??????????????????????????????????????????????',
            // text: "???????????????????????????????????????????????????????????????????????????????????????????????????????????????!",
            // icon: 'info',
            // showCancelButton: true,
            // confirmButtonColor: '#3085d6',
            // cancelButtonColor: 'dark',
            // confirmButtonText: 'Yes, I confirm that!'
            // }).then((result) => {
            //     if (result.value) {
            //         $.ajax({
            //             type: "POST",
            //             url: "{{ url('admin/order') }}" + '/' + Item_id,
            //             data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item , fn:Item_fn},
            //             success: (response) => {
            //                 if ($.isEmptyObject(response.error)) {
            //                     console.log(response);
            //                     console.log(response.success);
            //                     Swal.fire({
            //                         position: 'top-end',
            //                         icon: 'success',
            //                         title: 'Your work has been saved',
            //                         showConfirmButton: false,
            //                         timer: 800,
            //                     }).then((result) => { window.location='{{ url("admin/order") }}' });
            //                 } else {
            //                     console.log(response.error);
            //                     Swal.fire({
            //                         icon: 'error',
            //                         title: "Cannot delete records.",
            //                         text: "ERROR: " + response.error,
            //                     });
            //                 }
            //             },
            //             error: (response) => {
            //                 console.log('Error:', response);
            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: "<strong>Cannot delete records.</strong>",
            //                     html: "<strong>Error Code: </strong>" + response
            //                         .status + "<p><strong>Message: </strong>" +
            //                         JSON.stringify(response.responseJSON
            //                             .message) + "</p>",
            //                 });
            //             }
            //         });
            //     }
            // });
        }

        
    });
    
    
    $('body').on('click', '.viewDataBtn', function() {
        let order_id = $(this).data('id');
        // $("#viewDataModal").modal('show');
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"viewData" , order_id},
           beforeSend: function(){
                // $('.loadingModal').LoadingOverlay('show');
                $.LoadingOverlay("show");
            }, 
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $(".order_status_body").html(response.html);
                    $(".modal_footer_ap").html(response.html_footer ?? '');
                    
                    $("#viewDataModal").modal('show');
                    $('[data-toggle="popover"]').popover();
                    
                    // $("#action_des_order_new").niceScroll();
                }
            },
            complete: function(){
                // $('.loadingModal').LoadingOverlay('hide');
                $.LoadingOverlay("hide");
                jqueryImageZoom();
            },
        });    
    });

    
    
    $('body').on('click', '.viewOrderDetailBtn', function() {
        let order_id = $(this).data('id');
        
        // $("#viewDataModal").modal('show');
        
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"viewOrderDetail" , order_id },
           beforeSend: function(){
                // $('.loadingModal').LoadingOverlay('show');
                $.LoadingOverlay("show");
            }, 
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $(".order_detail_body").html(response.html);
                    $("#orderDetailModal").modal('show');
                }
            },
            complete: function(){
                // $('.loadingModal').LoadingOverlay('hide');
                $.LoadingOverlay("hide");
            },
        });    
    });
    
    $('body').on('click', '.checkSlipBtn', function() {
        let order_id = $(this).data('id');
        
        // $("#viewDataModal").modal('show');    
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"checkSlip" , order_id },
           beforeSend: function(){
                // $('.loadingModal').LoadingOverlay('show');
                $.LoadingOverlay("show");
            },
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $(".order_status_body").html('');
                    $(".modal_footer_ap").html('');

                    $(".order_check_slip_body").html(response.html);
                    $("#checkSlipModal").modal('show');
                }
            },
            complete: function(){
                // $('.loadingModal').LoadingOverlay('hide');
                $.LoadingOverlay("hide");
                jqueryImageZoom();
            },
        });    
    });
    
    $('body').on('click', '.viewEMSBtn', function() {
        let order_id = $(this).data('id');
        let order_ems = $(this).data('ems');
        
        // $("#viewDataModal").modal('show');
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"viewEMS" , order_id },
           beforeSend: function(){
                // $('.loadingModal').LoadingOverlay('show');
                $.LoadingOverlay("show");
            },
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $(".order_ems_body").html(response.html);
                    $("#viewEMSModal").modal('show');
                }
            },
            complete: function(){
                // $('.loadingModal').LoadingOverlay('hide');
                $.LoadingOverlay("hide");
            },
        });    
    });

    $('body').on('click', '.btnNext', function() {
        let Item_id = $(this).data("id");
        let Item_id_tran = $(this).data("id-tran");
        let Item = $(this).data("val");
        let Item_fn = $(this).data("fn");

        Swal.fire({
            title: '????????????????????????????????????????????????????',
            text: "???????????????????????????????????????????????????????????????????????????????????????????????????",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2DC8A8',
            cancelButtonColor: 'dark',
            confirmButtonText: '??????????????????' ,
            cancelButtonText: '?????????'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                    data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            var av_book = response.av_book ;
                            var av_ebook = response.av_ebook ;
                            if(av_ebook =="false"){ // dont have ebook
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: '??????????????????????????????????????????',
                                        showConfirmButton: false,
                                        iconColor: '#ffffffff',
                                        timer: 1500,
                                    }).then((value) => {
                                        // window.history.back();
                                        table.ajax.reload(null, false);
                                    });
                                    
                            }
                            if(av_ebook =="true"){ // have a ebook
                                Swal.fire({
                                    title: '????????????????????? E-Book?',
                                    text: "???????????????????????????????????????????????????????????????????????????????????????????????????",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#2DC8A8',
                                    cancelButtonColor: 'dark',
                                    confirmButtonText: '??????????????????' ,
                                    cancelButtonText: '?????????'
                                }).then((result) => {
                                    if (result.value) {
                                        Item_fn = "approve_read";
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                                            data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                                            success: (response) => {
                                                if ($.isEmptyObject(response.error)) {
                                                    console.log(response);
                                                    Swal.fire({
                                                        position: 'center',
                                                        icon: 'success',
                                                        title: '??????????????????????????????????????????',
                                                        showConfirmButton: false,
                                                        iconColor: '#ffffffff',
                                                        timer: 1500,
                                                    }).then((value) => {
                                                        // window.history.back();
                                                        table.ajax.reload(null, false);
                                                    });
                                                } 
                                            },
                                        });
                                    }else{
                                        // window.history.back();
                                        table.ajax.reload(null, false);
                                    }
                                });
                            }

                            // Swal.fire({
                            //     position: 'center',
                            //     icon: 'success',
                            //     title: '??????????????????????????????????????????',
                            //     showConfirmButton: false,
                            //     iconColor: '#ffffffff',
                            //     timer: 1500,
                            // }).then((value) => {
                                
                               
                                
                                



                            // });
                        } else {
                            console.log(response.error);
                            Swal.fire({
                                icon: 'error',
                                title: "Cannot delete records.",
                                text: "ERROR: " + response.error,
                            });
                        }
                    },
                    complete: function(){
                        $('#viewDataModal').modal('hide')
                        $('#checkSlipModal').modal('hide')
                    },                    
                    error: (response) => {
                        console.log('Error:', response);
                        Swal.fire({
                            icon: 'error',
                            title: "<strong>Cannot delete records.</strong>",
                            html: "<strong>Error Code: </strong>" + response
                                .status + "<p><strong>Message: </strong>" +
                                JSON.stringify(response.responseJSON
                                    .message) + "</p>",
                        });
                    }
                });
            }
        });
    });

    $('body').on('click', '.btnRej', function() {
        let Item_id = $(this).data("id");
        let Item_id_tran = $(this).data("id-tran");
        let Item = $(this).data("val");
        let Item_fn = $(this).data("fn");

        var myArrayOfThings = [
            { id: 1, name: '?????????????????????????????????????????????????????????????????????????????????' },
            { id: 2, name: '?????????????????????????????????????????????????????????????????????????????????' },
            { id: 3, name: '?????????????????????????????????' }
        ];

        var options = {};
        $.map(myArrayOfThings,function(o) {
            options[o.name] = o.name;
        });
        
        Swal.fire({
            icon: 'danger',
            title: '??????????????????????????????',
            // input: 'text',,
            text: '',
            html: true,
            html:
                `<p>???????????????????????????????????????????????????????????????????????????????????????????????????</p>
                <div id="swal_sendback_reason">
                
                </div>`,            
            onOpen: function () {
                $('#swal_input_reason').focus()
            },
            input: 'select',
            inputOptions: options,
            showCancelButton: true,
            animation: 'slide-from-top',
            inputPlaceholder: '??????????????????????????????????????????????????????????????????',
            confirmButtonColor: '#2DC8A8',
            cancelButtonColor: 'dark',
            confirmButtonText: '??????????????????' ,
            cancelButtonText: '?????????',
            inputAttributes: {
                autocapitalize: 'off'
            },
            // showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: (res) => {
                if(res){
                    console.log(res);
                    if(res === "?????????????????????????????????"){
                        if(!$('#swal_input_reason').val()){
                            Swal.showValidationMessage(
                            `??????????????????????????????????????????????????????????????????`
                            );
                            return false ;
                        }else{
                            res = $('#swal_input_reason').val();                            
                        }
                    }
                
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                        data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn,reason:res},
                        // success: (response) => {
                        //     if ($.isEmptyObject(response.error)) {
                        //         // Swal.fire({
                        //         //     icon: 'success',
                        //         //     title: "?????????????????????????????????????????????????????????????????????",
                        //         //     text: "ERROR: " + response.error,
                        //         // });
                        //         // Swal.fire({
                        //         //     position: 'top-end',
                        //         //     icon: 'success',
                        //         //     title: '?????????????????????????????????????????????????????????????????????',
                        //         //     showConfirmButton: false,
                        //         //     timer: 1500
                        //         // })
                        //         // console.log(response);
                        //         // Swal.fire({
                        //         //     title: '?????????????????????????????????????????????????????????????????????',
                        //         //     icon: 'success',
                        //         // }).then((value) => {
                        //         //     window.history.back();
                        //         // });
                        //     } 
                        // },
                    });
                }else{
                    Swal.showValidationMessage(
                    `???????????????????????????????????????????????????`
                    )
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '??????????????????????????????????????????',
                    showConfirmButton: false,
                    iconColor: '#ffffffff',
                    timer: 1500,
                }).then((value) => {
                    // window.history.back();
                    $('#viewDataModal').modal('hide');
                    $('#checkSlipModal').modal('hide');
                    table.ajax.reload(null, false);
                });
            }
        })
    });
    
    
    $('body').on('change', '.swal2-select', function() {
        if($(this).val() === "?????????????????????????????????"){
            $("#swal_sendback_reason").html('<input id="swal_input_reason" class="swal2-input" placeholder="?????????????????????????????????????????????????????????..">');
        }else{
            $("#swal_sendback_reason").html('');
        }        
    });

    $('body').on('click', '.emsBtn', function() {
        Item_id = $(this).data('id');
        var ems = $(this).data('ems');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/order') }}" + '/' + Item_id + '/edit',
            beforeSend: function(){
                // $('.loadingModal').LoadingOverlay('show');
                $.LoadingOverlay("show");
            }, 
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    $('.modal-header').removeClass("bg-success text-white");
                    $('.modal-title').html("Edit Item");
                    $('.modal-header').addClass("bg-warning text-black");
                    $(".error").html('');

                    $(".is-invalid").removeClass("is-invalid");

                    $(".error").removeClass("error");
                    theForm.attr("typeForm", "update");
                    // alert(Item_id);
                    //console.log(response.tracking_number);

                    $('#tracking_number').val(ems);
                    $('#theModal').modal('show');
                } else {
                    console.log(response.error);
                    Swal.fire({
                        icon: 'error',
                        title: "Error edit record.",
                        text: "ERROR: " + response.error,
                    });
                }
            },
            error: (response) => {
                console.log('Error:', response);
                Swal.fire({
                    icon: 'error',
                    title: "<strong>Error edit record.</strong>",
                    html: "<strong>Error Code: </strong>" + response.status +
                        "<p><strong>Message: </strong>" + JSON.stringify(response
                            .responseJSON.message) + "</p>",
                });
            },
            complete: function(){
                // $('.loadingModal').LoadingOverlay('hide');
                $.LoadingOverlay("hide");
            },
        });
    });

    
    $('body').on('click', '.checkboxFilters', function() {
        let Item_val = $(this).data("val");
        switch(Item_val) {
            case "filtersCheckAll":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'all','filtersCheckAll');
                break;
            case "filtersCheckSendback":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'all','filtersCheckSendback');
                break;
            case "filtersCheckWaitSend":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'paid','filtersCheckWaitSend');
                break;
            case "filtersCheckSended":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'paid','filtersCheckSended');
                break;                
            case "filtersCheckWaitApproveEbook":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'all','filtersCheckWaitApproveEbook');
                break;
            case "filtersCheckApprovedEbook":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'paid','filtersCheckApprovedEbook');
                break;
            case "filtersCheckCancelPeriod":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'wait-for-pay','filtersCheckCancelPeriod');
                break;
        }
        
        
        
        
        // alert(Item_val);
        // Item_id = $(this).data('id');
        // window.location='{{ url("admin/order") }}'+'/'+Item_id;
    });

    
    $('body').on('click', '.deleteBtn', function() {        
        let Item_id = $(this).data("id");
        // let Item_fn = $(this).data("fn");


        Swal.fire({
            title: '???????????????????????????????????????????????????????????????????????????????',
            text: "???????????????????????????????????????????????????????????????????????????????????????????????????",
            icon: 'danger',
            showCancelButton: true,
            confirmButtonColor: '#2DC8A8',
            cancelButtonColor: 'dark',
            confirmButtonText: '??????????????????' ,
            cancelButtonText: '?????????'
        }).then((result) => {
            if (result.value) {
                let reason = "?????????????????????????????????????????????????????????";
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/order') }}" + '/' + Item_id,
                    data: {_token: "{{ csrf_token() }}", _method: 'DELETE' ,'reason':reason},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            // console.log(response);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: '??????????????????????????????????????????',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                timer: 1500,
                            }).then((value) => {
                                // window.history.back();
                                table.ajax.reload(null, false);
                            });
                        } 
                    },
                });
            }else{
                // window.history.back();
                // table.ajax.reload(null, false);
            }
        });
    });

    const countNoti = () =>{
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"count_noti"},
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    $(".check_span").html(response.noti_wait_pay);
                    $(".paid_span").html(response.noti_paid);
                    $(".refund_span").html(response.noti_refund);
                    $(".noti-header-order-all").html(response.noti_order_all);
                    $(".noti-header-approve-ebook").html(response.noti_approve_ebook);                    
                }
            }
        });    
    }

    // initialize manually with a list of links
    $('body').on('click', '[data-gallery=photoviewer]', function(e) {  
        e.preventDefault();

        var items = [],
        options = {
            index: $(this).index(),
        };

        $('[data-gallery=photoviewer]').each(function () {
        items.push({
            src: $(this).attr('href'),
            title: $(this).attr('data-title')
        });
        });

        new PhotoViewer(items, options);

    });


     function datatableFilter (fn ='' , status='' ,filters=''){
        $.fn.DataTable.ext.pager.numbers_length = 7;
        table = $("#example").DataTable({
            lengthChange: false,
            // iDisplayLength: 10,
            dom: "<'row'<'col-sm-12 col-md-12 col-lg-8'l><'col-sm-12 col-md-12 col-lg-4'f>>" +
                "<'row'<'col-sm-12 col-md-12 col-lg-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5 col-lg-6'i><'col-sm-12 col-md-7 col-lg-6'p>>",
            
            "aaSorting": [],
            buttons: [
                {
                    text: `<div class="all_btn btn_noti" >???????????????????????????????????????????????????</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'all');
                    } },
                    {
                    text: `<div class="wait_pay_btn btn_noti" >??????????????????????????????</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'wait-for-pay');
                    } },
                    {
                    text: `<div class="check_btn btn_noti" >??????????????????????????? 
                    <small class="check_span text-white span_noti" >0</small></div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'check');
                        
                    } },
                    {                       
                    text: `<div class="paid_btn btn_noti" >???????????????????????????????????? 
                    <small class="paid_span text-white span_noti" >0</small></div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'paid');

                    } },
                    {
                    text: `<div class="refund_btn btn_noti" >??????????????????????????? 
                    <small class="refund_span text-white span_noti" >0</small></div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'refund');
  
                    } },
                    
                    {
                    text: '<div class="cancel_btn btn_noti" >??????????????????</div>',
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                        action: function(e, dt, node, config) {
                            $("#example").DataTable().clear().destroy();
                            // $('#example tbody').empty().Add();
                            datatableFilter('trash','cancel');
                            // $('#header_title').html("Customer Order [ ?????????????????? ]");
                        }
                    },
                    // <li class="dropdownFiltersli">
                    //     <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckAll">
                    //     <input class="filtersCheck filters_active" type="checkbox" value="" id="filtersCheckAll"><font class=""> ????????????????????????????????????</font></a>
                    // </li>
                    {
                    text: `<div class="dropdown">
                <button class="btn btn-default  dropdownFiltersStyle " type="button" id="dropdownMenu1" role="button" type="button" data-toggle="dropdown">
                    <font class="float-left pl-2"><img src="{{ url('img/icon_pages/filters.png') }}">    <font class="pl-2">Filters</font> <small class="noti_filters"></small>   </font> 
                    <font class="float-right"><img src="{{ url('img/icon_pages/arrow_down.png') }}"></font>        
                          
                </button>
                <ul class="dropdown-menu dropdownOptionFiltersStyle">
                    
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckSendback">
                        <input class="filtersCheck" type="checkbox" value="" id="filtersCheckSendback"> <font class="">?????????????????????</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckWaitSend">
                        <input class="filtersCheck" type="checkbox" value="" id="filtersCheckWaitSend"> <font class="">??????????????????????????????????????????</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckSended">
                        <input class="filtersCheck" type="checkbox" value="" id="filtersCheckSended"> <font class="">???????????????????????????????????????????????????????????????</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckWaitApproveEbook">
                        <input class="filtersCheck text-black" type="checkbox"  value="" id="filtersCheckWaitApproveEbook"> <font class="">??????????????????????????? E-Book</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckApprovedEbook">
                        <input class="filtersCheck" type="checkbox" value="" id="filtersCheckApprovedEbook"> <font class="">????????????????????? E-Book</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckCancelPeriod">
                        <input class="filtersCheck" type="checkbox" value="" id="filtersCheckCancelPeriod"> <font class="">???????????????????????????????????????????????????</font></a>
                    </li>
                    
                </ul>
            </div>`,
            className: 'border-0 bg-white ml-1 m-0 p-0',
                   
                    },
                    
            ],
            

            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/order') }}",
                type: 'GET',
                data: {
                    fn: fn,
                    status: status ,
                    filters:filters
                },
                
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [{
                    data: ({DT_RowIndex})=>{
                        return `<span class="p-1 pl-2 pr-2" style="background-color: #EBEEF3 ;border-radius:10px;color:#092C4C;font-weight:600;"> ${DT_RowIndex} </span>`;
                    },
                    name: 'DT_RowIndex',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: ({id}) => {
                        // console.log(data.get_tranfer.id);
                        //var url = "{{ url('admin/order') }}/"+id
                        var html = ''; 
                        html += '<a href="javascript:void(0) " style="color:#FFC258; font-weight: 500" class="viewOrderDetailBtn" data-id="'+id+'" ><strong>'+id+'</strong></a> ' ;
                        // if(data.get_tranfer){
                        //     html += '<a href="payInSlip/'+data.get_tranfer.id+'" style="color:black"><i class="fas fa-receipt"></i></a>';
                        // }
                        return html;
                    },
                    name: 'id'
                },
                {
                    data: ({order_date , order_time}) => {
                        
                        return `<span class="d-block"><b>${order_date}</b></span>
                        <span class="d-block"><b><i class="far fa-clock" style="color:#092c4c"></i> ${order_time}</b></span>`;
                    },
                    name: 'order_date'
                },
                {
                    data: ({username}) => username ? `<strong class="text-color_main">${username}</strong>` : `<strong class="text-color_main">-</strong>`,
                    name: 'username'
                },
                {
                    data: (data) => {
                       return `<strong class="text-color_main">${(Number(data.net_price)+Number(data.transport_rate)).toFixed(2)}</strong>`;
                    },
                    name: 'net_price'
                },
                {
                    data: 'book_type',
                    name: 'book_type',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_status_action',
                    name: 'order_status',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: ({id , order_status, book_available ,tracking_number =''}) => {
                        
                        html = '';
                        html += '<a href="javascript:void(0)" data-id="'+id+'" class="btn btn-light view-data viewDataBtn">????????????????????????</a>'; 

                        if( (order_status == "????????????????????????????????????") && (book_available == "y" || book_available == null)){
                            if(tracking_number){
                                html += '<a href="javascript:void(0)" class="car-success" data-toggle="popover" data-content="???????????????????????????????????????????????????????????????" data-trigger="hover" data-placement="bottom">';
                                html += '<img src="'+"{{url('img/icon_pages/car_success.png')}}"+'"></a>';
                            }else{
                                html += '<a href="javascript:void(0)" class="car-warning" data-toggle="popover" data-content="???????????????????????????????????????????????????" data-trigger="hover" data-placement="bottom">';
                                html += '<img src="'+"{{url('img/icon_pages/car_warning.png')}}"+'"></a>';
                            }
                            
                        }
                        return html;
                    },
                    name: 'tracking_number'
                },
                
                
                {
                    data: 'action',
                    name: 'action',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
            ],
            fnDrawCallback: function(oSettings) {
                $('[data-toggle="popover"]').popover();
                // $("#action_des_order_new").niceScroll();
                countNoti();
                countNotiSidebar();

                
            },
            initComplete: function(settings, json) {

                
                table.buttons().container()
                    .appendTo($('.col-md-12:eq(0)', table.table()
                        .container())); //show button on datatable


                        // table.button( 1 ).processing( true );
                // table.buttons().container()
                // .appendTo( table.table().container()  ); //show button on datatable
                new $.fn.dataTable.FixedHeader(table);
                if(status == "wait-for-pay"){
                    $(".wait_pay_btn").css("color", "").addClass("border_buttom_active");
                }else if (status == "check"){                    
                    $(".check_btn").css("color", "").addClass("border_buttom_active");
                    $(".check_span").css("background-color", "").addClass("color_span_active");
                }else if (status == "paid"){                    
                    $(".paid_btn").css("color", "").addClass("border_buttom_active");
                    $(".paid_span").css("background-color", "").addClass("color_span_active");
                }else if (status == "refund"){                    
                    $(".refund_btn").css("color", "").addClass("border_buttom_active");
                    $(".refund_span").css("background-color", "").addClass("color_span_active");
                }
                else if(status == "sent"){
                    $(".sent_btn").css("color", "").addClass("border_buttom_active");
                }else if(status == "cancel"){
                    $(".cancel_btn").css("color", "").addClass("border_buttom_active");
                }else if (status == "all") {
                    $(".all_btn").css("color", "").addClass("border_buttom_active");
                }

                
                switch(filters) {
                    // case "filtersCheckAll":
                    //     $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                    //     $(".noti_filters").html("3");   
                    //     $("#filtersCheckAll").prop( "checked", true ); 
                    //     $("#filtersCheckSendback").prop( "checked", true );   
                    //     $("#filtersCheckWaitSend").prop( "checked", true );     
                    //     $("#filtersCheckWaitApproveEbook").prop( "checked", true );                   
                    //     break;
                    case "filtersCheckSendback":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("1");
                        $("#filtersCheckSendback").prop( "checked", true );      
                        break;
                    case "filtersCheckWaitSend":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("1");
                        $("#filtersCheckWaitSend").prop( "checked", true );      
                        break;
                    case "filtersCheckSended":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("1");
                        $("#filtersCheckSended").prop( "checked", true );      
                        break;                        
                    case "filtersCheckWaitApproveEbook":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("1");
                        $("#filtersCheckWaitApproveEbook").prop( "checked", true );      
                        break;
                    case "filtersCheckApprovedEbook":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("1");
                        $("#filtersCheckApprovedEbook").prop( "checked", true );      
                        break;
                    case "filtersCheckCancelPeriod":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("1");
                        $("#filtersCheckCancelPeriod").prop( "checked", true );      
                        break;
                        
                        
                }

                
            },
        });
    }

});
</script>
@endsection
