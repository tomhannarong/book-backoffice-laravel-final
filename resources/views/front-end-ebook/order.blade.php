@extends('../layouts.front-ebook')

@section('menu_order_ebook' , 'active_nav')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

  <!-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
  


<style>
.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}
a.disabled {
  pointer-events: none;
  cursor: default;
}
.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}

</style>
@endsection



@section('content')
<section>
    <div class="py-4">
        <center>
            <h1>
            <strong>
            My Order
            </strong><br/>
            </h1>
            
        </center>
    </div>
    <div class="container mb-4">
        <div class="justify-content-center">
            <div class="table-responsive">
                <table id="example" class="table table-fixed text-center" style="width:100%">
                <thead>
                    <tr>
                        <th>ลำดับที่</th>
                        <th>เลขที่ใบสั่งซื้อ</th>
                        <th>วันที่</th>
                        <th>ราคา</th>
                        <th>สถานะ</th>                                    
                        <th>อนุมัติการอ่าน</th>
                        <th width="25%">Action</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="theModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แจ้งชำระเงิน</h5>
                        <button type="button" class="close btn btn-danger " data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="theForm" >
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="account_tranfer">เลขที่ใบสั่งซื้อ : </label>
                                <input type="text" class="form-control" id="account_tranfer" name="account_tranfer" aria-describedby="account_tranfer"
                                    placeholder="Enter order number" readonly>

                            </div>
                            <div class="form-group">
                                <label for="tranfer_date">วันที่ : </label>
                                <input type="text" class="form-control datepicker date" id="tranfer_date" name="tranfer_date" aria-describedby="tranfer_date"
                                    placeholder="Enter date" autocomplete="off">

                            </div>
                            <div class="form-group">
                                <label for="tranfer_time">เวลา : </label>
                                <input type="text" class="form-control timepicker" id="tranfer_time" name="tranfer_time" aria-describedby="tranfer_time"
                                    placeholder="Enter time" autocomplete="off">

                            </div>
                            <div class="form-group">
                                <label for="amount">จำนวนเงิน : </label>
                                <input type="number" class="form-control" id="amount" name="amount" aria-describedby="amount"
                                    placeholder="Enter amount" autocomplete="off">

                            </div>
                            <div class="form-group">
                                <label for="name">โอนมายังธนาคาร : </label>
                                <select class="form-control " name="bank_tranfer" id="bank_tranfer">	
                                        <option value="">----- เลือกธนาคาร -----</option>
                                        @foreach ($payments as $payment)
                                            <option value="{{ $payment->payment }}">{{ $payment->payment }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="remark1">หมายเหตุ : </label>
                                <input type="text" class="form-control" id="remark1" name="remark1" aria-describedby="remark1"
                                    placeholder="Enter remark">

                            </div>
                            
                            
                            <div class="form-group mt-2">
                                <label>Upload Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-outline-success btn-file">
                                            Browse… <input type="file" id="imgInp" name="imgInp">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly >
                                </div>

                            </div>
                            <img src="{{ asset('img/no_pic.png') }}" width="250" height="300" id='img-upload' alt="img" class="img-thumbnail"/>
                            <input type="hidden" name="username" id="username" value="{{ $user->username }}">
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
</section>

@endsection



@section('js')
    <script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


<script>

$(function(){

    //show()
    datatableFilter()
    var table , Item_id = null ;
    var theForm = $("#theForm");
    if (theForm.length > 0) {
        theForm.validate({
            rules: {
                account_tranfer: {
                    required: true,
                },
                tranfer_date: {
                    required: true,
                },
                tranfer_time: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                bank_tranfer: {
                    required: true,
                },
                imgInp: {
                    required: true,
                    extension: "jpeg|png|jpg|gif|svg"
                },
            },
            messages: {
                account_tranfer: {
                    required: "Please enter order number",
                },
                tranfer_date: {
                    required: "Please enter date",
                },
                tranfer_time: {
                    required: "Please enter time",
                },
                amount: {
                    required: "Please enter amount",
                },
                bank_tranfer: {
                    required: "Please enter bank",
                },
                imgInp: {
                    required: "Please enter image",
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
        });
    }

    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4' ,
        dateFormat: 'yy-mm-dd' ,
    });
    $('.timepicker').datetimepicker({
        format: 'HH:mm',
        icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'far fa-times-circle'
                }
    });
    
    
    $("#theForm").on('submit',(function(e) {
        e.preventDefault();
        
        if ($("#theForm").valid()) {
            $.LoadingOverlay("show");
            //alert("123");
            $.ajax({
                url: "{{ url('ebook/order') }}",
                type: "POST",
                data:  new FormData(this),
                cache:false,
                processData: false,
                contentType: false,
                success: (response) => {
                    if ($.isEmptyObject(response.error)) {
                        console.log(response);
                        console.log(response.success);
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 800,
                        }).then((result) =>{
                            //window.history.back();
                            //location.reload();
                            $('#theModal').modal('hide');
                            theForm.trigger("reset");
                            $('#img-upload').attr("src", "/img/no_pic.png");
                            $('#username').val("{{ $user->username }}")
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

    $('body').on('click', '.pay-in-btn', function() {
        Item_id = $(this).data('id');
        $("#account_tranfer").val(Item_id);
        $('#theModal').modal('show');
    });

    $('body').on('click', '.detailBtn', function() {
        Item_id = $(this).data('id');
        window.location = "{{ url('ebook/order') }}"+"/"+Item_id;
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
                    url: "{{ url('ebook/order') }}" + '/' + Item_id,
                    data:{_method: 'DELETE'},
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
            lengthChange: true,
            iDisplayLength: 10,
            bFilter: true,
            "aaSorting": [],
            pagingType: "full_numbers",
            language: {
                lengthMenu: "แสดงข้อมูล _MENU_ ข้อมูล",
                zeroRecords: "ไม่มีข้อมูล",
                info: "แสดงข้อมูลตั้งแต่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล",
                infoEmpty: "ไม่มีข้อมูลที่แสดงอยู่",
                infoFiltered: "(filtered from _MAX_ total records)",
                search: "ค้นหา:",
                loadingRecords: "กำลังโหลด...",
                //processing: "กำลังประมวลผล...",
                //processing: '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i>',
                processing: '<i class=" fa fa-spinner fa-spin fa-3x fa-fw " style="font-size:60px;color:red;"></i>',
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ต่อไป",
                    previous: "ย้อนกลับ",
                },
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('ebook/order') }}",
                type: 'GET',
                
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: (data) => data.id ? data.id : "-",
                    name: 'id'
                },
                {
                    data: (data) => {
                        if(data.order_date || data.order_time)
                       return data.order_date + ' [ '+data.order_time+' ] ';
                       else return '-';
                    },
                    name: 'order_date'
                },
                
                {
                    data: (data) => {
                        return (Number(data.total_order)).toFixed(2);
                    },
                    name: 'total_order'
                },
                {
                    data: 'order_status',
                    name: 'order_status',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'approve_status',
                    name: 'approve_status',
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
        });
    }
});
// end jquery
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function(event, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }

    });
    function readURL(input , img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                img.attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this , $("#img-upload"));
    });

</script>
@endsection
