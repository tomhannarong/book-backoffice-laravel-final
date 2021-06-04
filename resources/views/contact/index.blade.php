@extends('../layouts.app')

@section('menu_contact' , 'active')

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
                <font id="header_title" class="header_title">Member Menu </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Contact</ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<div class="justify-content-center py-4">
    <div class="">
        <div class="card" style="border: none">
            <div class="card-header text-center">
                <ul class="nav nav-tabs card-header-tabs ">
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header active nav-item-left"   href="{{ url('admin/contact') }}">
                            <strong class="span_vertical_active">
                                Contact 
                            </strong>  
                            
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body text-middle">
                <div class="text-middle">
                    <table id="example" class="table text-left  table-fixed" cellspacing="0" style="width:100% ">
                    <thead class="" style="background-color:#ebeef3;color:#7F92A3">
                        <tr>
                            <th width="2%" class="border_conner_left text-left"></th>
                            <th>วันที่</th>
                            <th>เรื่อง</th>
                            <th>ชื่อ - สกุล</th>
                            <th>อีเมล์</th>
                            <th>เบอร์โทร</th>
                            <th width="15%">สถานะ</th>
                            <th width="15%" class="border_conner_right">Action</th>
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

    $('body').on('click', '.viewBtn', function() {
        Item_id = $(this).data('id');
        window.location = "{{ url('admin/contact')}}" + '/' + Item_id ;
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
                    url: "{{ url('contact') }}" + '/' + Item_id,
                    data :{ _method: 'DELETE'},
                    success: (response) => {
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

    function datatableFilter() {
        table = $("#example").DataTable({
            // lengthChange: true,
            // iDisplayLength: 10,
            // bFilter: true,
            "aaSorting": [],
           
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/contact') }}",
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
                    data: ({created_at}) => {
                        const dateTime = created_at.split(' ');
                        const date = dateTime[0];
                        const time = dateTime[1];
                        
                        return `<span class="d-block"><b>${date}</b></span>
                        <span class="d-block"><b><i class="far fa-clock" style="color:#092c4c"></i> ${time}</b></span>`;
                    },
                    name: 'order_date'
                },
                {
                    data: ({topic}) => topic ? '<strong class="text-color_main">'+topic+'</strong>' : "-",
                    name: 'topic'
                },
                {
                    data: ({name}) => name ? '<strong class="text-color_main">'+name+'</strong>' : "-",
                    name: 'name'
                },
                {
                    data: ({email}) => email ? '<strong class="text-color_main">'+email+'</strong>' : "-",
                    name: 'email'
                },
                {
                    data: ({tel}) => tel ? '<strong class="text-color_main">'+tel+'</strong>' : "-",
                    name: 'tel'
                },
                {
                    data: ({read}) => {
                        if(read == "true"){
                            return '<h5><span class="badge badge-success payment-status-success"><i class="fas fa-circle"></i> เปิดอ่านแล้ว</span></h5>';
                        }else{
                            return '<h5><span class="badge badge-info payment-status-check"><i class="fas fa-circle"></i> ยังไม่เคยเปิดอ่าน</span></h5>';
                        }                            
                    },
                    name: 'tel'
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
                new $.fn.dataTable.FixedHeader(table);
            },
        });
    }
});

</script>
@endsection
