@extends('../layouts.app')

@section('menu_order' , 'active')

@section('css')
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
            <h1>Order E-Books Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orderEbook.index') }}">Order E-Books</a></li>
              <li class="breadcrumb-item active">Order E-Books Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section>
        <div class="row justify-content-center pl-3 pr-3">
        
            <div class="col-md-12">
                <div class="card card-primary">
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
    </section>
    
  
    

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')

<script>

    
</script>

@endsection