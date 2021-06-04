@extends('../layouts.app')

@section('menu_order_books_menu_open' , 'menu-open')
@section('menu_order_books_menu_open_active' , 'active')
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
            <h1>Order Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Customer Order</a></li>
              <li class="breadcrumb-item active">Order Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="mb-4">
        <div class="row justify-content-center pl-3 pr-3">
        
            <div class="col-md-12">
                <div class="card" >
                    <!-- form -->
                        <div class="card-header " >
                               
                                <h3 class="card-title"><i class="nav-icon fas fa-box-open"></i> รายการ </h3>                              
                        </div>
                        
                        <div class="card-body ">
                            <div class="table-responsive">
                            <table id="example" class="table table-bordered table-fixed"  style="width:100%"> <!--class nowrap-->
                                <thead>
                                    <tr>
                                        <th colspan="2">เลขที่ใบสั่งซื้อ : </th>
                                    <th colspan="6">@if(!empty($orders->id)) {{$orders->id}} @endif</th>
                                    </tr>
                                    <tr style="background-color: Beige;">
                                        <th style="width:5%">ที่</th>
                                        <th colspan="1" width="">ISBN</th>                                        
                                        <th width="">รายการ</th>
                                        <th style="width:10%">อนุมัติอ่าน</th>
                                        <th>เล่ม</th>
                                        <th>ราคา/เล่ม</th>
                                        <th>ส่วนลด</th>
                                        <th>รวม</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($is_ebook == true)
                                
                                    <tr >
                                        <td colspan="8" class="text-center" style="background-color: WhiteSmoke"><strong>E-Book</strong></td>
                                    </tr>
                                    @php $sum_qua = 0 @endphp
                                    @php $sum_net = 0 @endphp
                                    @foreach ($orders->getOrderTran as $order)
                                        @if($order->is_ebook == 'true')
                                            @php $sum_qua += $order->quantitys @endphp
                                            @php $sum_net += $order->net @endphp
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td colspan="1">{{ $order->ISBN }}</td>
                                                <td>{{ $order->book_name }}</td>
                                                @if($order->approve_status == "y")
                                                <td class="text-center"><span class="btn btn-success btn-sm">อนุมัติอ่านแล้ว</span></td>
                                                @else
                                                <td class="text-center"><span class="btn btn-dark btn-sm">รออนุมัติ</span></td>
                                                @endif
                                                <td class="text-center">{{ $order->quantitys }}</td>
                                                <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                                <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                                <td>{{ number_format(round((float)$order->net,2),2) }} บาท</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <!-- <tr style="text-align: center; vertical-align: middle;background-color: WhiteSmoke">
                                        <th colspan="4" align="center" >รวมรายการ E-Book</th>
                                        <th>{{ $sum_qua }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                    </tr> -->
                                @endif
                                @if($is_book == true)
                                    <tr >
                                        <td colspan="8" class="text-center" style="background-color: WhiteSmoke"><strong>Book</strong></td>
                                    </tr>
                                    @php $sum_qua = 0 @endphp
                                    @php $sum_net = 0 @endphp
                                    @foreach ($orders->getOrderTran as $order)
                                        @if($order->is_ebook == 'false' && $order->buffet != 'true')
                                            @php $sum_qua += $order->quantitys @endphp
                                            @php $sum_net += $order->net @endphp
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td colspan="1">{{ $order->ISBN }}</td>
                                                <td colspan="2">{{ $order->book_name }}</td>
                                                <td class="text-center">{{ $order->quantitys }}</td>
                                                <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                                <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                                <td>{{ number_format(round((float)$order->net,2),2) }} บาท</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <!-- <tr style="text-align: center; vertical-align: middle;background-color: WhiteSmoke">
                                        <th colspan="4" align="center" >รวมรายการหนังสือปกติ</th>
                                        <th>{{ $sum_qua }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                    </tr> -->
                                @endif
                                @if($is_buffet == true)
                                    <tr >
                                        <td colspan="8" class="text-center" style="background-color: WhiteSmoke"><strong>Book Buffet</strong></td>
                                    </tr>
                                    @php $sum_qua = 0 @endphp
                                    @php $sum_net = 0 @endphp
                                    @foreach ($orders->getOrderTran as $order)
                                        @if($order->is_ebook == 'false' && $order->buffet == 'true')
                                            @php $sum_qua += $order->quantitys @endphp
                                            @php $sum_net += $order->net @endphp
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td colspan="1">{{ $order->ISBN }}</td>
                                                <td colspan="2">{{ $order->book_name }}</td>
                                                <td class="text-center">{{ $order->quantitys }}</td>
                                                <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                                <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                                <td><font color="red">(เหมา)</font>{{ number_format(round((float)$order->net,2),2) }} บาท</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <!-- <tr style="text-align: center; vertical-align: middle;background-color: WhiteSmoke">
                                        <th colspan="4" align="center" >รวมรายการหนังสือ Buffet</th>
                                        <th>{{ $sum_qua }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                    </tr> -->


                                @endif
                                </tbody>
    
                                <tfoot>
                                    <tr style="text-align: center; vertical-align: middle;background-color: WhiteSmoke">
                                        <th colspan="4" align="center" >รวมรายการทั้งหมด</th>
                                        <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$orders->net_price,2),2) }}</span></th>
                                    </tr>
                                    @if($is_book == true || $is_buffet == true)
                                        <tr style="text-align: center; vertical-align: middle;background-color: WhiteSmoke">
                                            <th colspan="4" align="center">ค่าขนส่ง</th>
                                            <th></th>
                                            <th colspan="2">{{$orders->transport}}</th>
                                            <th>{{ $orders->transport_rate}}</th>
                                        </tr>
                                        
                                    @endif
                                    <tr style="text-align: center; vertical-align: middle;background-color: WhiteSmoke">
                                        <th colspan="4" align="center">รวมสุทธิ</th>
                                        <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                        <th colspan="2"></th>
                                        <th>
                                        @if($is_book == true || $is_buffet == true)
                                            <span class="double">{{ number_format(round((float)($orders->net_price) + ($orders->transport_rate),2),2) }}</span>
                                        @else
                                            <span class="double">{{ number_format(round((float)($orders->net_price) ,2),2) }}</span>                                        
                                        @endif
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

    
    <section class="mb-4">
        <div class="row justify-content-center pl-3 pr-3">
        
            <div class="col-md-12">
                <div class="card" >
                    <!-- form -->
                        <div class="card-header " >
                                <h3 class="card-title" ><i class="nav-icon fas fa-home" ></i><font color="black" > ที่อยู่ในการจัดส่ง</font></h3>                                
                        </div>
                        
                        <div class="card-body ">
                            <div class="table-responsive">
                                <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                    <tbody>
                                    <tr>
                                            <td align="right" width="100">เลขที่ใบสั่งซื้อ</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="170"><font color="#0000FF">@if(!empty($orders->id)) {{$orders->id}} @endif</font></td>
                                            <td align="right" width="70">วันที่ - เวลา</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="240"><font color="#0000FF">@if(!empty($orders->order_date)) {{$orders->order_date}} @endif 
                                            [ @if(!empty($orders->order_time)) {{$orders->order_time}} @endif ]
                                            </font></td>
                                    </tr>
                                    <tr>
                                            <td align="right" width="70">ผู้สั่งซื้อ</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="170"><font color="#0000FF">@if(!empty($orders->fullname)) {{$orders->fullname}} @endif</font></td>
                                            <td align="right" width="50">Username</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">@if(!empty($orders->username)) {{$orders->username}} @endif</font></td>
                                        </tr>
                                        <tr>
                                            <td align="right" width="70">เบอร์โทรศัพท์</td>
                                            <td align="center" style="border-bottom:1px dashed #000000"><font color="#0000FF">@if(!empty($orders->phone)) {{$orders->phone}} @endif</font></td>
                                            <td align="right" width="50">email</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">{{ $user->email }}</font></td>
                                        </tr>
                                    <tr>
                                        <td align="right" width="70" valign="top">สถานที่จัดส่ง</td>
                                        <td align="center" style="border-bottom:1px dashed #000000" colspan="3"><font color="#0000FF">@if(!empty($orders->tranfer_address)) {{$orders->tranfer_address}} @endif </font></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="70">ตำบล</td>
                                        <td align="center" style="border-bottom:1px dashed #000000"><font color="#0000FF">@if(!empty($orders->address_distric)) {{$orders->address_distric}} @endif </font></td>
                                        <td align="right" width="50">อำเภอ</td>
                                        <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">@if(!empty($orders->address_subdistric)) {{$orders->address_subdistric}} @endif </font></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="70">จังหวัด</td>
                                        <td align="center" style="border-bottom:1px dashed #000000"><font color="#0000FF">@if(!empty($orders->address_province)) {{$orders->address_province}} @endif</font></td>
                                        <td align="right" width="50">รหัสไปรษณีย์</td>
                                        <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">@if(!empty($orders->address_zipcode)) {{$orders->address_zipcode}} @endif </font></td>
                                    </tr>
                                </tbody></table>
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