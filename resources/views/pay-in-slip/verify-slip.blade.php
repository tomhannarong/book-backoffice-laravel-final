@extends('../layouts.app')

@section('menu_pay_in_slip' , 'active')

@section('css')
<!-- xZoom -->
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/xZoom/css/xzoom.css') }}" media="all" /> --}}
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('plugins/ez-plus/css/jquery.fancybox-plus.css') }}" media="screen" /> --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/ez-plus/css/jquery.ez-plus.css') }}"  />
  
  
<link rel="stylesheet" type="text/css"
href="https://cdn.jsdelivr.net/gh/igorlino/fancybox-plus@1.3.6/css/jquery.fancybox-plus.css" media="screen"/>
<style>
a.disabled {
  pointer-events: none;
  cursor: default;
}
.double {
  text-decoration-line: underline;
  text-decoration-style: double;    
}
#gallery_01 img {
    border: 2px solid white;
    width: 96px;
}

#gallery_09 img {
    border: 2px solid white;
    width: 96px;
}

.active img {
    border: 2px solid #333 !important;
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
                                    <td colspan="4">{{ $tranfer[0]->account_tranfer }}</td>
                                    
                                </tr>
                                <tr>
                                    <th colspan="2">โอนมายังธนาคาร : </th>
                                    <td colspan="4">{{ $tranfer[0]->bank_tranfer }}</td>
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
                                    <td colspan="2">{{ $tranfer[0]->username }}</td>
                                    <td colspan="2">{{ formatDateThai($tranfer[0]->tranfer_date.' '.$tranfer[0]->tranfer_time) }}</td>
                                    <td>{{ formatTimeThai($tranfer[0]->tranfer_date.' '.$tranfer[0]->tranfer_time) }}</td>
                                    <td>{{ number_format(round((float)$tranfer[0]->amount,2),2) }}</td>
                                   
                                    
                                </tr>
                                
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;" colspan="7" >
                                        @php $i =0 @endphp
                                        {{-- <img id="img_01" src="small/image1.jpg" data-zoom-image="large/image1.jpg"/> --}}
                                        {{-- <img id="zoom_04" src="{{ asset('storage/slip-images/thumbnail/'.$tranfer[0]->filename) }}" data-zoom-image="{{ asset('storage/slip-images/'.$tranfer[0]->filename) }}"/> --}}
                                            

                                        <div class="zoom-left">
                                            <img class="zoom-img" id="zoom_03f"
                                                 src="{{ asset('storage/slip-images/thumbnail/'.$tranfer[0]->filename) }}"
                                                 data-zoom-image="{{ asset('storage/slip-images/'.$tranfer[0]->filename) }}"
                                                 width="411"/>

                                            <div id="gallery_01f" style="width:500px;float:left;">
                                                @foreach ($tranfer as $image_slip)
                                                <a href="#" class="elevatezoom-gallery active" data-update=""
                                                   data-image="{{ asset('storage/slip-images/'.$image_slip->filename) }}"
                                                   data-zoom-image="{{ asset('storage/slip-images/'.$image_slip->filename) }}">
                                                    <img src="{{ asset('storage/slip-images/thumbnail/'.$image_slip->filename) }}"
                                                         width="100"/></a>
                                                @endforeach
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                <!-- form -->
            </div>
        </div>

        <div class="col-md-7">
            <div class="card" >
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
                        <table id="example" class="table  table-bordered "  style="width:100%"> <!--class nowrap-->
                            <thead >
                                <tr>
                                    <th colspan="2">เลขที่ใบสั่งซื้อ : </th>
                                    <th colspan="2">@if(!empty($orders->id)) {{$orders->id}} @elseif(!empty($order_buffets->id)) {{$order_buffets->id}} @else {{$order_ebooks->id}} @endif</th>
                                    <th colspan="4" style="border-left:0" class="text-center">                                        
                                        <a href="javascript:void(0)" class="btn btn-primary btnNext @if($tranfer[0]->tranfer_status != 'รอตรวจสอบ') disabled @endif" 
                                        data-id="@if(!empty($orders->id)){{$orders->id}}@elseif(!empty($order_buffets->id)){{$order_buffets->id}}@else{{$order_ebooks->id}}@endif" 
                                        data-val="@if(!empty($orders->order_status)){{$orders->order_status}}@elseif(!empty($order_buffets->order_status)){{$order_buffets->order_status}}@else{{$order_ebooks->order_status}}@endif" 
                                        data-id-tran="{{ $tranfer[0]->tranfer_id }}" data-fn="NextStage" ><i class="fas fa-check"></i> ยืนยันการชำระเงิน</a>  
                                        <a href="javascript:void(0)" class="btn btn-danger btnRej @if($tranfer[0]->tranfer_status != 'รอตรวจสอบ') disabled @endif" 
                                        data-id="@if(!empty($orders->id)){{$orders->id}}@elseif(!empty($order_buffets->id)){{$order_buffets->id}}@else{{$order_ebooks->id}}@endif" 
                                        data-val="@if(!empty($orders->order_status)){{$orders->order_status}}@elseif(!empty($order_buffets->order_status)){{$order_buffets->order_status}}@else{{$order_ebooks->order_status}}@endif" 
                                        data-id-tran="{{ $tranfer[0]->tranfer_id }}" data-fn="rollback"><i class="fas fa-times"></i> ส่งกลับ</a>                              
                                    </th>
                                </tr>
                                <tr style="color: black;background-color: whitesmoke">
                                    <th style="width:5%">ที่</th>
                                    <th colspan="1" width="">ISBN</th>                                        
                                    <th colspan="2" width="">รายการ</th>
                                    
                                    <th style="width:5%" class="text-center">เล่ม</th>
                                    <th>ราคา/เล่ม</th>
                                    <th>ส่วนลด</th>
                                    <th class="text-center">รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($order_ebooks->getOrderTran->toArray()))
                                <tr style="color: black;background-color: LightSteelBlue">
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
                                    <td colspan="2">{{ $order->book_name }}</td>
                                    
                                    <td class="text-center">{{ $order->quantitys }}</td>
                                    <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                    <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                    <td class="text-center">{{ number_format(round((float)$order->net,2),2) }}</td>
                                </tr>
                                @endforeach
                                <tr style="color: black;background-color: whitesmoke ;text-align: center; vertical-align: middle;">
                                    <th colspan="4" align="center" >รวมรายการ E-Book</th>
                                    <th>{{ $sum_qua }}</th>
                                    <th colspan="2"></th>
                                    <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                </tr>
                            @endif
                            @if(!empty($orders->getOrderTran->toArray()))
                                <tr style="color: black;background-color: LightSteelBlue">
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
                                    <td class="text-center">{{ $order->quantitys }}</td>
                                    <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                    <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                    <td class="text-center">{{ number_format(round((float)$order->net,2),2) }}</td>
                                </tr>
                                @endforeach
                                <tr style="color: black;background-color: whitesmoke ;text-align: center; vertical-align: middle;">
                                    <th colspan="4" align="center" >รวมรายการหนังสือปกติ</th>
                                    <th>{{ $sum_qua }}</th>
                                    <th colspan="2"></th>
                                    <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                </tr>
                            @endif
                            @if(!empty($order_buffets->getOrderTran->toArray()))
                                <tr style="color: black;background-color: LightSteelBlue">
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
                                    <td class="text-center">{{ $order->quantitys }}</td>
                                    <td>{{ number_format(round((float)$order->product_price,2),2) }}</td>
                                    <td>{{ ($order->percent_discount ?? '0').'%' }}</td>
                                    <td class="text-center"><font color="red">(เหมา)</font>{{ number_format(round((float)$order->net,2),2) }} บาท</td>
                                </tr>
                                @endforeach
                                <tr style="color: black;background-color: whitesmoke ;text-align: center; vertical-align: middle;">
                                    <th colspan="4" align="center" >รวมรายการหนังสือ Buffet</th>
                                    <th>{{ $sum_qua }}</th>
                                    <th colspan="2"></th>
                                    <th><span style="text-decoration: underline;">{{ number_format(round((float)$sum_net,2),2) }}</span></th>
                                </tr>


                            @endif
                            </tbody>

                            <tfoot>
                                <tr style="color: black;background-color: GhostWhite ;text-align: center; vertical-align: middle;">
                                    <th colspan="4" align="center" >รวมรายการทั้งหมด</th>
                                    <th>{{ $quantitys_sum->quantitys_sum }}</th>
                                    <th colspan="2"></th>
                                    <th><span style="text-decoration: underline;">{{ number_format(round((float)$order_ebooks->net_price,2),2) }}</span></th>
                                </tr>
                                @if(!empty($orders->getOrderTran->toArray()) || !empty($order_buffets->getOrderTran->toArray()))
                                <tr style="color: black;background-color: GhostWhite ;text-align: center; vertical-align: middle;">
                                    <th colspan="4" align="center">ค่าขนส่ง</th>
                                    <th></th>
                                    <th colspan="2">{{ $order->transport ?? $order_buffets->transport }}</th>
                                    <th>{{ $order->transport_rate ?? $order_buffets->transport_rate }}</th>
                                </tr>
                                @endif
                                <tr style="color: black;background-color: GhostWhite ;text-align: center; vertical-align: middle;">
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

        {{-- <div class="col-md-7">
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
                                    <th colspan="2" class="text-center">เลขที่ใบสั่งซื้อ : </th>
                                    <th colspan="1">{{ $orders[0]->order_id ?? $order_buffets[0]->order_id }}</th>
                                    <th colspan="4" style="border-left:0" class="text-center">
                                        
                                        <a href="javascript:void(0)" class="btn btn-primary btn-lg btnNext" 
                                        data-id="@if(!empty($orders[0]->order_id)){{$orders[0]->order_id}}@elseif(!empty($order_buffets[0]->order_id)){{$order_buffets[0]->order_id}}@else{{$order_ebooks[0]->order_id}}@endif" 
                                        data-val="@if(!empty($orders[0]->order_status)){{$orders[0]->order_status}}@elseif(!empty($order_buffets[0]->order_status)){{$order_buffets[0]->order_status}}@else{{$order_ebooks[0]->order_status}}@endif" 
                                        data-id-tran="{{ $tranfer->id }}" data-fn="NextStage" ><i class="fas fa-arrow-circle-right"></i> NEXT STAGE</a>                                
                                    </th>
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
                                @if(!empty($order_ebooks->toArray()))
                                    <tr>
                                        <td colspan="7"  class="text-center">E-BOOK</td>
                                    </tr>
                                    @foreach ($order_ebooks as $order)
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
                                @endif
                                @if(!empty($orders->toArray()))
                                    <tr>
                                        <td colspan="7" class="text-center">BOOK</td>
                                    </tr>
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
                                @endif
                                @if(!empty($order_buffets->toArray()))
                                    <tr>
                                        <td colspan="7" class="text-center">BOOK BUFFET</td>
                                    </tr>   
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
                                @endif
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
        </div> --}}
    </div>
  
    

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript"
  src="https://cdn.jsdelivr.net/gh/igorlino/fancybox-plus@1.3.6/src/jquery.fancybox-plus.js"></script>
{{-- <script src="{{ asset('plugins/ez-plus/js/jquery.fancybox-plus.js') }}"></script> --}}
<script src="{{ asset('plugins/ez-plus/js/jquery.ez-plus.js') }}"></script>



{{-- <script src="{{ asset('plugins/xZoom/js/xzoom_setup.js') }}"></script>  --}}
{{-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/gh/igorlino/elevatezoom-plus@1.2.3/src/jquery.ez-plus.js"></script> --}}

<script type="text/javascript">
    $(document).ready(function () {
        $("#zoom_03f").ezPlus({
            constrainType: "height",
            // constrainSize: 274,
            zoomType: "lens",
            containLensZoom: true,
            // scrollZoom: true,
            // zoomType: "lens",
            lensShape: "round",
            lensSize: 200,
            gallery: 'gallery_01f',
            cursor: 'pointer',
            galleryActiveClass: "active",
        });

        $("#zoom_03f").bind("click", function (e) {
            var ez = $('#zoom_03f').data('ezPlus');
            ez.closeAll(); //NEW: This function force hides the lens, tint and window
            $.fancyboxPlus(ez.getGalleryList());

            return false;
        });

    });

</script>
<script>
    var table, Item_id , Item_id_tran , Item ,Item_fn = null;

    // $("#zoom_04").ezPlus();
    // $('#zoom_03').ezPlus({
    //     gallery: 'gallery_01', cursor: 'pointer', galleryActiveClass: 'active',
    //     imageCrossfade: true, loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
    // });

    // //pass the images to Fancybox
    // $('#zoom_03').bind('click', function (e) {
    //     var ez = $('#zoom_03').data('ezPlus');
    //     $.fancyboxPlus(ez.getGalleryList());
    //     return false;
    // });

    $('body').on('click', '.btnNext', function() {
        Item_id = $(this).data("id");
        Item_id_tran = $(this).data("id-tran");
        Item = $(this).data("val");
        Item_fn = $(this).data("fn");

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
                    url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                    data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            Swal.fire({
                                title: 'ยืนยันการชำระเงินสำเร็จแล้วค่ะ',
                                icon: 'success',
                            }).then((value) => {
                                var av_book = response.av_book ;
                                var av_ebook = response.av_ebook ;
                                if(av_ebook =="false"){ // dont have ebook
                                    window.history.back();
                                }
                                if(av_ebook =="true"){ // have a ebook
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
                                                url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
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
                                }
                                



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

    $('body').on('click', '.btnRej', function() {
        Item_id = $(this).data("id");
        Item_id_tran = $(this).data("id-tran");
        Item = $(this).data("val");
        Item_fn = $(this).data("fn");
        
        Swal.fire({
            title: 'ระบุเหตุผล',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: (res) => {
                if(res){
                    // alert(res)
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                        data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn,reason:res},
                        // success: (response) => {
                        //     if ($.isEmptyObject(response.error)) {
                        //         // Swal.fire({
                        //         //     icon: 'success',
                        //         //     title: "ส่งกลับเรียบร้อยแล้วค่ะ",
                        //         //     text: "ERROR: " + response.error,
                        //         // });
                        //         // Swal.fire({
                        //         //     position: 'top-end',
                        //         //     icon: 'success',
                        //         //     title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                        //         //     showConfirmButton: false,
                        //         //     timer: 1500
                        //         // })
                        //         // console.log(response);
                        //         // Swal.fire({
                        //         //     title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                        //         //     icon: 'success',
                        //         // }).then((value) => {
                        //         //     window.history.back();
                        //         // });
                        //     } 
                        // },
                    });
                }else{
                    Swal.showValidationMessage(
                    `กรอบเหตุผลด้วยค่ะ`
                    )
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                    showConfirmButton: false,
                    timer: 1000
                }).then((value) => {
                    window.history.back();
                });
            }
        })

        // Swal.fire({
        //     title: 'ยืนยันการชำระเงิน?',
        //     text: "คุณตรวจสอบและยืนยันการชำระเงินแล้ว",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: 'dark',
        //     confirmButtonText: 'Yes, I confirm that'
        // }).then((result) => {
        //     if (result.value) {
        //         $.ajax({
        //             type: "POST",
        //             url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
        //             data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
        //             success: (response) => {
        //                 if ($.isEmptyObject(response.error)) {
        //                     console.log(response);
        //                     console.log(response.success);
        //                     Swal.fire({
        //                         title: 'ยืนยันการชำระเงินสำเร็จแล้วค่ะ',
        //                         icon: 'success',
        //                     }).then((value) => {
        //                         var av_book = response.av_book ;
        //                         var av_ebook = response.av_ebook ;
        //                         if(av_ebook =="false"){ // dont have ebook
        //                             window.history.back();
        //                         }
        //                         if(av_ebook =="true"){ // have a ebook
        //                             Swal.fire({
        //                             title: 'อนุมัติการอ่าน?',
        //                             text: "คุณยืนยันอนุมัติการอ่าน E-Books ในรายการนี้ทั้งหมด",
        //                             icon: 'info',
        //                             showCancelButton: true,
        //                             confirmButtonColor: '#3085d6',
        //                             cancelButtonColor: 'dark',
        //                             confirmButtonText: 'Yes, I confirm that'
        //                             }).then((result) => {
        //                                 if (result.value) {
        //                                     Item_fn = "approve_read";
        //                                     $.ajax({
        //                                         type: "POST",
        //                                         url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
        //                                         data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
        //                                         success: (response) => {
        //                                             if ($.isEmptyObject(response.error)) {
        //                                                 console.log(response);
        //                                                 Swal.fire({
        //                                                     title: 'ยืนยันอนุมัติการอ่าน E-Books สำเร็จแล้วค่ะ',
        //                                                     icon: 'success',
        //                                                 }).then((value) => {
        //                                                     window.history.back();
        //                                                 });
        //                                             } 
        //                                         },
        //                                     });
        //                                 }else{
        //                                     window.history.back();
        //                                 }
        //                             });
        //                         }
                                



        //                     });
        //                 } else {
        //                     console.log(response.error);
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: "Cannot delete records.",
        //                         text: "ERROR: " + response.error,
        //                     });
        //                 }
        //             },
        //             error: (response) => {
        //                 console.log('Error:', response);
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: "<strong>Cannot delete records.</strong>",
        //                     html: "<strong>Error Code: </strong>" + response
        //                         .status + "<p><strong>Message: </strong>" +
        //                         JSON.stringify(response.responseJSON
        //                             .message) + "</p>",
        //                 });
        //             }
        //         });
        //     }
        // });
    });
    
</script>

@endsection