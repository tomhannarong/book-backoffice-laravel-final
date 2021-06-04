@extends('../layouts.app')

@section('menu_pay_in_slip' , 'active')

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
            <h1 id="header_title">Pay-in Slip [ E-Books ]</h1>        
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Pay-in Slip E-Books</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <div class="row justify-content-center p-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/payInSlip') }}">Pay-in Slip [ Books <span class="badge badge-warning"><font id="noti_book" size="4">{{ $noti_books }}</font></span> ]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" style="color:black;background-color: MintCream" href="{{ url('admin/payInSlipEbook') }}"><b>Pay-in Slip [ E-Books <span class="badge badge-warning"><font id="noti_ebook" size="4">{{ $noti_ebooks }}</font></span> ]</b></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered table-fixed" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="row" width="2%">ที่</th>
                                    <th width="20%">ผู้โอน</th>
                                    <th width="20%">วันที่</th>
                                    <th width="10%">จำนวน</th>
                                    <th width="25%">ธนาคาร</th>
                                    <th width="3%">เลขที่ใบสั่งซื้อ</th>
                                    <th width="30%">อื่นๆ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th scope="row" width="2%">ที่</th>
                                    <th width="20%">ผู้โอน</th>
                                    <th width="20%">วันที่</th>
                                    <th width="10%">จำนวน</th>
                                    <th width="25%">ธนาคาร</th>
                                    <th width="3%">เลขที่ใบสั่งซื้อ</th>
                                    <th width="30%">อื่นๆ</th>
                                </tr>
                            </tfoot>

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
    
    var table, Item_id , Item_fn = null;

    datatableFilter();
    
    $('body').on('click', '.verifyBtn', function() {
        Item_id = $(this).data('id');
        window.location='{{ url("admin/payInSlipEbook") }}'+'/'+Item_id;   
    });

    $('body').on('click', '.reOrderBtn', function() {
        Item_id = $(this).data('id');
        Item_id_order = $(this).data('id-order');
        Item_fn = $(this).data("fn");
        $.ajax({
           type:'POST',
           url:"{{ url('admin/payInSlipEbook') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_order:Item_id_order, fn:Item_fn},
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
                    }).then((result) => table.ajax.reload(null, false));
                } else {
                    console.log(response.error);
                }
            }
        });    
    });
    
    $('body').on('click', '.deleteBtn', function() {
        Item_id = $(this).data("id");
        Item_fn = $(this).data("fn");
        var textSw = "You won't be Deleted To Trash! ";
        if(Item_fn) textSw ="You won't be able to revert this!";
        //alert(Item_fn);
        Swal.fire({
            title: 'Are you sure?',
            text: textSw,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/payInSlipEbook') }}" + '/' + Item_id,
                    data:{ _method: 'DELETE' , fn:Item_fn},
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

    function datatableFilter(fn ='') {
        table = $("#example").DataTable({
            lengthChange: true,
            iDisplayLength: 10,
            bFilter: true,
            // destroy: true,
            // searching: false,
            //dom: 'Bfrtip',
            "aaSorting": [],
            pagingType: "full_numbers",
            buttons: [{
                    text: '<i class="nav-icon fas fa-sync-alt"></i> Refresh [ E-Books ]',
                    className: 'btn btn-lg btn-success',
                    action: function(e, dt, node, config) {
                        //window.location='{{ route("stock.index") }}'
                        $("#example").DataTable().clear().destroy();
                        datatableFilter();
                        var d = new Date($.now());
                        var formatDate = d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
                        $('#header_title').html("Pay-in Slip [ E-Books ] [ "+formatDate+" ] ");
                    }
                },
                {
                    text: '<i class="fas fa-trash-alt"></i> Trash',
                    className: 'btn btn-lg btn-dark',
                    action: function(e, dt, node, config) {
                        $("#example").DataTable().clear().destroy();
                        datatableFilter("trash");
                        $('#header_title').html("Pay-in Slip [ E-Books ] [ Trash ]");
                    }
                }
            ],
            language: {
                lengthMenu: "แสดงข้อมูล _MENU_ ข้อมูล",
                zeroRecords: "ไม่มีข้อมูล",
                info: "แสดงข้อมูลตั้งแต่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล",
                infoEmpty: "ไม่มีข้อมูลที่แสดงอยู่",
                infoFiltered: "(filtered from _MAX_ total records)",
                search: "ค้นหา:",
                loadingRecords: "กำลังโหลด...",
                //processing: "กำลังประมวลผล...",
                //processing: '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i>',
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
                url: "{{ url('admin/payInSlipEbook') }}",
                type: 'GET',
                data: {
                    fn: fn
                },
            }, 
            responsive: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: (data) => data.username_customer ? data.username_customer : "-",
                    name: 'username_customer'
                },
                {
                    data: (data)  => data.post_date ? data.post_date : "-",
                    name: 'post_date'
                },
                {
                    data: (data) => data.total_order ? data.total_order : "-",
                    name: 'total_order'
                },
                {
                    data: (data) => data.bank ? data.bank : "-",
                    name: '	bank'
                },
                {
                    data: (data) => data.order_id ? data.order_id : "-",
                    name: 'order_id'
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
