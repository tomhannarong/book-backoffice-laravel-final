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
          <div class="col-sm-6">
            <h1>Contact</h1>        
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Contact</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<div class="row justify-content-center p-3">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                    <h3 class="card-title">TABLE</h3>
                    <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
            </div>
            <div class="card-body ">
                <div class="table-responsive">
                    <table id="example" class="table text-center text-middle table-fixed" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">ที่</th>
                            <th>วันที่</th>
                            <th>เรื่อง</th>
                            <th>ชื่อ - สกุล</th>
                            <th>อีเมล์</th>
                            <th>เบอร์โทร</th>
                            <th width="5%">สถานะ</th>
                            <th width="15%">Action</th>
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
    $('body').on('click', '.isCheckPublic', function() {
        Item_id = $(this).data("id");
        Value = $(this).data("value");
        //alert(Value);
        if(Value === "on"){
            Value = "n";
            // $("h1").addClass("page-header highlight");
            // $("h1").removeClass("page-header");
            // $(selector).html()
        }else if (Value === "off"){
            Value = "y";
        }

        $.ajax({
           type:'POST',
           url:"{{ url('admin/slide') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , status:Value , fn: "public" },
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
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: (data) => data.created_at ? data.created_at : "-",
                    name: 'created_at'
                },
                {
                    data: (data) => data.topic ? data.topic : "-",
                    name: 'topic'
                },
                {
                    data: (data) => data.name ? data.name : "-",
                    name: 'name'
                },
                {
                    data: (data) => data.email ? data.email : "-",
                    name: 'email'
                },
                {
                    data: (data) => data.tel ? data.tel : "-",
                    name: 'tel'
                },
                {
                    data: (data) => {
                        if(data.read == "true"){
                            return '<h5><span class="badge badge-dark">เปิดอ่านแล้ว</span></h5>';
                        }else{
                            return '<h5><span class="badge badge-success">ยังไม่เคยเปิดอ่าน</span></h5>';
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
