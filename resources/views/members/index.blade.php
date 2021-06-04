@extends('../layouts.app')

@section('menu_member_menu_open' , 'menu-open')
@section('menu_member_menu_open_active' , 'active')
@section('menu_member' , 'active')

@section('css')

@endsection

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper" >
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
                <li class="breadcrumb-item active">Members</ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
<div class="justify-content-center py-4">
    <div >
        <div class="card" style="border: none">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link nav-link-header nav-item-left active" href="{{ route('member.index') }}"><strong class="span_vertical_active">Members List</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link color_span_active nav-link-header text-white"  href="{{ route('memberConsignment.index') }}"><strong class="span_vertical">Register Consignment</strong></a>
                    </li>
                   
                </ul>
            </div>
            <div class="card-body text-middle">
                <div class="text-middle">
                <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% "> <!--class nowrap-->
                    <thead style="background-color:#ebeef3;color:#7F92A3">
                        <tr>
                            <th width="5%" class="border_conner_left text-left"></th>
                            <th >username</th>
                            <th >E-mail</th>
                            <th >ชื่อ - สกุล</th>
                            <th width="5%">ระงับ ID</th>
                            <th width="10%">เปลี่ยนรหัสผ่าน</th>
                            <th width="5%">Blog</th>
                            <th width="15%" class="border_conner_right">Action</th>
                        </tr>
                        
                    </thead>
                    
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-container">
                <div class="modal-header mb-4">
                    <h5 class="modal-title"><font class="pl-2 " id="exampleModalLabel">เปลี่ยนรหัสผ่าน</font></h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                <form id="theForm" >
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control btn_rounded" id="password" name="password" aria-describedby="password"
                                placeholder="Enter password">

                        </div>
                        <div class="form-group">
                            <label for="firmpass">Confirm Password</label>
                            <input type="text" class="form-control btn_rounded" id="firmpass" name="firmpass" aria-describedby="firmpass"
                                placeholder="Enter confirm password">

                        </div>
                        <input type="hidden" name="id" id="id" value="">
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-light btn-default-custom" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-success-custom">บันทึก</button>
                    </div>
                </form>
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
    var table, Item_id , Value = null;

    datatableFilter();

    var theForm = $("#theForm");
        if (theForm.length > 0) {
            theForm.validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 4,
                        maxlength: 12,
                    },
                    firmpass: {
                    equalTo: "#password"
                },
                },
                messages: {
                    password: {
                        required: "กรุณาใส่ Password ด้วยค่ะ",
                        minlength: "The password should be accept minimum 4 characters",
                        maxlength: "The password should be accept minimum 12 characters",
                    },
                     firmpass: " Enter Confirm Password Same as Password",
                    
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                error.addClass('bg_error');
                element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                },
                
            });
        }
    $('body').on('click', '.change_password_Btn', function() {
        Item_id = $(this).data('id');
        $("#id").val(Item_id);
        $('#theModal').modal('show');
    });
    
    $("#theForm").on('submit',(function(e) {
        e.preventDefault();
        
        var Item_id =$("#id").val();
        var form_data = new FormData(this);
        form_data.append('fn', "change_password");
        
        if ($("#theForm").valid()) {
            $.LoadingOverlay("show");
            $.ajax({
                url: "{{ url('admin/member') }}"+'/' + Item_id,
                type: "POST",
                data: form_data,
                cache:false,
                processData: false,
                contentType: false,
                success: (response) => {
                    if ($.isEmptyObject(response.error)) {
                        console.log(response);
                        console.log(response.success);
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'ทำรายการสำเร็จ',
                            showConfirmButton: false,
                            iconColor: '#ffffffff',
                            timer: 1500,
                        }).then((result) =>{
                            //window.history.back();
                            //location.reload();
                            $('#theModal').modal('hide');
                            table.ajax.reload(null, false);
                        });
                    } else {
                        console.log(response.error);
                        $.LoadingOverlay("hide");
                        var text = "";
                        response.error.forEach(( element, index) => text+= "<p><strong>("+(index+1)+")." + element+ "</strong></p>");
                        Swal.fire({
                            icon: 'error',
                            title: "<strong> Cannot update records. </strong>",
                            html: "<h5>Error: </h5>"+text,
                        });
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                }
            });
        }
    }));

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
    $('body').on('click', '.stop_id_Btn', function() {
        Item_id = $(this).data("id");
        Value = $(this).data("value");
        if(Value === "yes"){
            Value = "no";
        }else if (Value === "no"){
            Value = "yes";
        }
        $.ajax({
           type:'POST',
           url:"{{ url('admin/member') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , val:Value , fn: "band" },
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
                }
            }
        });
    });
    
    $('body').on('click', '.cloneBuffet', function() {
        Item_id = $(this).data("id");
        alert(Item_id);
    });
    

    function datatableFilter() {
        $.fn.DataTable.ext.pager.numbers_length = 7;
        table = $("#example").DataTable({
            iDisplayLength: 10,
             dom: "<'row'<'col-sm-12 col-md-12 col-lg-8'l><'col-sm-12 col-md-12 col-lg-4'f>>" +
                "<'row'<'col-sm-12 col-md-12 col-lg-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5 col-lg-6'i><'col-sm-12 col-md-7 col-lg-6'p>>",
            
            aaSorting: [],
            buttons: [ {
                    text: 'เพิ่มสมาชิก',
                    className: 'btn btn-lg btn-success-custom',
                    action: function(e, dt, node, config) {
                        
                       //return view("products/add_product");
                       window.location='{{ url("admin/member/create") }}'
                    } },    
            ],
            processing: true,
            serverSide: true,
            ajax: "{{ route('member.index') }}",
            
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
                    data: 'stop_id',
                    name: 'stop_id',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'change_password',
                    name: 'change_password',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'blog',
                    name: 'blog',
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
