@extends('../layouts.app')

@section('menu_order' , 'active')

@section('css')
<style>

</style>
@endsection

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 id="header_title">Customer Order [ E-Books ] </h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Order E-Books</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
    
    <div class="row justify-content-center p-3">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ url('admin/order') }}">Order Books</a>
                    </li>
                    <li class="nav-item" style="">
                        <a class="nav-link active" style="color:black;background-color: MintCream" href="{{ url('admin/orderEbook') }}"><b>Order E-Books</b></a>
                    </li>
                    <li class="nav-item" style="">
                        <a class="nav-link" href="{{ url('admin/approve') }}">Approve E-Books</a>
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
                                <th width="3%">ราคา</th>
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
    </div>

    <!-- Modal -->
    <div class="modal fade border border-success " id="theModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close btn btn-danger " data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="theForm" action="{{ url('admin/order') }}" method="POST" typeForm="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">หมายเลขพัสดุ :</label>
                            <input type="text" class="form-control" id="tracking_number" name="tracking_number" aria-describedby="tracking_number"
                                placeholder="Enter tracking number">

                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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

    var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
 
    if(status){
        datatableFilter(ACTION ,status);  
    }else{
        datatableFilter();
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
               

    $('body').on('click', '.changeStatusBtn', function() {
        Item_id = $(this).data("id");
        Item = $(this).data("val");
        Item_ems = $(this).data("ems");
        Item_fn = $(this).data("fn");
        // $.LoadingOverlay("show");
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
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/orderEbook') }}" + '/' + Item_id,
                        data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item , fn:Item_fn},
                        success: (response) => {
                            if ($.isEmptyObject(response.error)) {
                                console.log(response);
                                console.log(response.success);
                                $.LoadingOverlay("hide");
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Your work has been saved',
                                    showConfirmButton: false,
                                    timer: 800,
                                }).then((result) => { window.location='{{ url("admin/orderEbook") }}' });
                            } else {
                                console.log(response.error);
                                $.LoadingOverlay("hide");
                                Swal.fire({
                                    icon: 'error',
                                    title: "Cannot delete records.",
                                    text: "ERROR: " + response.error,
                                });
                            }
                        },
                        error: (response) => {
                            console.log('Error:', response);
                            $.LoadingOverlay("hide");
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
            window.location='{{ url("admin/orderEbook") }}'+'/'+Item_id;
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
                    url: "{{ url('admin/orderEbook') }}" + '/' + Item_id,
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
            lengthChange: true,
            iDisplayLength: 10,
            bFilter: true,
            "aaSorting": [],
            pagingType: "full_numbers",
            buttons: [
                    {
                    text: 'ทั้งหมด',
                    className: 'btn btn-info',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter();
                    } },
                    {
                    text: 'รอชำระเงิน',
                    className: 'btn btn-warning',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'wait-for-pay');
                    } },
                    {
                    text: 'ชำระเงินแล้ว',
                    className: 'btn btn-success',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter(ACTION,'paid');
                    } },
            ],
            language: {
                lengthMenu: "แสดงข้อมูล _MENU_ ข้อมูล",
                zeroRecords: "ไม่มีข้อมูล",
                info: "แสดงข้อมูลตั้งแต่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล",
                infoEmpty: "ไม่มีข้อมูลที่แสดงอยู่",
                infoFiltered: "(filtered from _MAX_ total records)",
                search: "ค้นหา:",
                loadingRecords: "กำลังโหลด...",
                processing: '<i class=" fa fa-spinner fa-spin fa-3x fa-fw " style="font-size:60px;color:red;"></i>',
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ต่อไป",
                    previous: "ย้อนกลับ",
                },
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/orderEbook') }}",
                type: 'GET',
                data: {
                    fn: fn,
                    status: status ,
                },
                
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: (data) => data.id ? data.id : "-",
                    name: 'id'
                },
                {
                    data: (data) => {
                        return data.order_date + " [ " + data.order_time + " ] ";
                    },
                    name: 'order_date'
                },
                {
                    data: (data) => data.username ? data.username : "-",
                    name: 'username'
                },
                {
                    data: (data) => data.total_order ? data.total_order : "-",
                    name: 'total_order'
                },
                {
                    data: 'order_status',
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
            initComplete: function() {
                table.buttons().container()
                    .appendTo($('.col-md-6:eq(0)', table.table()
                        .container())); //show button on datatable
                // table.buttons().container()
                // .appendTo( table.table().container()  ); //show button on datatable
                new $.fn.dataTable.FixedHeader(table);
            },
        });
    }

});
</script>
@endsection
