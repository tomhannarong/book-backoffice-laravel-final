@extends('../layouts.app')

@section('menu_ebook_consignment_open' , 'menu-open')
@section('menu_ebook_consignment_open_active' , 'active')

@section('menu_ebook_consignment' , 'active')



@section('css')
<!-- App Custom CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/back-office/order.style.css') }}" />
<!-- Jquery image zoom -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/Jquery-image-zoom/css/main.css') }}" />
<style>

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
                                <th width="">Book Type</th>
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
                <h3 class="modal-title"><img src="{{ url('img/icon_pages/icon_slip.png') }}"> <font class="pl-2">ตรวจสอบสลิป</font></h3>
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
                <h3 class="modal-title"><img src="{{ url('img/icon_pages/car_large.png') }}"> <font class="pl-2">การจัดส่ง</font></h3>
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
    //                             title: 'ทำรายการสำเร็จ',
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
        
        let emsVal = $("#tracking_number").val();
        let order_id = $(this).data('id');
        if(emsVal){
        
            Swal.fire({
                title: 'ยืนยันเลขพัสดุ?',
                text: "คุณตรวจสอบและยืนยันการทำรายการนี้",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2DC8A8',
                cancelButtonColor: 'dark',
                confirmButtonText: 'ยืนยัน' ,
                cancelButtonText: 'ปิด'
            }).then((result) => {
                if (result.value) {
                   
                    // $.LoadingOverlay("show");
                    let title = "Cannot update this record.";
                    var url = theForm.attr('action');
                    $.ajax({
                        url: "{{ url('admin/order') }}" + '/' + order_id,
                        type: "POST",
                        data: {_token: "{{ csrf_token() }}" , _method: 'PUT' , 'tracking_number':$('#tracking_number').val() },
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
                                    title: 'ทำรายการสำเร็จ',
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
        if(Item === "รอชำระเงิน"){
            Toast.fire({
                icon: 'error',
                title: 'Please Pending Payment.'
            });
           // alert("รอตัง จ้าา");
        }else if(Item === "รอตรวจสอบ"){
            Toast.fire({
                icon: 'error',
                title: 'Please check pay-in-slip.'
            });
           // alert("รอตัง จ้าา");
        }else if(Item === "ชำระเงินแล้ว"){
            showNextStage();
            // if(!Item_ems){
            //     //alert("ems จ้าา");
            //     Toast.fire({
            //         icon: 'error',
            //         title: 'Please enter tracking number.'
            //     });
            // }else{
            //     showNextStage();
            // }
        }else if(Item === "ส่งสินค้าแล้ว") {
            Toast.fire({
                icon: 'error',
                title: 'Order Completed.'
            });
        }

        function showNextStage(){
            Swal.fire({
                title: 'ระบุเลขพัสดุ  <i class="fas fa-truck pl-3 pt-1"></i>',
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
                        `กรอกเลขพัสดุด้วยค่ะ`
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
                                        title: 'ยืนยันการจัดส่งเรียบร้อยแล้วค่ะ',
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
            // title: 'ยืนยันการจัดส่ง?',
            // text: "คุณยืนยันการจัดส่งรายการนี้ใช่หรือไม่!",
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
            title: 'ยืนยันการชำระเงิน?',
            text: "คุณตรวจสอบและยืนยันการทำรายการนี้",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2DC8A8',
            cancelButtonColor: 'dark',
            confirmButtonText: 'ยืนยัน' ,
            cancelButtonText: 'ปิด'
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
                                        title: 'ทำรายการสำเร็จ',
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
                                    title: 'อนุมัติ E-Book?',
                                    text: "คุณตรวจสอบและยืนยันการทำรายการนี้",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#2DC8A8',
                                    cancelButtonColor: 'dark',
                                    confirmButtonText: 'ยืนยัน' ,
                                    cancelButtonText: 'ปิด'
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
                                                        title: 'ทำรายการสำเร็จ',
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
                            //     title: 'ทำรายการสำเร็จ',
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
            { id: 1, name: 'Item 1' },
            { id: 2, name: 'Item 2' },
            { id: 3, name: 'Item 3' }
        ];

        var options = {};
        $.map(myArrayOfThings,function(o) {
            options[o.id] = o.name;
        });
        
        Swal.fire({
            icon: 'danger',
            title: 'ระบุเหตุผล',
            // input: 'text',,
            text: 'คุณตรวจสอบและยืนยันการทำรายการนี้',
            input: 'select',
            inputOptions: options,
            showCancelButton: true,
            animation: 'slide-from-top',
            inputPlaceholder: 'ระบุเหตุผลในการส่งกลับ',
            confirmButtonColor: '#2DC8A8',
            cancelButtonColor: 'dark',
            confirmButtonText: 'ยืนยัน' ,
            cancelButtonText: 'ปิด',
            inputAttributes: {
                autocapitalize: 'off'
            },
            // showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: (res) => {
                if(res){
                    // alert(res)
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                        data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn,reason:res},
                        // success: (response) => {
                        //     if ($.isEmptyObject(response.error)) {
                        //         // Swal.fire({
                        //         //     icon: 'success',
                        //         //     title: "ส่งกลับเรียบร้อยแล้วค่ะ",
                        //         //     text: "ERROR: " + response.error,
                        //         // });
                        //         // Swal.fire({
                        //         //     position: 'top-end',
                        //         //     icon: 'success',
                        //         //     title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                        //         //     showConfirmButton: false,
                        //         //     timer: 1500
                        //         // })
                        //         // console.log(response);
                        //         // Swal.fire({
                        //         //     title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                        //         //     icon: 'success',
                        //         // }).then((value) => {
                        //         //     window.history.back();
                        //         // });
                        //     } 
                        // },
                    });
                }else{
                    Swal.showValidationMessage(
                    `กรอบเหตุผลด้วยค่ะ`
                    )
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'ทำรายการสำเร็จ',
                    showConfirmButton: false,
                    iconColor: '#ffffffff',
                    timer: 1500,
                }).then((value) => {
                    // window.history.back();
                    table.ajax.reload(null, false);
                });
            }
        })
    });
    
    
    $('body').on('click', '.reOrderBtn', function() {
        Item_id = $(this).data('id');
        Item_fn = $(this).data("fn");
        Item_val = $(this).data("val");
        
        $.ajax({
           type:'POST',
           url:"{{ url('admin/order') }}" + "/" + Item_id,
           data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item_val, fn:Item_fn},
           success: (response) => {
            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 800,
                    }).then((result) => {
                        table.ajax.reload(null, false);
                    });
                } else {
                    console.log(response.error);
                }
            }
        });    
    });

    $('body').on('click', '.detailBtn', function() {
        Item_id = $(this).data('id');
        window.location='{{ url("admin/order") }}'+'/'+Item_id;
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
                datatableFilter(ACTION,'wait-for-pay','filtersCheckSendback');
                break;
            case "filtersCheckWaitSend":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'paid','filtersCheckWaitSend');
                break;
            case "filtersCheckWaitApproveEbook":
                $("#example").DataTable().clear().destroy();
                datatableFilter(ACTION,'all','filtersCheckWaitApproveEbook');
                break;
        }
        
        
        
        
        // alert(Item_val);
        // Item_id = $(this).data('id');
        // window.location='{{ url("admin/order") }}'+'/'+Item_id;
    });

    
    $('body').on('click', '.deleteBtn', function() {        
        let Item_id = $(this).data("id");
        // let Item_fn = $(this).data("fn");
        var textSw = "คุณยืนยันที่จะยกเลิกรายการนี้ใช่หรือไม่! เมื่อยกเลิกแล้วสินค้าในรายการนี้ทั้งหมดจะถูกคืนเข้าสู้ Stock";
        // if(Item_fn){
        
            // textSw ="คุณยืนยันที่จะลบรายการนี้แบบถาวร!";
        
        // }else{
        var myArrayOfThings = [
            { id: 1, name: 'Item 1' },
            { id: 2, name: 'Item 2' },
            { id: 3, name: 'Item 3' }
        ];

        var options = {};
        $.map(myArrayOfThings,function(o) {
            options[o.id] = o.name;
        });
            Swal.fire({
                icon: 'danger',
                title: 'ระบุเหตุผล',
                // input: 'text',,
                text: 'ระบุเหตุผลในการยกเลิก เมื่อยกเลิกแล้วสินค้าในรายการนี้ทั้งหมดจะถูกคืนเข้าสู่ Stock ',
                input: 'select',
                inputOptions: options,
                showCancelButton: true,
                animation: 'slide-from-top',
                inputPlaceholder: 'ระบุเหตุผลในการยกเลิก',
                confirmButtonColor: '#2DC8A8',
                cancelButtonColor: 'dark',
                confirmButtonText: 'ยืนยัน' ,
                cancelButtonText: 'ปิด',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showLoaderOnConfirm: true,
                preConfirm: (res) => {
                    if(res){
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/order') }}" + '/' + Item_id,
                            data: {_method: 'DELETE' ,'reason':res},
                        });
                    }else{
                        Swal.showValidationMessage(
                        `โปรดระบุเหตุผลในการยกเลิก`
                        )
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'ทำรายการสำเร็จ',
                        showConfirmButton: false,
                        iconColor: '#ffffffff',
                        timer: 1500,
                    }).then((value) => {
                        // window.history.back();
                        // window.location='{{ url("admin/order") }}'
                        table.ajax.reload(null, false);
                    });
                    
                }
            })
        // }

        //alert(Item_fn);
        // Swal.fire({
        //     title: 'ยืนยันการยกเลิก?',
        //     text: textSw,
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, delete it!'
        // }).then((result) => {
        //     if (result.value) {
        //         $.ajax({
        //             type: "POST",
        //             url: "{{ url('admin/order') }}" + '/' + Item_id,
        //             data: {_method: 'DELETE' , fn:Item_fn},
        //             success: (response) => {
        //                 console.log(response);
        //                 if ($.isEmptyObject(response.error)) {
        //                     console.log(response.success);
        //                     Swal.fire(
        //                         'ยกเลิก!',
        //                         'ยกเลิกรายการเรียบร้อยแล้วค่ะ.',
        //                         'success'
        //                     ).then((result) => table.ajax.reload(null, false));
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
                    text: `<div class="all_btn btn_noti" >คำสั่งซื้อทั้งหมด</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'all');
                    } },
                    {
                    text: `<div class="wait_pay_btn btn_noti" >รอชำระเงิน</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'wait-for-pay');
                    } },
                    {
                    text: `<div class="check_btn btn_noti" >รอตรวจสอบ 
                    <small class="check_span text-white span_noti" >0</small></div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'check');
                        
                    } },
                    {                       
                    text: `<div class="paid_btn btn_noti" >ชำระเงินแล้ว 
                    <small class="paid_span text-white span_noti" >0</small></div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'paid');

                    } },
                    {
                    text: `<div class="refund_btn btn_noti" >ขอคืนเงิน 
                    <small class="refund_span text-white span_noti" >0</small></div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'refund');
  
                    } },
                    
                    {
                    text: '<div class="cancel_btn btn_noti" >ยกเลิก</div>',
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                        action: function(e, dt, node, config) {
                            $("#example").DataTable().clear().destroy();
                            // $('#example tbody').empty().Add();
                            datatableFilter('trash','cancel');
                            // $('#header_title').html("Customer Order [ ยกเลิก ]");
                        }
                    },
                    {
                    text: `<div class="dropdown">
                <button class="btn btn-default  dropdownFiltersStyle " type="button" id="dropdownMenu1" role="button" type="button" data-toggle="dropdown">
                    <font class="float-left pl-2"><img src="{{ url('img/icon_pages/filters.png') }}">    <font class="pl-2">Filters</font> <small class="noti_filters"></small>   </font> 
                    <font class="float-right"><img src="{{ url('img/icon_pages/arrow_down.png') }}"></font>        
                          
                </button>
                <ul class="dropdown-menu dropdownOptionFiltersStyle">
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckAll">
                        <input class="filtersCheck filters_active" type="checkbox" value="" id="filtersCheckAll"><font class=""> เลือกทั้งหมด</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckSendback">
                        <input class="filtersCheck" type="checkbox" value="" id="filtersCheckSendback"> <font class="">ส่งกลับ</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckWaitSend">
                        <input class="filtersCheck" type="checkbox" value="" id="filtersCheckWaitSend"> <font class="">รอจัดส่งสินค้า</font></a>
                    </li>
                    <li class="dropdownFiltersli">
                        <a href="javascript:void(0)" class="checkboxFilters" data-val="filtersCheckWaitApproveEbook">
                        <input class="filtersCheck text-black" type="checkbox"  value="" id="filtersCheckWaitApproveEbook"> <font class="">รออนุมัติ E-Book</font></a>
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
                        html += '<a href="javascript:void(0)" data-id="'+id+'" class="btn btn-light view-data viewDataBtn">ดูข้อมูล</a>'; 

                        if( (order_status == "ชำระเงินแล้ว") && (book_available == "y" || book_available == null)){
                            if(tracking_number){
                                html += '<a href="javascript:void(0)" class="car-success" data-toggle="popover" data-content="จัดส่งสินค้าเรียบร้อย" data-trigger="hover" data-placement="bottom">';
                                html += '<img src="'+"{{url('img/icon_pages/car_success.png')}}"+'"></a>';
                            }else{
                                html += '<a href="javascript:void(0)" class="car-warning" data-toggle="popover" data-content="รอการจัดส่งสินค้า" data-trigger="hover" data-placement="bottom">';
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
                    case "filtersCheckAll":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("3");   
                        $("#filtersCheckAll").prop( "checked", true ); 
                        $("#filtersCheckSendback").prop( "checked", true );   
                        $("#filtersCheckWaitSend").prop( "checked", true );     
                        $("#filtersCheckWaitApproveEbook").prop( "checked", true );                   
                        break;
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
                    case "filtersCheckWaitApproveEbook":
                        $(".noti_filters").addClass("text-white span_noti color_span_active pr-2");
                        $(".noti_filters").html("1");
                        $("#filtersCheckWaitApproveEbook").prop( "checked", true );      
                        break;
                }

                
            },
        });
    }

});
</script>
@endsection
