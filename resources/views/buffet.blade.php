@extends('../layouts.app')

@section('menu_buffet' , 'active')

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
                <font id="header_title" class="header_title">Promotion & Payment </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Buffet</ol>
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
                                Buffet 
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
                            <th width="20%">จำนวนเล่ม</th>
                            <th width="55%">ราคารวม</th>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-container">
                <div class="modal-header mb-4">
                    <h5 class="modal-title"><font class="pl-2 " id="exampleModalLabel"></font></h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                <form id="theForm" action="{{ url('admin/buffet') }}" method="POST" typeForm="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="book_number">จำนวนเล่ม</label>
                            <input type="number" min="0" step="1"  class="form-control btn_rounded" id="book_number" name="book_number" aria-describedby="book_number"
                                placeholder="จำนวนเล่ม">
                        </div>
                        <div class="form-group">
                            <label for="total_price">ราคารวม</label>
                            <input type="number" min="0" step="1"  class="form-control btn_rounded" id="total_price" name="total_price" aria-describedby="total_price"
                                placeholder="ราคารวม">
                        </div>
                        <input name="_method" id="_method" type="hidden" value="POST">
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
    var table, Item_id = null;

    datatableFilter();

    if (theForm.length > 0) {
        theForm.validate({
            rules: {
                book_number: {
                    required: true,
                },
                total_price: {
                    required: true,
                },
            },
            messages: {
                book_number: {
                    required: "Please enter book number",
                },
                total_price: {
                    required: "Please enter total price",
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
                $('#_method').val('POST');
                if (theForm.attr("typeForm") === "update") {
                    $('#_method').val('PUT');
                    url += '/' + Item_id;
                    type = "POST";
                    title = "Cannot update records.";
                }
                $.LoadingOverlay("show");
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
                            }).then((result) => table.ajax.reload(null, false));
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

    $('body').on('click', '.editBtn', function() {
        Item_id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: theForm.attr('action') + '/' + Item_id + '/edit',
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    // $('.modal-header').removeClass("bg-success text-white");
                    $('.modal-title').html("แก้ไขบุฟเฟ่ต์");
                    // $('.modal-header').addClass("bg-warning text-black");
                    $(".error").html('');

                    $(".is-invalid").removeClass("is-invalid");

                    $(".error").removeClass("error");
                    theForm.attr("typeForm", "update");
                    $('#book_number').val(response.book_number);
                    $('#total_price').val(response.total_price);
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
                    data:{_method: 'DELETE'},
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
                    text: 'เพิ่มบุฟเฟ่ต์',
                    className: 'btn btn-lg btn-success-custom',
                    action: function(e, dt, node, config) {
                        // $('.modal-header').removeClass("bg-warning text-black");
                        $('.modal-title').html("เพิ่มบุฟเฟ่ต์");
                        // $('.modal-header').addClass("bg-success text-white");
                        theForm.attr("typeForm", "add");
                        theForm.trigger("reset");
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
                    data: ({book_number}) => book_number ? `<strong class="text-color_main">${book_number}</strong>` : "-",
                    name: 'book_number'
                },
                {
                    data: ({total_price}) => total_price ? `<strong class="text-color_main">${total_price}</strong>` : "-",
                    name: 'total_price'
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
