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
            <h1>Verify Slip</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('payInSlip.index') }}">Pay-in Slip</a></li>
              <li class="breadcrumb-item active">Verify Slip</li>
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
                                    <td colspan="4">{{ $tranfer->account_tranfer }}</td>
                                    
                                </tr>
                                <tr>
                                    <th colspan="2">โอนมายังธนาคาร : </th>
                                    <td colspan="4">{{ $tranfer->bank_tranfer }}</td>
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
                                    <td colspan="2">{{ $tranfer->username }}</td>
                                    <td colspan="2">{{ formatDateThai($tranfer->tranfer_date.' '.$tranfer->tranfer_time) }}</td>
                                    <td>{{ formatTimeThai($tranfer->tranfer_date.' '.$tranfer->tranfer_time) }}</td>
                                    <td>{{ number_format(round((float)$tranfer->amount,2),2) }}</td>
                                   
                                    
                                </tr>
                                
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;" colspan="7" >
                                        
                                        <img  class="xzoom" id="xzoom-default" draggable="false" src="{{ asset('storage/slip-images/thumbnail/'.$tranfer->attach_slip) }}" xoriginal="{{ asset('storage/slip-images/'.$tranfer->attach_slip) }}" />       
               
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
                            <table id="example" class="table table-striped table-bordered table-fixed" style="width:100%"> <!--class nowrap-->
                            <thead>
                                <tr>
                                    <th colspan="2">เลขที่ใบสั่งซื้อ : </th>
                                <th colspan="5">{{ $orders[0]->order_id ?? $order_buffets[0]->order_id }}</th>
                                </tr>
                                <tr>
                                    <th>ที่</th>
                                    <th width="50%">ISBN</th>
                                    <th width="50%">รายการ</th>
                                    <th>เล่ม</th>
                                    <th>ราคา</th>
                                    <th>ส่วนลด</th>
                                    <th>รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $order->ISBN }}</td>
                                    <td>{{ $order->book_name }}</td>
                                    <td>{{ $order->quantitys }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->percent_discount.'%' }}</td>
                                    <td>{{ $order->net }}</td>
                                </tr>
                                @endforeach
                                
                                @foreach ($order_buffets as $order)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $order->ISBN }}</td>
                                    <td>{{ $order->book_name }}</td>
                                    <td>{{ $order->quantitys }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->percent_discount.'%' }}</td>
                                    <td><font color="red">(เหมา)</font>{{ $order->net }}</td>
                                </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr style="text-align: center; vertical-align: middle;">
                                    <th colspan="3" align="center" >รวมรายการ</th>
                                    <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                    <th colspan="2"></th>
                                    <th><span style="text-decoration: underline;">{{ number_format(round((float)$order->net_price,2),2) }}</span></th>
                                </tr>
                                <tr style="text-align: center; vertical-align: middle;">
                                    <th colspan="3" align="center">ค่าขนส่ง</th>
                                    <th></th>
                                    <th colspan="2">{{ $order->transport }}</th>
                                    <th>{{ $order->transport_rate }}</th>
                                </tr>
                                <tr style="text-align: center; vertical-align: middle;">
                                    <th colspan="3" align="center">รวมสุทธิ</th>
                                    <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                    <th colspan="2"></th>
                                    <th>
                                        <span class="double">{{ number_format(round((float)$order->net_price + $order->transport_rate,2),2) }}</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                    </div>
                <!-- form -->
            </div>

            <div class="card card-warning">
                <!-- form -->
                    <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-arrow-right"></i> Change Status</h3> 
                            <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive-xl table-responsive-lg table-responsive-md table-responsive-sm">
                            <table id="example" class="table table-striped table-bordered table-fixed w-auto" style="width:100%">
                            <tr>
                                <th width="20%" style="text-align: center; vertical-align: middle;" class="bg-success">Status Order</th>
                                <th width="50%" style="text-align: center; vertical-align: middle;">
                                <h5 style="display: inline-block;"><span class="badge badge-info fa-3x">{{ $order->order_status }}</span> => </h5>
                                <h5 style="display: inline-block;"><span href="#" class="badge badge-dark">ชำระเงินแล้ว</span> =>  </h5>
                                <h5 style="display: inline-block;"><span href="#" class="badge badge-dark">ส่งสินค้าแล้ว</span></h5>        
                                </th>
                                <th width="30%" style="text-align: center; vertical-align: middle;">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-lg btnNext" data-id="{{ $orders[0]->order_id ?? $order_buffets[0]->order_id }}" data-val="{{ $order->order_status }}" data-id-tran="{{ $tranfer->id }}" data-fn="NextStage" ><i class="fas fa-arrow-circle-right"></i> NEXT STAGE</a>
                                </th>
                            </tr>
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
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: 'dark',
            confirmButtonText: 'Yes, Next Stage it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                    data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 800,
                            }).then((result) => { 
                                //window.location='{{ url("admin/payInSlip") }}' 
                                window.history.back();
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