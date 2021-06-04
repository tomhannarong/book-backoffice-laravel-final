@extends('../layouts.app')

@section('menu_order_open' , 'menu-open')
@section('menu_order_open_active' , 'active')
@section('menu_order_ebook_approve' , 'active')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/back-office/order.style.css') }}" />
<style>
.popover  {
  left:60px !important;
  }
</style>
@endsection

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-4 pl-4">
            <font id="header_title" class="header_title">Order Master Menu</font>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
            <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Custommer Order</ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
    
    <!-- <div class="row justify-content-center p-3">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ url('admin/order') }}">Order </a>
                    </li>
                    <li class="nav-item" style="">
                        <a class="nav-link active" href="{{ url('admin/approve') }}"><b>Approve E-Books</b></a>
                    </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th width="2%">ที่</th>
                                <th width="5%">เลขที่ใบสั่งซื้อ</th>
                                <th width="auto">วันที่</th>
                                <th width="auto">Username</th>
                                <th width="10%">สถานะ order</th>
                                <th width="10%">สถานะ การอ่าน</th>
                                <th width="25%">อื่นๆ</th>
                            </tr>
                        </thead>
                        
                        </table>
                    </div>
                    
                </div>
            </div>

            
        </div>
    </div> -->

    <div class="justify-content-center py-4">
        <div >
        
            <div class="card " style="border: none">
                <div class="card-header text-center">
                <ul class="nav nav-tabs card-header-tabs ">
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header text-white nav-item-left color_span_active "   href="{{ url('admin/order') }}">
                            <strong class="span_vertical">
                                Orders 
                                <span class="right badge badge-danger noti-header-order noti-header-order-all">0</span>
                            </strong>  
                            
                        </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header nav-item-right active " href="{{ url('admin/approve') }}">
                            <strong class=" span_vertical_active">
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
                                <th width="18%">Payment Status</th>
                                <th width="15%">Approve Status</th>
                                <th  width="15%" class="border_conner_right">Off-On Approve E-Book</th>
                            </tr>
                        </thead>
                       <tbody>
                        
                       </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('js')
<script>    
$(function() {
    var theForm = $("#theForm");
    var table, Item_id , Item_val, Item, Item_id_order, Item_fn = null;
    var ACTION ='';
    var status = "{{ $status ?? '' }}" ;
    $('[data-toggle="toggle"]').bootstrapToggle();
    // var Toast = Swal.mixin({
    //                 toast: true,
    //                 position: 'top-end',
    //                 showConfirmButton: false,
    //                 timer: 3000
    //             });
 
    if(status){
        datatableFilter(ACTION ,status);  
    }else{
        datatableFilter(ACTION,'wait-approve');
    }
                // $.ajax({
                //     url: "{{ url('admin/orderEbook') }}",
                //     type: "POST",
                //     data: {_token: "{{ csrf_token() }}" , _method: 'PUT' },
                //     success: (response) => {
                //         if ($.isEmptyObject(response.error)) {
                //             Swal.fire({
                //                 position: 'top-end',
                //                 icon: 'success',
                //                 title: 'Your work has been saved',
                //                 showConfirmButton: false,
                //                 timer: 800,
                //             }).then((result) => table.ajax.reload(null, false));
                //         }
                //     },
                //     error: (response) => {
                //         console.log('Error:', response);
                //         Swal.fire({
                //             icon: 'error',
                //             title: "<strong>" + title + "</strong>",
                //             html: "<strong>Error Code: </strong>" + response
                //                 .status + "<p><strong>Message: </strong>" + JSON
                //                 .stringify(response.responseJSON.message) + "</p>",
                //         })
                //     }
                // });

    $('body').on('change', '.switchApproveBtn', function() {
        let order_id = $(this).data("id");
        let fn = "fnApproveEbook";
        if($(this).prop("checked") == true){
            approveEbook(order_id,fn,"On");
        }else{
            approveEbook(order_id,fn,"Off");
        }
    });
    const approveEbook = (order_id ,fn , value) => {
        $.ajax({
            type: "POST",
            url: "{{ url('admin/approve') }}" + '/' + order_id,
            data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , value:value , fn:fn},
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'ทำรายการสำเร็จ',
                        showConfirmButton: false,
                        iconColor: '#ffffffff',
                        timer: 1500,
                    }).then((value) => {
                        table.ajax.reload(null, false);
                    });
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
    const countNoti = () =>{
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"count_noti"},
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    $(".noti-header-order-all").html(response.noti_order_all);
                    $(".noti-header-approve-ebook").html(response.noti_approve_ebook);
                    $(".wait_approve_span").html(response.noti_approve_ebook);                    
                }
            }
        });    
    }

    $('body').on('click', '.changeStatusBtn', function() {
        Item_id = $(this).data("id");
        Item = $(this).data("val");
        Item_ems = $(this).data("ems");
        Item_fn = $(this).data("fn");
        if(Item === "p"){
            Toast.fire({
                icon: 'error',
                title: 'Please Pending Payment.'
            });
        }else if(Item === "c"){
            Toast.fire({
                icon: 'error',
                title: 'Please check pay-in-slip.'
            });
        }else if(Item === "ชำระเงินแล้ว"){
            showNextStage();
        }else if(Item === "ส่งสินค้าแล้ว") {
            Toast.fire({
                icon: 'error',
                title: 'Order Completed.'
            });
        }
        function showNextStage(){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: 'dark',
            confirmButtonText: 'Yes, Next Stage it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/approve') }}" + '/' + Item_id,
                        data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item , fn:Item_fn},
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
                                }).then((result) => { window.location='{{ url("admin/approve") }}' });
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
        }

        
    });
    

       $('body').on('click', '.detailBtn', function() {
            Item_id = $(this).data('id');
            window.location='{{ url("admin/approve") }}'+'/'+Item_id;
        });

    
    $('body').on('click', '.deleteBtn', function() {
        Item_id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/approve') }}" + '/' + Item_id,
                    data: {_method: 'DELETE' },
                    success: (response) => {
                        console.log(response);
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then((result) => table.ajax.reload(null, false));
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

    function datatableFilter(fn ='' , status='') {
        table = $("#example").DataTable({
            "aaSorting": [],
            buttons: [{
                    text: `<div class="all_btn btn_noti" >รายการอนุมัติ </div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'all');
                    } },
                    {
                    text: `<div class="wait_approve_btn btn_noti" >รออนุมัติ 
                    <small class="wait_approve_span text-white span_noti" >0</small></div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'wait-approve');
                    } },
                    {
                    text: `<div class="approved_btn btn_noti" >อนุมัติ </div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'approved');
                    } },
                    {                       
                    text: `<div class="reject_btn btn_noti" >ไม่อนุมัติ </div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'reject');
                    } },
                    // {
                    // text: 'ทั้งหมด',
                    // className: 'btn btn-info',
                    // action: function(e, dt, node, config) {
                    //     $("#example").DataTable().clear().destroy();
                    //     datatableFilter();
                    // } },
                    // {
                    // text: 'อนุมัติแล้ว',
                    // className: 'btn btn-success',
                    // action: function(e, dt, node, config) {
                    //     $("#example").DataTable().clear().destroy();
                    //     datatableFilter(ACTION,'approve');
                    // } },
                    // {
                    // text: 'ไม่อนุมัติ',
                    // className: 'btn btn-danger',
                    // action: function(e, dt, node, config) {
                    //     $("#example").DataTable().clear().destroy();
                    //     datatableFilter(ACTION,'reject');
                    // } },
            ],
           
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/approve') }}",
                type: 'GET',
                data: {
                    fn: fn,
                    status: status ,
                },
                
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [
                // {
                //     data: 'DT_RowIndex',
                //     name: 'DT_RowIndex',
                //     sortable: false,
                //     orderable: false,
                //     searchable: false
                // },
                // {
                //     data: (data) => data.id ? data.id : "-",
                //     name: 'id'
                // },
                // {
                //     data: (data) => data.approve_date ? data.approve_date : "-",
                //     name: 'approve_date'
                // },
                // {
                //     data: (data) => data.username ? data.username : "-",
                //     name: 'username'
                // },
                {
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
                    data: 'order_status_action',
                    name: 'order_status',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_approve',
                    name: 'order_approve',
                    sortable: false,
                    orderable: false,
                    searchable: false
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
                $('[data-toggle="toggle"]').bootstrapToggle();
                // countNotiWaitApprove();
                countNoti();
                countNotiSidebar();
            },
            initComplete: function() {
                table.buttons().container()
                    .appendTo($('.col-md-12:eq(0)', table.table()
                        .container())); //show button on datatable
                // table.buttons().container()
                // .appendTo( table.table().container()  ); //show button on datatable
                new $.fn.dataTable.FixedHeader(table);
                if (status == "wait-approve"){                    
                    $(".wait_approve_btn").css("color", "").addClass("border_buttom_active");
                    $(".wait_approve_span").css("background-color", "").addClass("color_span_active");
                }else if (status == "approved"){                    
                    $(".approved_btn").css("color", "").addClass("border_buttom_active");
                }else if (status == "reject"){                    
                    $(".reject_btn").css("color", "").addClass("border_buttom_active");
                }else if (status == "all"){                    
                    $(".all_btn").css("color", "").addClass("border_buttom_active");
                }
               
            },
        });
    }

});
</script>
@endsection
