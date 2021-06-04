@extends('../layouts.app')

@section('menu_product_menu_open' , 'menu-open')
@section('menu_product_menu_open_active' , 'active')
@section('menu_stock' , 'active')

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
                <font id="header_title" class="header_title">Products Menu </font>
            </div>            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Stock Products</ol>
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
                                    Stock Products 
                                </strong>                              
                            </a>
                        </li>                       
                    </ul>
                </div> 
                    <div class="card-body  text-middle">
                        <div class=" text-middle">
                            <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% "> <!--class nowrap-->
                            <thead style="background-color:#ebeef3;color:#7F92A3">
                                <tr>
                                    <th width="5%" class="border_conner_left text-left"></th>
                                    <th>รูปปก</th>
                                    <th>ชื่อหนังสือ</th>
                                    <th>ราคา</th>
                                    <th>ซีรีส์ชุด</th>
                                    <th>นามปากกา</th>
                                    <th>สินค้าติดจอง</th>
                                    <th>สินค้าพร้อมขาย</th>
                                    <th width="20%" class="border_conner_right">สินค้าลงเหลือ</th>
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
    var table, Item_id , Item = null;

    datatableFilter();

    $('body').on('click', '.BtnSaveEdit', function() {
        Item_id = $(this).data('id');
        Item = $('#stock' + Item_id).val();
        //alert(Item_id);
        //alert(Item);
        $.ajax({
           type:'POST',
           url:"{{ url('admin/products/stock') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , stock:Item},
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
                }
            }
        });    
    });

    function datatableFilter(status='') {
        table = $("#example").DataTable({
            // lengthChange: true,
            // iDisplayLength: 10,
            // bFilter: true,
            // destroy: true,
            // searching: false,
             //dom: 'Bfrtip',
            // ordering:false,
            aaSorting: [
            ],
            buttons: [ 
                    {
                    text: `<div class="status_all_btn btn_noti" >สินค้าทั้งหมด</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        table.clear().destroy();
                        datatableFilter();
                    } },
                    {
                    text: `<div class="status_nor_btn btn_noti" >สินค้าปกติ</div>`,
                    className: 'border-0 bg-white ml-1 mr-1 mt-4 mb-4',
                    action: function(e, dt, node, config) {
                        table.clear().destroy();
                        datatableFilter("status_nor");
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
                url: "{{ route('stock.index') }}",
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
                    data: ({price}) => price ? `<strong class="text-color_main">${price}</strong>` : "-",
                    name: 'price'
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
                    data: 'stock_hold',
                    name: 'stock_hold',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'stock_remain',
                    name: 'stock_remain',
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
                    case "":
                        $(".status_all_btn").css("color", "").addClass("border_buttom_active");     
                        break;
                    case "status_nor":
                        $(".status_nor_btn").css("color", "").addClass("border_buttom_active");               
                        break;                    
                    case "status_buffet":
                        $(".status_buffet_btn").css("color", "").addClass("border_buttom_active");    
                        break;
                }
            },
           
        });
    }

});     
function isNumber(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }
</script>

@endsection