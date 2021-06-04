@extends('../layouts.front')

@section('menu_order' , 'active')

@section('css')
<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/> -->
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}" />
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


.img-div {
    position: relative;
    width: 46%;
    /* width: 100%; */
    float:left;
    margin-right:5px;
    margin-left:5px;
    margin-bottom:10px;
    margin-top:10px;
}

.image {
    opacity: 1;
    display: block;
    width: 100%;
    max-width: auto;
    transition: .5s ease;
    backface-visibility: hidden;
}

.middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
}

.img-div:hover .image {
    opacity: 0.3;
}

.img-div:hover .middle {
    opacity: 1;
}

</style>


@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="container">
    <!-- Content Header (Page header) -->
    <section class="content-header py-4">
      <div class="container-fluid">
        <div class="head_text">
            <div class="head_text_string row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <h2 class="">รายละเอียดรายการ</h2>
                </div>
                <div class="option_head_text col-12 col-sm-12 col-md-6 col-lg-6">
                    <div style="float: right;">
                        <ol class="breadcrumb float-sm-right" >
                            <li class="breadcrumb-item" ><a href="{{ url('/') }}">หน้าแรก</a></li>
                            <li class="breadcrumb-item" ><a href="{{ url('order') }}">รายการสั่งซื้อ</a></li>
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
                <div class="card" >
                    <!-- form -->
                        <div class="card-header " >
                               
                                <h3 class="card-title"><i class="nav-icon fas fa-box-open"></i> รายการ <a href="javascript:void(0)" class="btn btn-success btn-xl float-sm-right pay-in-btn  
                                @if(!empty($orders->order_status))
                                    @if($orders->order_status != 'รอชำระเงิน')
                                        disabled
                                    @endif
                                @elseif(!empty($order_buffets->order_status)) 
                                    @if($order_buffets->order_status != 'รอชำระเงิน')
                                        disabled
                                    @endif
                                @else 
                                    @if($order_ebooks->order_status != 'รอชำระเงิน')
                                        disabled
                                    @endif
                                @endif " data-id="@if(!empty($orders->id)){{$orders->id}}@elseif(!empty($order_buffets->id)){{$order_buffets->id}}@else{{$order_ebooks->id}}@endif">
                                <font size="5">แจ้งโอนเงิน</font>
                                </a></h3>                              
                        </div>
                        
                        <div class="card-body ">
                            <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-fixed"  style="width:100%"> <!--class nowrap-->
                                <thead>
                                    <tr>
                                        <th colspan="2">เลขที่ใบสั่งซื้อ : </th>
                                    <th colspan="6">@if(!empty($orders->id)) {{$orders->id}} @elseif(!empty($order_buffets->id)) {{$order_buffets->id}} @else {{$order_ebooks->id}} @endif</th>
                                    </tr>
                                    <tr>
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
                                @if(!empty($order_ebooks->getOrderTran->toArray()))
                                    <tr >
                                        <td colspan="8" class="text-center"><strong>E-Book</strong></td>
                                    </tr>
                                    @php $sum_qua = 0 @endphp
                                    @php $sum_net = 0 @endphp
                                    @foreach ($order_ebooks->getOrderTran as $order)
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
                                    @endforeach
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th colspan="4" align="center" >รวมรายการ E-Book</th>
                                        <th>{{ $sum_qua }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                    </tr>
                                @endif
                                @if(!empty($orders->getOrderTran->toArray()))
                                    <tr >
                                        <td colspan="8" class="text-center"><strong>Book</strong></td>
                                    </tr>
                                    @php $sum_qua = 0 @endphp
                                    @php $sum_net = 0 @endphp
                                    @foreach ($orders->getOrderTran as $order)
                                    @php $sum_qua += $order->quantitys @endphp
                                    @php $sum_net += $order->net @endphp
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td colspan="1">{{ $order->ISBN }}</td>
                                        <td colspan="2">{{ $order->book_name }}</td>
                                        <td>{{ $order->quantitys }}</td>
                                        <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                        <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                        <td>{{ number_format(round((float)$order->net,2),2) }} บาท</td>
                                    </tr>
                                    @endforeach
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th colspan="4" align="center" >รวมรายการหนังสือปกติ</th>
                                        <th>{{ $sum_qua }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                    </tr>
                                @endif
                                @if(!empty($order_buffets->getOrderTran->toArray()))
                                    <tr >
                                        <td colspan="8" class="text-center"><strong>Book Buffet</strong></td>
                                    </tr>
                                    @php $sum_qua = 0 @endphp
                                    @php $sum_net = 0 @endphp
                                    @foreach ($order_buffets->getOrderTran as $order)
                                    @php $sum_qua += $order->quantitys @endphp
                                    @php $sum_net += $order->net @endphp
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td colspan="1">{{ $order->ISBN }}</td>
                                        <td colspan="2">{{ $order->book_name }}</td>
                                        <td>{{ $order->quantitys }}</td>
                                        <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                        <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                        <td><font color="red">(เหมา)</font>{{ number_format(round((float)$order->net,2),2) }} บาท</td>
                                    </tr>
                                    @endforeach
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th colspan="4" align="center" >รวมรายการหนังสือ Buffet</th>
                                        <th>{{ $sum_qua }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                    </tr>


                                @endif
                                </tbody>
    
                                <tfoot>
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th colspan="4" align="center" >รวมรายการทั้งหมด</th>
                                        <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                        <th colspan="2"></th>
                                        <th><span style="text-decoration: underline;">{{ number_format(round((float)$order_ebooks->net_price,2),2) }}</span></th>
                                    </tr>
                                    @if(!empty($orders->getOrderTran->toArray()) || !empty($order_buffets->getOrderTran->toArray()))
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th colspan="4" align="center">ค่าขนส่ง</th>
                                        <th></th>
                                        <th colspan="2">{{ $order->transport ?? $order_buffets->transport }}</th>
                                        <th>{{ $order->transport_rate ?? $order_buffets->transport_rate }}</th>
                                    </tr>
                                    @endif
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th colspan="4" align="center">รวมสุทธิ</th>
                                        <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                        <th colspan="2"></th>
                                        <th>
                                        @if(!empty($orders->getOrderTran->toArray()) || !empty($order_buffets->getOrderTran->toArray()))
                                            <span class="double">{{ number_format(round((float)($order->net_price ?? $order_buffets->net_price) + ($order->transport_rate ?? $order_buffets->transport_rate ),2),2) }}</span>
                                        @else
                                            <span class="double">{{ number_format(round((float)($order_ebooks->net_price) ,2),2) }}</span>                                        
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
                                placeholder="Enter date" autocomplete="off" value="{{ Carbon\Carbon::now()->toDateString() }}">

                        </div>
                        <div class="form-group">
                            <label for="tranfer_time">เวลา : </label>
                            <input type="text" class="form-control timepicker" id="tranfer_time" name="tranfer_time" aria-describedby="tranfer_time"
                                placeholder="Enter time" autocomplete="off" value="{{ Carbon\Carbon::now()->toTimeString() }}">

                        </div>
                        <div class="form-group">
                            <label for="amount">จำนวนเงิน : </label>
                            <input type="number" class="form-control" id="amount" name="amount" aria-describedby="amount"
                                placeholder="Enter amount" autocomplete="off" value="@if(!empty($orders->getOrderTran->toArray()) || !empty($order_buffets->getOrderTran->toArray())){{($order->net_price ?? $order_buffets->net_price)+($order->transport_rate ?? $order_buffets->transport_rate)}}@else{{$order_ebooks->net_price}}@endif">

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

                        <div class="form-group">
                            {{-- <label for="images">Images</label> --}}
                        
                            <label>Upload Slip</label>
                            <div class="input-group ">
                                <span class="input-group-btn ">
                                    <span class="btn btn-outline-danger btn-file">
                                        Browse… <input type="file" name="images[]" id="images" multiple class="form-control " required>
                                    </span>
                                </span>
                                <input type="text" class="form-control text-empty" readonly >
                                <div id="image_preview" style="width:100%;">
                                
                                </div>
                            </div>
                            
                            
                        </div>
                        
                        {{-- <div class="form-group mt-2">
                            <label>Upload Image</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-outline-danger btn-file">
                                        Browse… <input type="file" id="imgInp" name="imgInp">
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly >
                            </div>

                        </div> --}}
                        {{-- <img src="{{ asset('img/no_pic.png') }}" width="250" height="300" id='img-upload' alt="img" class="img-thumbnail"/> --}}
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
    

    <section class="py-4">
        <div class="row justify-content-center pl-3 pr-3">
        
            <div class="col-md-12">
                <div class="card" >
                    <!-- form -->
                        <div class="card-header" >
                                <h3 class="card-title"><i class="nav-icon fas fa-wallet" ></i><font color="black"> ช่องทางการชำระเงิน</font></h3>                          
                        </div>
                        
                        <div class="card-body ">
                            <div class="table-responsive-des">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 text-center">
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
                                            <td align="center" style="border-bottom:1px dashed #000000" width="170"><font color="#0000FF">@if(!empty($orders->id)) {{$orders->id}} @elseif($order_buffets->id) {{$order_buffets->id}} @else {{$order_ebooks->id}} @endif</font></td>
                                            <td align="right" width="70">วันที่ - เวลา</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="240"><font color="#0000FF">@if(!empty($orders->order_date)) {{$orders->order_date}} @elseif($order_buffets->order_date) {{$order_buffets->order_date}} @else {{$order_ebooks->order_date}} @endif 
                                            [ @if(!empty($orders->order_time)) {{$orders->order_time}} @elseif($order_buffets->order_time) {{$order_buffets->order_time}} @else {{$order_ebooks->order_time}} @endif ]
                                            </font></td>
                                    </tr>
                                    <tr>
                                            <td align="right" width="70">ผู้สั่งซื้อ</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="170"><font color="#0000FF">@if(!empty($orders->fullname)) {{$orders->fullname}} @elseif($order_buffets->fullname) {{$order_buffets->fullname}} @else {{$order_ebooks->fullname}} @endif</font></td>
                                            <td align="right" width="50">Username</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">@if(!empty($orders->username)) {{$orders->username}} @elseif($order_buffets->username) {{$order_buffets->username}} @else {{$order_ebooks->username}} @endif</font></td>
                                        </tr>
                                        <tr>
                                            <td align="right" width="70">เบอร์โทรศัพท์</td>
                                            <td align="center" style="border-bottom:1px dashed #000000"><font color="#0000FF">@if(!empty($orders->phone)) {{$orders->phone}} @elseif($order_buffets->phone) {{$order_buffets->phone}} @else {{$order_ebooks->phone}} @endif</font></td>
                                            <td align="right" width="50">email</td>
                                            <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">{{ $user->email }}</font></td>
                                        </tr>
                                    <tr>
                                        <td align="right" width="70" valign="top">สถานที่จัดส่ง</td>
                                        <td align="center" style="border-bottom:1px dashed #000000" colspan="3"><font color="#0000FF">@if(!empty($orders->tranfer_address)) {{$orders->tranfer_address}} @elseif($order_buffets->tranfer_address) {{$order_buffets->tranfer_address}} @else {{$order_ebooks->tranfer_address}} @endif </font></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="70">ตำบล</td>
                                        <td align="center" style="border-bottom:1px dashed #000000"><font color="#0000FF">@if(!empty($orders->address_distric)) {{$orders->address_distric}} @elseif($order_buffets->address_distric) {{$order_buffets->address_distric}} @else {{$order_ebooks->address_distric}} @endif </font></td>
                                        <td align="right" width="50">อำเภอ</td>
                                        <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">@if(!empty($orders->address_subdistric)) {{$orders->address_subdistric}} @elseif($order_buffets->address_subdistric) {{$order_buffets->address_subdistric}} @else {{$order_ebooks->address_subdistric}} @endif </font></td>
                                    </tr>
                                    <tr>
                                        <td align="right" width="70">จังหวัด</td>
                                        <td align="center" style="border-bottom:1px dashed #000000"><font color="#0000FF">@if(!empty($orders->address_province)) {{$orders->address_province}} @elseif($order_buffets->address_province) {{$order_buffets->address_province}} @else {{$order_ebooks->address_province}} @endif</font></td>
                                        <td align="right" width="50">รหัสไปรษณีย์</td>
                                        <td align="center" style="border-bottom:1px dashed #000000" width="190"><font color="#0000FF">@if(!empty($orders->address_zipcode)) {{$orders->address_zipcode}} @elseif($order_buffets->address_zipcode) {{$order_buffets->address_zipcode}} @else {{$order_ebooks->address_zipcode}} @endif </font></td>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> -->
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
$(document).ready(function() {
  var fileArr = [];
   $("#images").change(function(){
      // check if fileArr length is greater than 0
       if (fileArr.length > 0) fileArr = [];
     
        $('#image_preview').html("");
        var total_file = document.getElementById("images").files;
        if (!total_file.length) return;
        for (var i = 0; i < total_file.length; i++) {
          if (total_file[i].size > 1048576) {
            return false;
          } else {
            fileArr.push(total_file[i]);
            $('#image_preview').append("<div class='img-div' id='img-div"+i+"'><img src='"+URL.createObjectURL(event.target.files[i])+"' class='img-responsive image img-thumbnail' title='"+total_file[i].name+"'><div class='middle'><button id='action-icon' value='img-div"+i+"' class='btn btn-danger' role='"+total_file[i].name+"'><i class='fa fa-trash'></i></button></div></div>");
          }
        }
   });
  
  $('body').on('click', '#action-icon', function(evt){
      var divName = this.value;
      var fileName = $(this).attr('role');
      $(`#${divName}`).remove();
    
    
      for (var i = 0; i < fileArr.length; i++) {
        if (fileArr[i].name === fileName) {
          fileArr.splice(i, 1);
        //   file_name += fileArr[i].name + ',' ;
        // console.log(fileArr[i].name);
        }
      }
      var file_name_new = '';
      for (var i = 0; i < fileArr.length; i++) {
        file_name_new += fileArr[i].name + ',' ;
      }
      $('.text-empty').val(file_name_new);
      console.log(file_name_new);
    //   alert(FileListItem(fileArr));
    document.getElementById('images').files = FileListItem(fileArr);
      evt.preventDefault();
  });
  
   function FileListItem(file) {
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }
});
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
                images: {
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
                images: {
                    images: "Please enter image",
                    extension: "Please choose file jpeg,png,jpg,gif,svg only"
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
                url: "{{ url('order') }}",
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
                            title: 'แจ้งชำระเงินสำเร็จแล้วค่ะ',
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
        $("#images").val(''); 
        $(".text-empty").val(''); 
        $("#image_preview").html(''); 
    });

    $(".check_pay").change(function(){ // bind a function to the change event
            if( $(this).is(":checked") ){ // check if the radio is checked
                var id = $(this).data('id');
                var des = $('#payment_des_val'+id).val();
                //alert(des);
                $('#des_payment').html(des);
            }
    });
})

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