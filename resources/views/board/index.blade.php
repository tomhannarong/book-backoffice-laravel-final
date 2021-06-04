@extends('../layouts.app')

@section('menu_board' , 'active')

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
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-4 pl-4">
                <font id="header_title" class="header_title">Settings & Privacy </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Webboard</ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<div class=" justify-content-center py-4">
    <div class="">
        <div class="card" style="border: none">
            <div class="card-header text-center">
                <ul class="nav nav-tabs card-header-tabs ">
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                            <strong class="span_vertical_active">
                                Webboard 
                            </strong>  
                            
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body text-middle">
                <div class="text-middle">
                    <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% ">
                    <thead class="" style="background-color:#ebeef3;color:#7F92A3">
                        <tr>
                            <th width="5%" class="border_conner_left text-left"></th>
                            <th>วันที่</th>
                            <th>หัวข้อ</th>
                            <th>โดย</th>
                            <th>ยอดวิว</th>
                            <th width="5%">ปักหมุด</th>
                            <th width="5%">สถานะ</th>
                            <th width="20%" class="border_conner_right">Action</th>
                        </tr>
                    </thead>

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
    var table, Item_id = null;

    datatableFilter();

    $('body').on('click', '.editBtn', function() {
        Item_id = $(this).data('id');
        window.location = "{{ url('admin/board')}}" + '/' + Item_id + '/edit' ;
    });

    $('body').on('click', '.viewReply', function() {
        Item_id = $(this).data('id');
        window.location = "{{ url('admin/board')}}" + '/' + Item_id ;
    });

    $('body').on('click', '.isCheckPin', function() {
        Item_id = $(this).data("id");
        Value = $(this).data("value");
        //alert(Value);
        if(Value === "on"){
            Value = "n";
        }else if (Value === "off"){
            Value = "y";
        }

        $.ajax({
           type:'POST',
           url:"{{ url('admin/board') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , status:Value , fn: "pin" },
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
                    }).then((result) => {
                        //table.ajax.reload(null, false);
                        table.clear().destroy();
                        
                        datatableFilter();
                    });
                } else {
                    console.log(response.error);
                }
            }
        });
    });

    $('body').on('click', '.isCheckPublic', function() {
        Item_id = $(this).data("id");
        Value = $(this).data("value");
        //alert(Value);
        if(Value === "on"){
            Value = "no";
            // $("h1").addClass("page-header highlight");
            // $("h1").removeClass("page-header");
            // $(selector).html()
        }else if (Value === "off"){
            Value = "yes";
        }

        $.ajax({
           type:'POST',
           url:"{{ url('admin/board') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , status:Value , fn: "public" },
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
                    }).then((result) => {
                        //table.ajax.reload(null, false);
                        table.clear().destroy();
                        
                        datatableFilter();
                    });
                } else {
                    console.log(response.error);
                }
            }
        });
    });
    

    $('body').on('click', '.deleteBtn', function() {
        Item_id = $(this).data("id");
        Swal.fire({
            title: 'ลบ?',
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
                    url: "{{ url('admin/board') }}" + '/' + Item_id,
                    data :{ _method: 'DELETE'},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'ทำรายการสำเร็จ',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                timer: 1500,
                            }).then((result) => table.ajax.reload(null, false));
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

    function datatableFilter() {
        table = $("#example").DataTable({
            // lengthChange: true,
            // iDisplayLength: 10,

            "aaSorting": [],
            buttons: [{
                    text: 'เพิ่มเว็บบอร์ด',
                    className: 'btn btn-lg btn-success-custom',
                    action: function(e, dt, node, config) {
                        window.location = "{{ url('admin/board/create')}}";
                    }
                }
            ],
           
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/board') }}",
                type: 'GET',
            }, 
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
                    data: ({post_date}) => {
                        const dateTime = post_date.split(' ');
                        const date = dateTime[0];
                        const time = dateTime[1];
                        
                        return `<span class="d-block"><b>${date}</b></span>
                        <span class="d-block"><b><i class="far fa-clock" style="color:#092c4c"></i> ${time}</b></span>`;
                    },
                    name: 'post_date'
                },
                {
                    data: ({topic}) => topic ? `<strong class="text-color_main">${topic}</strong>` : "-",
                    name: 'topic'
                },
                {
                    data: ({username}) => username ? `<strong class="text-color_main">${username}</strong>` : "-",
                    name: 'username'
                },
                {
                    data: ({view}) => { 
                        var html = '<h5 style="display: inline-block;"><span class="badge badge-dark fa-1x">'+(view ? view : "0")+'</span></h5>' 
                        return html ;
                        },
                    name: 'view'
                },
                {
                    data: 'pin',
                    name: 'pin',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },   
                {
                    data: 'public',
                    name: 'public',
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
                    .appendTo($('.col-md-12:eq(0)', table.table()
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
