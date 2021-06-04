@extends('../layouts.front-ebook')

@section('menu_order_ebook' , 'active_nav')

@section('css')
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
.double {
  text-decoration-line: underline;
  text-decoration-style: double;    
}
a:hover {   
  /* background-color: yellow; */
  color: Navy;
}
.table-responsive-des {
    display: block;
    width: 100%;
}
.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}

.linear-4 {
background: rgb(0,36,2);
background: linear-gradient(90deg, rgba(0,36,2,1) 0%, rgba(40,121,9,1) 20%, rgba(6,166,81,1) 54%, rgba(3,204,134,1) 79%, rgba(0,212,255,1) 97%);
}
.linear-5 {
    background: rgb(102,25,185);
    background: radial-gradient(circle, rgba(102,25,185,1) 0%, rgba(25,182,223,1) 50%, rgba(42,124,222,1) 100%);
}
.breadcrumb {
    margin-bottom: 0rem;
}
.option_head_text {
    align-items: center;
    /* position: absolute; */
    right: 0;
    bottom: 7px;
    /* font-family: Helvetica,Thonburi,Tahoma,sans-serif; */
    font-size: 20px;
    color: red;
}
.head_text {
    border-bottom: 1px solid #8e918f;
    padding-bottom: 5px;
    margin-bottom: 20px;
    position: relative;
}

.option_head_text a {
    color: black;
}

</style>


@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="py-4">
    <center>
        <h1>
        <strong>
        My Order
        </strong><br/>
        </h1>
    </center>
</div>

 <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header py-4">
      <div class="container">
            <div class="head_text">
            <div class="head_text_string row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <h2 class="">รายละเอียดรายการ E-Books</h2>
                </div>
                <div class="option_head_text col-12 col-sm-12 col-md-6 col-lg-6">
                    <div style="float: right;">
                        <ol class="breadcrumb float-sm-right" >
                            <li class="breadcrumb-item"><a href="{{ url('ebook') }}">หน้าแรก</a></li>
                            <li class="breadcrumb-item" ><a href="{{ url('ebook/order') }}">รายการสั่งซื้อ</a></li>
                            <li class="breadcrumb-item active" >รายละเอียด</li>
                        </ol>
                    </div>
                </div>
            </div>
            
                
                   
            </div>
            
      </div><!-- /.container-fluid -->
    </section>

                    

    <section class="mb-4">
        <div class="row justify-content-center pl-3 pr-3">
        
            <div class="col-md-12">
                <div class="card card-primary">
                    <!-- form -->
                        <div class="card-header">
                        <h3 class="card-title"><i class="nav-icon fas fa-box-open"></i> Customer Order <a href="javascript:void(0)" class="btn btn-success btn-xl float-sm-right pay-in-btn {{ $orders[0]->order_status_mas == "c" || $orders[0]->order_status_mas == "y" ? "disabled" : "" }}" data-id="{{ $orders[0]->order_id }}">
                                <font size="5">แจ้งโอนเงิน</font>
                                </a></h3>
                                
                                
                        </div>
                        
                        <div class="card-body ">
                            <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-fixed text-center"  style="width:100%"> <!--class nowrap-->
                                <thead>
                                    <tr>
                                        <th colspan="2">เลขที่ใบสั่งซื้อ : </th>
                                    <th colspan="4" class="text-left">{{ $orders[0]->order_id }}</th>
                                    </tr>
                                    <tr>
                                        <th>ลำดับที่</th>
                                        
                                        <th colspan="2" class="text-left">รายการ</th>
                                        <th>สถานะการอ่าน</th>
                                        <th>เล่ม</th>
                                        <th>รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td width="10%">{{ ++$i }}</td>
                                        <td colspan="2" class="text-left">{{ $order->product_name }}</td>
                                        <td width="15%">
                                            @if($order->order_status_tran == "y")
                                                <h5><span class="badge badge-success">อนุมัติอ่านแล้ว</span></h5>
                                            @else
                                                <h5><span class="badge badge-dark">รออนุมัติ</span></h5>
                                            @endif
                                        </td>
                                        <td width="10%">{{ $order->product_qty }}</td>
                                        
                                        <td width="20%">{{ number_format(round((float)$order->total_price,2),2) }} บาท</td>
                                    </tr>
                                    @endforeach
                                </tbody>
    
                                <tfoot>
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th colspan="4" align="center">รวมสุทธิ</th>
                                        <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                        <th>
                                            <span class="double">{{ number_format(round((float)$order->total_order,2),2) }} บาท</span>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                    <!-- form -->
                </div>
    
                
            </div>
        </div>
    </section>

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
    
    <section class="mb-4">
        <div class="row justify-content-center pl-3 pr-3">
        
            <div class="col-md-12">
                <div class="card" >
                    <!-- form -->
                        <div class="card-header " >
                                <h3 class="card-title"><i class="nav-icon fas fa-wallet"></i><font> ช่องทางการชำระเงิน</font></h3>                          
                        </div>
                        
                        <div class="card-body ">
                            <div class="table-responsive-des">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 text-left">
                                        @foreach ($payments as $payment)
                                            <font >                                                
                                                <input type="radio" id="payment{{ $payment->id }}" data-id="{{ $payment->id }}" name="payment" class="check_pay" >
                                                <input type="hidden" name="payment_des_val{{ $payment->id }}" id="payment_des_val{{ $payment->id }}" value="{{ $payment->payment_description }}">  
                                                <label for="payment{{ $payment->id }}">{{$payment->payment}}</label>
                                                <br>                                                                                                                                            
                                            </font>
                                        @endforeach
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 text-center">
                                        <article id="des_payment">
                                            {!! $payments[0]->payment_description !!}
                                        </article>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- form -->
                </div>
    
                
            </div>
        </div>
    </section>
    

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


<script>
$(function(){
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
                            window.history.back();
                            //location.reload();
                            $('#theModal').modal('hide');
                            theForm.trigger("reset");
                            $('#img-upload').attr("src", "{{ asset('img/no_pic.png') }}");
                            $('#username').val("{{ $user->username }}")
                            // table.ajax.reload(null, false);
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

    $(".check_pay").change(function(){ // bind a function to the change event
            if( $(this).is(":checked") ){ // check if the radio is checked
                var id = $(this).data('id');
                var des = $('#payment_des_val'+id).val();
                //alert(des);
                $('#des_payment').html(des);
            }
    });
});

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