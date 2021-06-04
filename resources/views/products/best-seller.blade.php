@extends('../layouts.app')

@section('menu_product_menu_open' , 'menu-open')
@section('menu_product_menu_open_active' , 'active')
@section('menu_best_seller' , 'active')

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
                <li class="breadcrumb-item active">Best Seller</ol>
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
                                Best Seller
                            </strong>                              
                        </a>
                    </li>
                </ul>
            </div>   
            <div class="card-body text-middle">
                <div class="text-middle">
                    <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% ">
                    <thead style="background-color:#ebeef3;color:#7F92A3">
                        <tr>
                            <th width="5%" class="border_conner_left text-left">Top</th>
                            <th>รูปปก</th>
                            <th>ชื่อหนังสือ</th>
                            <th>พิมพ์ครั้งที่</th>
                            <th>ปีพิมพ์</th>
                            <th width="20%" class="border_conner_right">Action</th>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-container">
                <div class="modal-header mb-4">
                    <h3 class="modal-title"><font class="pl-2 " id="exampleModalLabel"></font></h3>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                <form id="theForm" action="{{ url('admin/bestSeller') }}" method="POST" typeForm="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="top">Top :	</label>
                            <input type="number" class="form-control btn_rounded" id="top" name="top" aria-describedby="top"
                                placeholder="Enter top">

                        </div>
                        <div class="form-group ">
                            <label for="name">ชื่อหนังสือ : </label>
                            
                            <select name="name" id="name" class="select2 form-control btn_rounded">
                                <option value="" >----- เลือกชื่อหนังสือ -----</option>
                            
                            </select>

                        </div>
                        <table id="example_search" class="table table-striped table-bordered table-fixed " style="width:100%">
                            <thead>
                                <tr>
                                    <th width="40%">รูปปก</th>
                                    <th width="30%">ชื่อหนังสือ</th>
                                    <th width="30%">ISBN</th>
                                    
                                </tr>
                            </thead>
                        </table>
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
    var theForm = $("#theForm");
    var table, Item_id , table_search = null;

    datatableFilter();

    if (theForm.length > 0) {
        theForm.validate({
            rules: {
                top: {
                    required: true,
                },
                name: {
                    required: true,
                },
            },
            messages: {
                top: {
                    required: "Please enter top",
                },
                name: {
                    required: "Please enter name",
                },
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
            submitHandler: function(form) {
                var url = theForm.attr('action');
                var type = theForm.attr('method');
                var title = "Cannot add new records.";
                $.LoadingOverlay("show");
                if (theForm.attr("typeForm") === "update") {
                    url += '/' + Item_id;
                    type = "PUT";
                    title = "Cannot update records.";
                }
                $.ajax({
                    url: url,
                    type: type,
                    data: theForm.serialize(),
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            $.LoadingOverlay("hide");
                            theForm.trigger("reset");
                            $('#theModal').modal('hide');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'ทำรายการสำเร็จ',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                timer: 1500,
                            }).then((result) => {
                                table_search.destroy();
                                table.ajax.reload(null, false);
                            });
                        } else {
                            console.log(response.error);
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                icon: 'error',
                                title: "<strong>" + title + "</strong>",
                                text: "Error: " + response.error,
                            });
                        }
                    },
                    error: (response) => {
                        console.log('Error:', response);
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            icon: 'error',
                            title: "<strong>" + title + "</strong>",
                            html: "<strong>Error Code: </strong>" + response
                                .status + "<p><strong>Message: </strong>" + JSON
                                .stringify(response.responseJSON.message) +
                                "</p>",
                        })
                    }
                });
            }
        });
    }
    // $('body').on('keyUp', '#name', function() {
    //     alert($(this).val());
    // });

    $('.select2').select2({
        ajax: { 
          url: "{{ url('admin/ajaxSelectTwoBestSeller') }}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

      });

    $('#name').on('select2:select', function (e) {
        var data = e.params.data;
        datatableSearch(data.id);
    });

    $('body').on('change', '.editBtn', function() {
        Item_id = $(this).data('id');
        alert(Item_id);
        $.ajax({
            type: "GET",
            url: theForm.attr('action') + '/' + Item_id + '/edit',
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    // $('.modal-header').removeClass("bg-success text-white");
                    $('.modal-title').html("แก้ไขสินค้าขายดี");
                    // $('.modal-header').addClass("bg-warning text-black");
                    $(".error").html('');

                    $(".is-invalid").removeClass("is-invalid");

                    $(".error").removeClass("error");
                    theForm.attr("typeForm", "update");
                    $('#top').val(response.top);
                    $('#name').val(response.book_name);
                    $('#theModal').modal('show');
                } else {
                    console.log(response.error);
                    Swal.fire({
                        icon: 'error',
                        title: "Error edit record.",
                        text: "ERROR: " + response.error,
                    });
                }
            },
            error: (response) => {
                console.log('Error:', response);
                Swal.fire({
                    icon: 'error',
                    title: "<strong>Error edit record.</strong>",
                    html: "<strong>Error Code: </strong>" + response.status +
                        "<p><strong>Message: </strong>" + JSON.stringify(response
                            .responseJSON.message) + "</p>",
                });
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
                    url: theForm.attr('action') + '/' + Item_id,
                    data:{ _method: 'DELETE'} ,
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
            // bFilter: true,
            // destroy: true,
            // searching: false,
            //dom: 'Bfrtip',
            "aaSorting": [],
            buttons: [{
                    text: 'เพิ่มสินค้าขายดี',
                    className: 'btn btn-lg btn-success-custom',
                    action: function(e, dt, node, config) {
                        // $('.modal-header').removeClass("bg-warning text-black");
                        $('.modal-title').html("เพิ่มสินค้าขายดี");
                        // $('.modal-header').addClass("bg-success text-white");
                        theForm.attr("typeForm", "add");
                        //theForm.trigger("reset");
                        $('#theModal').modal('show');
                    }
                }
            ],

            processing: true,
            serverSide: true,
            ajax: {
                url: theForm.attr('action'),
                type: 'GET',
                
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [
                {
                    data: ({top})=>{
                        return `<span class="p-1 pl-2 pr-2" style="background-color: #EBEEF3 ;border-radius:10px;color:#092C4C;font-weight:600;"> ${top} </span>`;
                    },
                    name: 'top',
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
    function datatableSearch(filter_id = '') {
        table_search = $("#example_search").DataTable({
            bPaginate: false,
            bLengthChange: false,
            bInfo: false,
            bAutoWidth: false,
            lengthChange: false,
            bFilter: false,
            searching: false,
            "aaSorting": [],
            paging: false,
            destroy: true,
            fixedColumns: false,
            processing: false,
            serverSide: true,
            ajax: {
                url: theForm.attr('action'),
                type: 'GET',
                data:{  filter_id: filter_id, }
            },

            responsive: true,
            columns: [
                {
                    data: (data) => {
                        //console.log(data.picture);
                        if(data.picture){
                            var path = "{{ asset('storage/book-images/thumbnail') }}/"+data.picture ;
                           var html = '<img src="'+path+'" width="70">';
                            return(html);
                        }else{
                            return("-");
                        }  
                    },
                    name: 'picture'
                    
                },
                {
                    data: (data) => data.book_name ? data.book_name : "-",
                    name: 'book_name'
                },
                {
                    data: (data) => data.isbn ? data.isbn : "-",
                    name: 'isbn'
                },
            ],
            initComplete: function() {
                
            },
        });
    }

});
</script>
@endsection
