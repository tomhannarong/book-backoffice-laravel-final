@extends('../layouts.app')

@section('menu_product_menu_open' , 'menu-open')
@section('menu_product_menu_open_active' , 'active')
@section('menu_pre_product' , 'active')

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
                <font id="header_title" class="header_title">Products Menu </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pre-Products</ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<div class="justify-content-center py-4">
    <div class="">
        <div class="card" style="border: none">
            <div   div class="card-header text-center">
                <ul class="nav nav-tabs card-header-tabs ">
                    <li class="nav-item" >
                        <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                            <strong class="span_vertical_active">
                                Pre-Products 
                            </strong>  
                            
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body text-middle">
                <div class="text-middle">
                <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% "> <!--class nowrap-->
                    <thead class="" style="background-color:#ebeef3;color:#7F92A3">
                        <tr>
                            <th width="5%" class="border_conner_left text-left"></th>
                            <th >รูปปก</th>
                            <th >ชื่อหนังสือ</th>
                            <th >พิมพ์ครั้งที่</th>
                            <th >ปีพิมพ์</th>
                            <th width="10%">ย้ายนิยาย</th>
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
    var table, Item_id , Value = null;

    datatableFilter();


    $('body').on('click', '.editBtn', function() {
        Item_id = $(this).data('id');
        window.location='{{ url("admin/preProducts") }}' + '/'+Item_id+'/edit ';
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
                    url: '{{ url("admin/preProducts") }}' + '/' + Item_id,
                    data:{ _method: 'DELETE' },
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

    $('body').on('click', '.confirmBtn', function() {
        Item_id = $(this).data("id");
        Swal.fire({
            title: 'ยืนยันการย้ายนิยายไปวางขาย?',
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
                    url: "{{ url('admin/preProducts') }}"+'/' + Item_id,
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}" , _method: 'PUT' ,fn:"confirm"},
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
                                window.location = '{{ url("admin/products") }}/'+ response.product_id +'/edit' ;
                                // table.ajax.reload(null, false);
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

            // destroy: true,
            // searching: false,
             //dom: 'Bfrtip',
            aaSorting: [
            ],
            buttons: [ {
                    text: 'เพิ่มนิยายรอตีพิมพ์',
                    className: 'btn btn-secondary btn-lg btn-success-custom',
                    action: function(e, dt, node, config) {
                        
                       //return view("products/add_product");
                       window.location='{{ url("admin/preProducts/create") }}'
                    } }
                             
            ],
            
            processing: true,
            serverSide: true,
            ajax: "{{ route('preProducts.index') }}",
            
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
                    data: ({picture}) => {
                        //console.log(data.picture);
                        if(picture){
                            var path = "{{ asset('storage/book-images/thumbnail') }}/"+picture ;
                           var html = '<img src="'+path+'" width="70">';
                            return(html);
                        }else{
                            return("-");
                        }  
                    },
                    name: 'picture'
                    
                },
                {
                    data: ({book_name}) => book_name ? `<strong class="text-color_main">${book_name}</strong>` : "-",
                    name: 'book_name'
                },
                {
                    data: ({pim_time}) => pim_time ? `<strong class="text-color_main">${pim_time}</strong>` : "-",
                    name: 'pim_time'
                },
                {
                    data: ({pim_year}) => pim_year ? `<strong class="text-color_main">${pim_year}</strong>` : "-",
                    name: 'pim_year'
                },
                {
                    data: 'confirm',
                    name: 'confirm',
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
