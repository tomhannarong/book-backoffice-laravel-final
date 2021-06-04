@extends('../layouts.app')

@section('menu_pay_in_slip' , 'active')

@section('css')
<!-- xZoom -->
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/xZoom/css/xzoom.css') }}" media="all" />

<style>
.double {
  text-decoration-line: underline;
  text-decoration-style: double;    
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
          <div class="col-sm-6">
            <h1>Verify Slip [ E-Books ]</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payInSlip.index') }}">Pay-in Slip E-Books</a></li>
              <li class="breadcrumb-item active">Verify Slip E-Books</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="row justify-content-center pl-3 pr-3">
        <div class="col-md-5">
        
            <div class="card card-warning">
                <!-- form -->
                    <div class="card-header">
                            <h3 class="card-title"><i class="nav-icon fas fa-receipt"></i> Pay-in Slip</h3>
                            <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    
                    <div class="card-body table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%"> <!--class nowrap-->
                            <thead>
                                <tr>
                                    <th colspan="2">เลขที่ใบสั่งซื้อ : </th>
                                    <td colspan="4">{{ $tranfer->order_id }}</td>
                                    
                                </tr>
                                <tr>
                                    <th colspan="2">โอนมายังธนาคาร : </th>
                                    <td colspan="4">{{ $tranfer->bank }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">ผู้โอน</th>
                                    <th colspan="2">วันที่</th>
                                    <th>เวลา</th>
                                    <th>จำนวน</th>
                                    
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">{{ $tranfer->username_customer }}</td>
                                    <td colspan="2">{{ formatDateThai($tranfer->bank_datetime) }}</td>
                                    <td>{{ formatTimeThai($tranfer->bank_datetime) }}</td>
                                    <td>{{ number_format(round((float)$tranfer->total_order,2),2) }}</td>
                                   
                                    
                                </tr>
                                
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;" colspan="7" >
                                        
                                        <img  class="xzoom" id="xzoom-default" draggable="false" src="{{ asset('storage/slip-images/thumbnail/'.$tranfer->file1) }}" xoriginal="{{ asset('storage/slip-images/'.$tranfer->file1) }}" />       
               
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                <!-- form -->
            </div>
        </div>
        <div class="col-md-7">
            <div class="card card-warning">
                <!-- form -->
                    <div class="card-header">
                            <h3 class="card-title"><i class="nav-icon fas fa-box-open"></i> Customer Order</h3>
                            <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-fixed text-center"  style="width:100%"> <!--class nowrap-->
                                <thead>
                                    <tr>
                                        <th colspan="2">เลขที่ใบสั่งซื้อ : </th>
                                        <th colspan="2" style="border-right:0" class="text-left">{{ $orders[0]->order_id }}</th>
                                        <th colspan="2" style="border-left:0" class="text-center">
                                            <a href="javascript:void(0)" class="btn btn-primary btn-lg btnNext" data-id="{{ $orders[0]->order_id }}" data-val="{{ $orders[0]->order_status_mas }}" data-id-tran="{{ $tranfer->id }}" data-fn="NextStage" ><i class="fas fa-arrow-circle-right"></i> NEXT STAGE</a>
                                    
                                        </th>
                                    
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
                                            @if($order->order_status == "y")
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
  
    

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')

<script src="{{ asset('plugins/xZoom/js/xzoom_setup.js') }}"></script> 
<script>
    var table, Item_id , Item_id_tran , Item ,Item_fn = null;

    $('body').on('click', '.btnNext', function() {
        Item_id = $(this).data("id");
        Item_id_tran = $(this).data("id-tran");
        Item = $(this).data("val");
        Item_fn = $(this).data("fn");
        
        //alert(Item_id_tran);
        Swal.fire({
            title: 'ยืนยันการชำระเงิน?',
            text: "คุณตรวจสอบและยืนยันการชำระเงินแล้ว",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: 'dark',
            confirmButtonText: 'Yes, I confirm that'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/payInSlipEbook') }}" + '/' + Item_id,
                    data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            Swal.fire({
                                title: 'ยืนยันการชำระเงินสำเร็จแล้วค่ะ',
                                icon: 'success',
                            }).then((value) => {
                                Swal.fire({
                                    title: 'อนุมัติการอ่าน?',
                                    text: "คุณยืนยันอนุมัติการอ่าน E-Books ในรายการนี้ทั้งหมด",
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: 'dark',
                                    confirmButtonText: 'Yes, I confirm that'
                                }).then((result) => {
                                    if (result.value) {
                                        Item_fn = "approve_read";
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ url('admin/payInSlipEbook') }}" + '/' + Item_id,
                                            data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                                            success: (response) => {
                                                if ($.isEmptyObject(response.error)) {
                                                    console.log(response);
                                                    Swal.fire({
                                                        title: 'ยืนยันอนุมัติการอ่าน E-Books สำเร็จแล้วค่ะ',
                                                        icon: 'success',
                                                    }).then((value) => {
                                                        window.history.back();
                                                    });
                                                } 
                                            },
                                        });
                                    }else{
                                        window.history.back();
                                    }
                                });
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
</script>

@endsection