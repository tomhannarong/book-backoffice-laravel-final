@extends('../layouts.app')

@section('menu_member_menu_open' , 'menu-open')
@section('menu_member_menu_open_active' , 'active')
@section('menu_member' , 'active')

@section('css')

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
                <li class="breadcrumb-item active">Members Consignment</ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <div class="justify-content-center py-4">
        <div class="" style="border: none">
            <div class="card ">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link color_span_active nav-link-header text-white nav-item-left" href="{{ route('member.index') }}"><strong class="span_vertical">Members List</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-header  active"  href="{{ route('memberConsignment.index') }}"><strong class="span_vertical_active ">Register Consignment</strong></a>
                        </li>
                    
                    </ul>
                </div>
    
                <div class="card-body text-middle">
                    <div class="text-middle">
                    <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% "> <!--class nowrap-->
                        <thead style="background-color:#ebeef3;color:#7F92A3 ">
                            <tr>
                                <th  width="5%" class="border_conner_left text-left"></th>
                                <th >username</th>
                                <th >E-mail</th>
                                <th >ชื่อ - สกุล</th>
                                <th width="20%">สถานะ</th>
                                <th width="10%" class="border_conner_right">Action</th>
                            </tr>
                            
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.content-wrapper -->



@endsection

@section('js')
<script>
$(function() {
    var table, Item_id , Value = null;

    datatableFilter();

    $('body').on('click', '.editBtn', function() {
        Item_id = $(this).data('id');
        window.location='{{ url("admin/member") }}' + '/'+Item_id+'/edit ';
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
                    url: '{{ url("admin/member") }}' + '/' + Item_id,
                    data :{ _method: 'DELETE'},
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
            // lengthChange: false,
            // iDisplayLength: 10,
            // bFilter: true,
            aaSorting: [
            ],
          
            processing: true,
            serverSide: true,
            ajax: "{{ route('memberConsignment.index') }}",
            
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
                    data: ({username}) => username ? `<strong class="text-color_main">${username}</strong>` : "-",
                    name: 'username'
                },
                {
                    data: ({email}) => email ? `<strong class="text-color_main">${email}</strong>` : "-",
                    name: '	email'
                },
                {
                    data: ({name}) => name ? `<strong class="text-color_main">${name}</strong>` : "-",
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status',
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
            // initComplete: function() {
            //     table.buttons().container()
            //         .appendTo($('.col-md-6:eq(0)', table.table()
            //             .container())); //show button on datatable
            //     // table.buttons().container()
            //     // .appendTo( table.table().container()  ); //show button on datatable
            //     new $.fn.dataTable.FixedHeader(table);
                
                
            // },
        });
    }

});
</script>
@endsection
