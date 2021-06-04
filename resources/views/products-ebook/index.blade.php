@extends('../layouts.app')

@section('menu_product_ebooks_menu_open' , 'menu-open')
@section('menu_product_ebooks_menu_open_active' , 'active')
@section('menu_product_ebooks' , 'active')

@section('css')
<style>
.disabled {
  pointer-events: none;
  cursor: default;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: 0;
    border-top: 1px solid #dee2e6;
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
                <li class="breadcrumb-item active">E-Book Products</ol>
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
                            <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                <strong class="span_vertical_active">
                                    E-Book Products 
                                </strong>                              
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body text-middle">
                    <div class="text-middle">
                    <table  id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% "> <!--class nowrap-->
                        <thead style="background-color:#ebeef3;color:#7F92A3">
                            <tr >
                                <th width="5%" class="border_conner_left text-left"></th>
                                <th >รูปปก</th>
                                <th >ชื่อหนังสือ</th>
                                <th style="" >ราคา</th>
                                <th >ผู้แต่ง</th>
                                <th >ผู้ฝากขาย</th>
                                <th width="10%">เผยแพร่?</th>       
                                <th width="auto" class="border_conner_right">Action</th>
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
    datatableFilter();

    $('body').on('click', '.editBtn', function() {
        Item_id = $(this).data('id');
        window.location='{{ url("admin/productsEbook") }}' + '/'+Item_id+'/edit ';
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
                    url: '{{ url("admin/productsEbook") }}' + '/' + Item_id,
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
                                // status_glo = "status_buffet";
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
           url:"{{ url('admin/productsEbook') }}"+"/"+Item_id,
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
                        if(status_glo == "status_blame"){
                            datatableFilter(status_glo);
                            $('.isCheckDiscount').addClass('disabled');
                            $('.cloneBuffet').addClass('disabled');
                        }else if(status_glo == "status_buffet"){
                            datatableFilter(status_glo);
                            $('.isCheckDiscount').addClass('disabled');
                            $('.cloneBuffet').addClass('disabled');
                        }else if(status_glo == "status_serie"){
                            datatableFilter(status_glo);
                            $('.cloneBuffet').addClass('disabled');
                        }else{
                            datatableFilter(status_glo);
                        }
                    });
                } else {
                    console.log(response.error);
                }
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
            buttons: [ {
                    text: 'เพิ่มหนังสือ',
                    className: 'btn btn-lg btn-success-custom',
                    action: function(e, dt, node, config) {
                        
                       //return view("products/add_product");
                       window.location='{{ url("admin/productsEbook/create") }}'
                    } }
            ],
   
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('productsEbook.index') }}",
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
                    data: ({book_name}) => book_name ? `<strong class="text-color_main">${book_name}</strong>` : "-",
                    name: 'book_name'
                },
                {
                    data: ({product_price,price}) => { 
                        return html = `<b style="color:red">${product_price}</b><br><s>${price}</s>`;
                    },
                    name: 'product_price'
                },  
                {
                    data: ({alias}) => alias ? `<strong class="text-color_main">${alias}</strong>` : "-",
                    name: 'alias'
                },
                {
                    data: ({publisher_name}) => publisher_name ? `<strong class="text-color_main">${publisher_name}</strong>` : "-",
                    name: 'publisher_name'
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
