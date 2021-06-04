@extends('../layouts.app')

@section('menu_product_menu_open' , 'menu-open')
@section('menu_product_menu_open_active' , 'active')
@section('menu_product' , 'active')

@section('css')
<style>
.disabled {
  pointer-events: none;
  cursor: default;
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
                <font id="header_title" class="header_title">Products Menu </font>
            </div>            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Book Products</ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<div class="justify-content-center py-4">
    <div class="">
        <div class="card "  style="border: none">
            <div class="card-header text-center">
                <ul class="nav nav-tabs card-header-tabs ">
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                            <strong class="span_vertical_active">
                                Book Products 
                            </strong>                              
                        </a>
                    </li>
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header text-white color_span_active" href="{{ url('admin/products/create') }}">
                            <strong class="span_vertical">
                                Add Product
                            </strong>
                        </a>
                    </li>
                </ul>
            </div>        

            <div class="card-body text-middle">
                <div class="text-middle">
                <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% "> <!--class nowrap-->
                    <thead style="background-color:#ebeef3;color:#7F92A3">
                        <tr>
                            <th  width="5%" class="border_conner_left text-left"></th>
                            <th >รูปปก</th>
                            <th >ISBN</th>
                            <th >ชื่อหนังสือ</th>
                            <th >ราคา</th>
                            <th >ซีรีส์ชุด</th>
                            <th >นามปากกา</th>
                            <th width="2%">เผยแพร่?</th>
                            <th width="2%">ลดราคา?</th>
                            <th width="2%">คัดลอดเข้าบุฟเฟ่ต์</th>
                            <th width="12%" class="border_conner_right">Action</th>
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
    var table, Item_id , Value ,status_glo = null;
    status_glo = "status_nor";
    datatableFilter("status_nor");

    $('body').on('click', '.editBtn', function() {
        Item_id = $(this).data('id');
        window.location='{{ url("admin/products") }}' + '/'+Item_id+'/edit ';
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
                    url: '{{ url("admin/products") }}' + '/' + Item_id,
                    data:{_method: 'DELETE'} ,
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
                                //table.ajax.reload(null, false)
                                table.clear().destroy();
                                datatableFilter(status_glo);
                                
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
        });
        
    });
    $('body').on('click', '.isCheckPublic', function() {
        Item_id = $(this).data("id");
        Value = $(this).data("value");
        //alert(Value);
        if(Value === "on"){
            Value = "false";
            // $("h1").addClass("page-header highlight");
            // $("h1").removeClass("page-header");
            // $(selector).html()
        }else if (Value === "off"){
            Value = "true";
        }

        $.ajax({
           type:'POST',
           url:"{{ url('admin/products') }}"+"/"+Item_id,
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
                        datatableFilter(status_glo);
                    });
                } else {
                    console.log(response.error);
                }
            }
        });
    });
    $('body').on('click', '.isCheckDiscount', function() {
        Item_id = $(this).data("id");
        Value = $(this).data("value");
        //alert(Value);
        if(Value === "on"){
            Value = "false";
            // $("h1").addClass("page-header highlight");
            // $("h1").removeClass("page-header");
            // $(selector).html()
        }else if (Value === "off"){
            Value = "true";
        }

        $.ajax({
           type:'POST',
           url:"{{ url('admin/products') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , status:Value , fn: "discount" },
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
                        //table.ajax.reload(null, false)
                        table.clear().destroy();
                        datatableFilter(status_glo);
                    });
                } else {
                    console.log(response.error);
                }
            }
        });
        
    });
    $('body').on('click', '.cloneBuffet', function() {
        Item_id = $(this).data("id");
        //alert(Item_id);
        $.ajax({
            url: "{{ url('admin/products') }}"+'/' + Item_id,
            type: "POST",
            data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , fn:"cloneBuffet" },
           
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
                    }).then((result) =>{
                        //window.history.back();
                        //location.reload();
                        table.clear().destroy();
                        status_glo = "status_buffet";
                        datatableFilter(status_glo);
                    });
                } else {
                    console.log(response.error);
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

            }
        });
    });
    

    function datatableFilter(status='') {
        table = $("#example").DataTable({
            // lengthChange: true,
            // iDisplayLength: 10,
            // bFilter: true,
            //normal='',blame='',serie='',buffet=''
            // destroy: true,
            // searching: false,
             //dom: 'Bfrtip',
            ordering:false,
            aaSorting: [
            ],
            buttons: [ 
                    {
                    text: `<div class="status_nor_btn btn_noti" >สินค้าปกติ</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        table.clear().destroy();
                        datatableFilter("status_nor");
                    } },
                    {
                    text: `<div class="status_blame_btn btn_noti" >สินค้ามือหนึ่งสภาพเก่า</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        table.clear().destroy();
                        datatableFilter("status_blame");
                    } },
                    {
                    text: `<div class="status_serie_btn btn_noti" >ซีรีส์ชุด</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        table.clear().destroy();
                        datatableFilter("status_serie");
                    } },
                    {
                    text: `<div class="status_buffet_btn btn_noti" >โปรฯบุฟเฟ่ต์</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        table.clear().destroy();
                        datatableFilter("status_buffet");
                    } },
                   
                    
                
            ],
            
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('products.index') }}",
                type: 'GET',
                data: {status: status} ,
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
                    data: 'photo',
                    name: 'photo',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: ({ISBN}) => ISBN ? `<strong class="text-color_main">${ISBN}</strong>` : "-",
                    name: 'ISBN'
                },
                {
                    data: ({book_name}) => book_name ? `<strong class="text-color_main">${book_name}</strong>` : "-",
                    name: 'book_name'
                },
                {
                    data: ({product_price , price}) => { 
                        return html = `<b style="color:red">${product_price}</b><br><s>${price}</s>`;
                    },
                    name: 'product_price'
                },  
                {
                    data: ({writer}) => writer ? `<strong class="text-color_main">${writer}</strong>` : "-",
                    name: 'writer'
                },
                {
                    data: ({alias}) => alias ? `<strong class="text-color_main">${alias}</strong>` : "-",
                    name: 'alias'
                },
                {
                    data: 'public',
                    name: 'public',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'discount',
                    name: 'discount',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'cloneBuffet',
                    name: 'cloneBuffet',
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

                switch(status) {
                    case "status_nor":
                        $(".status_nor_btn").css("color", "").addClass("border_buttom_active");               
                        break;
                    case "status_blame":
                        $(".status_blame_btn").css("color", "").addClass("border_buttom_active");     
                        break;
                    case "status_serie":
                        $(".status_serie_btn").css("color", "").addClass("border_buttom_active");      
                        break;
                    case "status_buffet":
                        $(".status_buffet_btn").css("color", "").addClass("border_buttom_active");    
                        break;
                }
            },
        });
    }

});
</script>
@endsection
