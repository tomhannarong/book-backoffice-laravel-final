@extends('../layouts.front')

@section('menu_cart' , 'active')

@section('css')

<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.Thailand.js/dist/jquery.Thailand.min.css') }}" />
<style>
.disabled {
    pointer-events: none;
    opacity: 0.4;
}
.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
}
.pagination {
    justify-content: center;
}
.double {
  text-decoration-line: underline;
  text-decoration-style: double;    
}
.line-single{
    text-decoration: underline;
}
.texta{
    width: 100%;
    resize: none;
    font-size: 16px;
    color: #636363;
    height: 90px;
    /* border: 1px solid #ebebeb; */
    border-radius: 5px;
    padding-left: 20px;
    padding-top: 10px;
    margin-bottom: 20px;
    border: 2px solid #ebebeb;
}
/* input.error 
        {
            border: solid 1px red;  
            color: Red;    
        } */
.error {
        color: white;
        border-color: red;
        padding: 1px 20px 1px 20px;
}
.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}
.linear-5 {
    background: rgb(102,25,185);
    background: radial-gradient(circle, rgba(102,25,185,1) 0%, rgba(25,182,223,1) 50%, rgba(42,124,222,1) 100%);
    padding-top: 20px ;
    padding-bottom: 20px;
    border: 2px solid Purple;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    min-height: 1px;
    padding: 0;
}
.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: 0px;
    margin-left: 0px;
}
.filter-control {
    text-align: center;
    margin-bottom: 10px;
    padding-top: 10px;
}
</style>
@endsection

@section('content')

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad py-4">
    <div class="container">
        <div class="filter-control ">
            <div style="width:100%;overflow:hidden;"><center><img src="{{ asset('images/line.png') }}" border="0"></center></div> 
            <font color="black" >
                <b>CHECK OUT</b>
            </font>      
                
            <div style="width:100%;overflow:hidden;"><center><img src="{{ asset('images/line.png') }}" border="0"></center></div>
            
        </div>
        <form id="theForm" class="checkout-form"> <!--checkout-form -->
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
                <div class="col-lg-6 " style="height:auto;">
                    <!-- <div class="checkout-content">
                        <a href="javascript:void(0)" draggable="false" style="background-color: Azure;border: 2px solid Beige;" class="content-btn">Biiling Details</a>
                    </div> -->
                    <div class="card" >
                        <div class="card-header " >
                                <h3 class="card-title text-center"><font color="black" >ชื่อและที่อยู่ของคุณค่ะ</font></h3>     
                        </div>
                        <div class="card-body ">
                            
                            <div class="row "  style=" padding-left:20px;padding-right:20px;padding-top:20px">
                                
                                <div class="col-lg-12">
                                    <div id="accordion" class="address-show">
                                        <!-- <div class="card p-1">
                                            <div class="card-header" id="headingOne">
                                                <a href="javascript:void(0)" class="btn" style="color:green" >
                                                    <font size="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint libero quibusdam ipsa, repellendus dolorem magnam quae, quidem commodi excepturi possimus consectetur incidunt animi maxime saepe quam odio delectus dolor iusto.</font>
                                                </a>
                                                <div class="text-center"><i class="fas fa-check" style="color:blue"></i></div>
                                            </div>
                                        </div>
                                        <div class="card p-1">
                                            <div class="card-header" id="headingOne">
                                                <a href="javascript:void(0)" class="btn" style="color:green" >
                                                    <font size="2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint libero quibusdam ipsa, repellendus dolorem magnam quae, quidem commodi excepturi possimus consectetur incidunt animi maxime saepe quam odio delectus dolor iusto.</font>
                                                </a>
                                                <div class="text-center"><i class="fas fa-check" style="color:blue"></i></div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div> 
                            </div>
                            <hr>
                            <div class="row "  style=" padding:20px">
                            <!-- <form id="theFormAddress" > -->
                                <div id="errorAddress"  class="col-lg-12"></div>
                                <div class=" col-lg-12 text-right ">
                                    <button class="btn btn-sm btn-dark" type="button" id="add_address">
                                    <i class="fas fa-plus"></i> เพิ่มที่อยู่
                                    </button>
                                    <button class="btn btn-sm btn-success disabled" type="button" id="save_address"><i class="far fa-save"></i> บันทึก</button>
                                </div>
                                    <!-- <div class="col-lg-12">
                                        <label for="name">ชื่อผู้สั่งซื้อ : </label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อ - สกุล" value="{{ $user->name}}">
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="tel">เบอร์โทรศัพท์ : </label>
                                        <input type="text" class="form-control" id="tel" name="tel" placeholder="เบอร์โทรศัพท์" value="{{ $user->tel}}">
                                    </div> -->
                                    
                                    <!-- {{ csrf_field() }}
                                    {{ method_field('POST') }} -->
                                    <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                                        <div class="col-lg-12">
                                            <label for="name">ชื่อผู้สั่งซื้อ : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="name" style="margin-bottom: 0px;" name="name" placeholder="ชื่อ - สกุล" value="{{ $address->fullname ?? $user->name_send}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="tel">เบอร์โทรศัพท์ : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="tel" style="margin-bottom: 0px;" name="tel" placeholder="เบอร์โทรศัพท์" value="{{ $address->tel ?? $user->phone_send}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="full_address">ที่อยู่ : </label>
                                            <div class="input-group">
                                                <textarea class="form-control " id="full_address" style="margin-bottom: 0px;"  name="full_address" autocomplete="off" placeholder="ที่อยู่ ,บ้านเลขที่">{{ $address->address ?? $user->address_full }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label for="distric">ตำบล : </label>
                                            <div class="input-group">
                                                <input type="text" class="street-first form-control " style="margin-bottom: 0px;" id="distric"   name="distric" placeholder="ตำบล" autocomplete="off"  value="{{ $address->distric ?? $user->distric}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <label for="subdistric">อำเภอ : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control " style="margin-bottom: 0px;" id="subdistric"  name="subdistric" placeholder="อำเภอ" autocomplete="off" value="{{ $address->subdistric ?? $user->subdistric}}">
                                            </div>
                                        </div>                        
                                        <div class="col-lg-12 ">
                                            <label for="province">จังหวัด : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control " style="margin-bottom: 0px;" id="province"  name="province" placeholder="จังหวัด" autocomplete="off" value="{{ $address->province ?? $user->province}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 ">
                                            <label for="zipcode">รหัสไปรษณีย์ : </label> 
                                            <div class="input-group">
                                                <input type="text" class="form-control " style="margin-bottom: 0px;" id="zipcode"  name="zipcode" placeholder="รหัสไปรษณีย์" autocomplete="off" value="{{ $address->zipcode ?? $user->zipcode}}">                                                         
                                            </div> 
                                        </div> 
                            <!-- </form>         -->
                            </div>
                            
                        </div>
                    </div>     
                </div>
                <div class="col-lg-6 align-middle">
                    <!-- <div class="checkout-content">
                        <a href="javascript:void(0)" draggable="false" style="background-color: Azure;border: 2px solid Beige;" class="content-btn" >Your Order</a>
                    </div> -->
                    <div class="card">
                        <div class="card-header" >
                                <h3 class="card-title text-center"><font color="black" >สรุปรายการสินค้าของคุณ</font></h3>     
                        </div>
                        <div class="card-body ">
                            <div class="place-order" >
                                <div class="order-total" >
                                    <ul class="order-table align-self-center">
                                        <li ><font>Product</font> <span>Total</span></li>
                                        
                                        @if(!empty($tmp_carts_ebooks[0]))
                                            <li style="background-color: PowderBlue" class="text-center">รายการ E-Books</li>
                                            @foreach ($tmp_carts_ebooks as $tmp_cart)
                                        <li class="fw-normal">{{$tmp_cart->getProduct->book_name}} x {{$tmp_cart->sum_quantity}} <span>{{number_format(round((float)($tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity),2),2)}} บาท</span></li>
                                            @endforeach
                                            
                                        @endif
                                        @if(!empty($tmp_carts[0]))
                                            <li style="background-color: PowderBlue" class="text-center">รายการหนังสือปกติ</li>
                                            @foreach ($tmp_carts as $tmp_cart)
                                        <li class="fw-normal">{{$tmp_cart->book_name}} x {{$tmp_cart->sum_quantity}} @if($tmp_cart->can_discount =="true") [ได้รับส่วนลด] @endif<span>{{number_format(round((float)($tmp_cart->price * $tmp_cart->sum_quantity),2),2)}} บาท</span></li>
                                            @endforeach
                                            
                                        @endif
                                        @if(!empty($tmp_carts_buffet[0]))
                                            <li style="background-color: PowderBlue" class="text-center">รายการบุฟเฟ่ต์</li>
                                            @foreach ($tmp_carts_buffet as $tmp_cart)
                                        <li class="fw-normal">{{$tmp_cart->book_name}} x {{$tmp_cart->sum_quantity}} @if($tmp_cart->can_discount =="true") [ได้รับส่วนลด] @endif<span>{{number_format(round((float)($tmp_cart->price * $tmp_cart->sum_quantity),2),2)}} บาท</span></li>
                                            @endforeach
                                            <li style="background-color: " class="text-center">รวมรายการบุฟเฟ่ต์{!! $html_buffet_tfoot !!}</li>
                                        @endif
        
                                        @if(empty($tmp_carts_buffet[0]) && empty($tmp_carts[0]) && empty($tmp_carts_ebooks[0]))
                                            <div class="input-group">
                                                <input type="hidden" name="product_tmp" id="product_tmp" value="">                                       
                                            </div> 
                                        @endif
                                        @if(!empty($tmp_carts_ebooks[0]))
                                            <input type="hidden" name="is_ebook" id="is_ebook" value="is_ebook"> 
                                        @endif
                                                                 
                                        <li class="fw-normal line-single"><font color="YellowGreen " size="3"><b>รวม <span class="line-single">{{number_format(round((float)($total_sub),2),2)}} บาท</span></b></font></li>
                                        <li class="fw-normal"><font color="Green" size="3"><b>ส่วนลด [{{$discount_percen}}%] <span > {{number_format(round((float)($total_discount),2),2)}} บาท</span></b></font></li>
                                        <li class="fw-normal"><font color="DarkOrange" size="3" class="tran_change"><b>ค่าจัดส่ง [ @if(!empty($transport_select)) {{  $transport_select->transport }} @else - @endif ] <span >@if(!empty($transport_select)) {{$transport_select->transport_rate}} @else - @endif บาท</span></b></font></li>
                                        <li class="total-price double"><font color="OrangeRed" size="3"><b>รวมทั้งหมด <span class="double total_final">{{number_format(round((float)($total_final),2),2)}}</span></b></font></li>
                                    </ul>
                                    <input type="hidden" name="discount_percen" id="discount_percen" value="{{$discount_percen}}">
                                    <input type="hidden" name="net_price" id="net_price" value="{{$total_book_price_all}}">
                                    <input type="hidden" name="buffet_check" id="buffet_check" value="{{$buffet_check}}">
                                    <input type="hidden" name="sum_pridce_buf_final" id="sum_pridce_buf_final" value="{{$sum_pridce_buf_final}}">
                                    
                                    @if(!empty($tmp_carts_buffet[0]) || !empty($tmp_carts[0]))
                                        <div class="card-header" style="background-color: LightGreen"><strong>วิธีขนส่ง</strong></div>
                                        <div class="payment-check">
                                            @foreach ($transports as $transport)   
                                                <div class="pc-item m-2">
                                                    <label for="transport{{ $transport->id }}">
                                                        {{$transport->transport}} ( {{ $transport->transport_rate }}  บาท)
                                                        <input class="check_transport" type="radio" id="transport{{ $transport->id }}" name="transport" value="{{ $transport->id }}"  data-name="{{ $transport->transport }}" data-rate="{{ $transport->transport_rate }}" @if(!empty($select_transport_id)) @if($transport->id == $select_transport_id) checked @endif @endif>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>                                                                                                                                                                                                            
                                            @endforeach  
            
                                        </div>
                                    @endif
                                    <div class="order-btn ">
                                        <button type="submit" class="site-btn place-btn hvr-grow">Place Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Shopping Cart Section End -->
    
@endsection

@section('js')
<!-- dependencies for zip mode -->
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/zip.js/zip.js') }}"></script>
<!-- / dependencies for zip mode -->

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/JQL.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/typeahead.bundle.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dist/jquery.Thailand.min.js') }}"></script>

<script>

$(function(){
    //$('.cart-icon').removeClass("cart-icon");
    
    mini_cart(); 
    addressShow('show');

    $('.cart-icon').addClass("disabledbutton");

    $.Thailand({
        database: "{{ asset('plugins/jquery.Thailand.js/database/db.json') }}", 

        $district: $('#distric'),
        $amphoe: $('#subdistric'),
        $province: $('#province'),
        $zipcode: $('#zipcode'),

        onDataFill: function(data){
            console.info('Data Filled', data);
            $('#distric').removeClass('is-invalid');
            $('#subdistric').removeClass('is-invalid');
            $('#province').removeClass('is-invalid');
            $('#zipcode').removeClass('is-invalid');

            $('#province-error').html('').removeClass('bg-danger');
            $('#distric-error').html('').removeClass('bg-danger');
            $('#subdistric-error').html('').removeClass('bg-danger');
            $('#zipcode-error').html('').removeClass('bg-danger');
        },

        onLoad: function(){
            console.info('Autocomplete is ready!');
            $('#loader, .demo').toggle();
        }
    });

   
    if ($("#theForm").length > 0) {
        $("#theForm").validate({
            ignore: [], 
            rules: {
                name: {
                    required: true,
                },
                tel: {
                    required: true,
                    minlength: 9,
                    maxlength: 10,
                    digits: true,
                },
                full_address: {
                    required: true,
                },
                distric: {
                    required: true,
                },
                subdistric: {
                    required: true,
                },
                province: {
                    required: true,
                },
                zipcode: {
                    required: true,
                },
                transport: {
                    required: true,
                },
                product_tmp: {
                    required: true,
                },
                
                
            },
            messages: {
                name: {
                    required: "Please enter name",
                },
                tel: {
                    required: "Please enter telephone number",
                },
                full_address: {
                    required: "Please enter address",
                },
                distric: {
                    required: "Please enter distric",
                },
                subdistric: {
                    required: "Please enter subdistric",
                },
                province: {
                    required: "Please enter province",
                },
                zipcode: {
                    required: "Please enter zipcode",
                },
                transport: {
                    required: "กรุณาเลือกการจัดส่ง",
                },
                product_tmp: {
                    required: "กรุณาเลือกสินค้าอย่างน้อย 1 ชิ้นค่ะ",
                },

                
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            // error.addClass('bg_error');
            // element.closest('.input-group').append(error);
            // element.closest('form-control').append(error);
            error.addClass('bg_error');
            element.closest('.input-group').append(error);
            // element.closest('.pc-item').append(error);
                if ( element.is(":radio") ) 
                {
                    error.appendTo( element.parents('.payment-check') );
                }
            
            
            },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            },
            
        });
    }

    $('body').on('click', '#add_address', function() {
        $('#name').removeClass('disabled').removeAttr('readonly').val('').addClass('bg-white');
        $('#tel').removeClass('disabled').removeAttr('readonly').val('').addClass('bg-white');
        $('#full_address').removeClass('disabled').removeAttr('readonly').addClass('bg-white').html('').val('');
        $('#distric').removeClass('disabled').removeAttr('readonly').val('').addClass('bg-white');
        $('#subdistric').removeClass('disabled').removeAttr('readonly').val('').addClass('bg-white');
        $('#province').removeClass('disabled').removeAttr('readonly').val('').addClass('bg-white');
        $('#zipcode').removeClass('disabled').removeAttr('readonly').val('').addClass('bg-white');
        $('#save_address').removeClass('disabled');

    });
    
    $('body').on('click', '.change_address', function() {
        let id = $(this).data('id');
        let name = $(this).data('fullname');
        let tel = $(this).data('tel');
        let address = $(this).data('address');
        let subdistric = $(this).data('subdistric');
        let distric = $(this).data('distric');
        let province = $(this).data('province');
        let zipcode = $(this).data('zipcode');
        $('#name').addClass('disabled').prop('readonly', true).removeClass('bg-white').val(name);
        $('#tel').addClass('disabled').prop('readonly', true).removeClass('bg-white').val(tel);
        $('#full_address').addClass('disabled').prop('readonly', true).removeClass('bg-white').val(address).html(address);
        $('#distric').addClass('disabled').prop('readonly', true).removeClass('bg-white').css("background-color", "").val(distric);
        $('#subdistric').addClass('disabled').prop('readonly', true).removeClass('bg-white').css("background-color", "").val(subdistric);
        $('#province').addClass('disabled').prop('readonly', true).removeClass('bg-white').css("background-color", "").val(province);
        $('#zipcode').addClass('disabled').prop('readonly', true).removeClass('bg-white').css("background-color", "").val(zipcode);
        $('#errorAddress').html('');
        $('#save_address').addClass('disabled');
        
        addressShow("show",id);
    });
    $('body').on('click', '.btnDelAddress', function() {
        var id = $(this).data('id');
        // alert(id);
        $.LoadingOverlay("show");
        $.ajax({
                url: "{{ url('cart/checkOut') }}" + '/' + id,
                type: "POST",
                data:  {fn:"delete_address" ,_method: 'DELETE'},
                cache:false,
                success: (response) => {
                    if ($.isEmptyObject(response.error)) {
                        console.log(response);
                        console.log(response.success);
                        $.LoadingOverlay("hide");
                        addressShow("show");
                    } else {
                        console.log(response.error);
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            icon: 'error',
                            title: "<strong> Cannot Delete records. </strong>",
                            html: "<h5>Error: </h5>"+text,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                }
            });
    });
    
    $('body').on('click', '#save_address', function() {
        
        
        var name = $('#name').val();
        var tel = $('#tel').val();
        var full_address = $('#full_address').val();
        var distric =$('#distric').val();
        var subdistric =$('#subdistric').val();
        var province = $('#province').val();
        var zipcode = $('#zipcode').val();
        var user_id = "{{$user->id}}";
        $.LoadingOverlay("show");
            $.ajax({
                url: "{{ url('cart/checkOut') }}",
                type: "POST",
                data:  {user_id:user_id,name:name,tel:tel,full_address:full_address,distric:distric,subdistric:subdistric,province:province,zipcode:zipcode},
                cache:false,
                // processData: false,
                // contentType: false,
                success: (response) => {
                    if ($.isEmptyObject(response.error)) {
                        console.log(response);
                        console.log(response.success);
                        $.LoadingOverlay("hide");
                        var text = "<div class='alert alert-success'>";
                        text+= "<strong>" + response.success+ "</strong>";
                        text += "</div>";
                        $('#errorAddress').html(text);
                        $('#name').removeClass('bg-white').addClass('disabled').prop('readonly', true);
                        $('#tel').removeClass('bg-white').addClass('disabled').prop('readonly', true);
                        $('#full_address').removeClass('bg-white').addClass('disabled').prop('readonly', true);
                        $('#distric').removeClass('bg-white').addClass('disabled').prop('readonly', true).css("background-color", "");
                        $('#subdistric').removeClass('bg-white').addClass('disabled').prop('readonly', true).css("background-color", "");
                        $('#province').removeClass('bg-white').addClass('disabled').prop('readonly', true).css("background-color", "");
                        $('#zipcode').removeClass('bg-white').addClass('disabled').prop('readonly', true).css("background-color", "");
                        $('#save_address').addClass('disabled');
                        addressShow("show");
                   
                    } else {
                        console.log(response.error);
                        $.LoadingOverlay("hide");
                        
                        var text = "<div class='alert alert-danger'>";
                        text += "<ul>";
                        response.error.forEach(( element, index) => {
                            text+= "<li><strong>" + element+ "</strong></li>";
                        });
                        text += "</ul>";
                        text += "</div>";
                        $('#errorAddress').html(text);
                        
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: "<strong> Cannot update records. </strong>",
                        //     html: "<h5>Error: </h5>"+text,
                        // });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                }
            });

    });
    $("#theForm").on('submit',(function(e) {
        e.preventDefault();
        
        var Item_id = "{{$user->id}}";
        if ($("#theForm").valid()) {
            $.LoadingOverlay("show");
            $.ajax({
                url: "{{ url('cart/checkOut') }}"+'/' + Item_id,
                type: "POST",
                data:  new FormData(this),
                cache:false,
                processData: false,
                contentType: false,
                success: (response) => {
                    if ($.isEmptyObject(response.error) && $.isEmptyObject(response.warning)) {
                        console.log(response);
                        // console.log(response.success);
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1000,
                        }).then((result) =>{
                            //window.history.back();
                            //location.reload();
                            
                            window.location='{{ url("order") }}';

                            // if(response.is_ebook === 'true'){
                            //     window.location='{{ url("ebook/order") }}';
                            // }else{
                            //     window.location='{{ url("order") }}';
                            // }
                            
                        });
                    } else {
                        if(response.error){
                            console.log(response.error);
                        $.LoadingOverlay("hide");
                        var text = "";
                        response.error.forEach(( element, index) => text+= "<p><strong>("+(index+1)+")." + element+ "</strong></p>");
                        Swal.fire({
                            icon: 'error',
                            title: "<strong> Cannot update records. </strong>",
                            html: "<h5>Error: </h5>"+text,
                        });
                        }else if(response.warning){
                            console.log(response);
                            $.LoadingOverlay("hide");
                            var text = "";
                            response.item_out.forEach(( element, index) => text+= "<p><strong>("+(index+1)+")." + element+ "</strong></p>");
                            // response.item_out.forEach(element => console.log(element));
                            Swal.fire({
                                icon: 'warning',
                                title: "<strong>สินค้าหมด</strong>",
                                html: ""+text,
                            });
                            // console.log(response);
                        }
                        
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                }
            });
        }
    }));

    $(".check_transport").change(function(){ // bind a function to the change event
            if( $(this).is(":checked") ){ // check if the radio is checked
                var name = $(this).data('name');
                var rate = $(this).data('rate');
                var total = rate+{{ $total_book_price_all }} ;
                //alert(total);
                
                var val = $(this).val(); // retrieve the value
                //var html_trans = '<font color="ForestGreen"><i class="fas fa-truck-moving"></i> ค่าจัดส่ง [ '+name+' ]</font> <span>'+rate+' บาท</span>';
                //var html_final = 'Total <span>'+total.toFixed(2)+'</span>';
                Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: 'คุณได้เปลี่ยนวิธีขนส่งเป็น ['+name+']',
                        showConfirmButton: false,
                        timer: 800,
                    }).then((result) => {
                        var  div ="<b>ค่าจัดส่ง [ "+name+" ] <span > "+rate+" บาท</span></b>";
                        
                        $('.tran_change').html(div);
                        $('.total_final').html(total.toFixed(2));
                       // mini_cart();                            
                    });
                
                //$(".transport_name").html(html_trans);
                //$(".total_final").html(html_final);
                //alert(rate);
            }
    });

    // var table =null;

    //tableupdate();
   
    

    // $(".check_transport").change(function(){ // bind a function to the change event
    //         if( $(this).is(":checked") ){ // check if the radio is checked
    //             var name = $(this).data('name');
    //             var rate = $(this).data('rate');
    //             var total = rate+{{ $total_book_price_all }} ;
    //             //alert(total);
                
    //             var val = $(this).val(); // retrieve the value
    //             //var html_trans = '<font color="ForestGreen"><i class="fas fa-truck-moving"></i> ค่าจัดส่ง [ '+name+' ]</font> <span>'+rate+' บาท</span>';
    //             //var html_final = 'Total <span>'+total.toFixed(2)+'</span>';
    //             Swal.fire({
    //                     position: 'top-end',
    //                     icon: 'info',
    //                     title: 'คุณได้เปลี่ยนวิธีขนส่งเป็น ['+name+']',
    //                     showConfirmButton: false,
    //                     timer: 800,
    //                 }).then((result) => {
    //                     tableupdate(name ,rate);
    //                     mini_cart();                            
    //                 });
                
    //             //$(".transport_name").html(html_trans);
    //             //$(".total_final").html(html_final);
    //             //alert(rate);
    //         }
    // });
    // function tableupdate(transport_name='' ,transport_rate='',fn='' , id_cart='',id_book='') {
    //     $.ajax({
    //         url: "{{ url('cart') }}",
    //         type: "GET",
    //         dataType: 'JSON',
    //         cache: false,
    //         //add or demis 
    //         data: {transport_name:transport_name , transport_rate: transport_rate,fn:fn , id_cart:id_cart,id_book:id_book},
    //         success: (response) => {
    //             if ($.isEmptyObject(response.error)) {
    //                 console.log(response);
    //                 console.log(response.success);
    //                 $('#html').html(response.html);
    //                 $('.line-single').html(response.html_total_book_price_all);
    //                 $('#html_quantity_all').html(response.sum_quantity_all);
    //                 //$(".total_final").html(html_final);
    //                 $(".transport_name").html(response.html_transport);
    //                 $('.double').html(response.html_total_final);
    //                 mini_cart();  
    //             } else {
    //                 console.log(response.error);
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: "<strong>" + title + "</strong>",
    //                     text: "Error: " + response.error,
    //                 });
    //             }
    //         }
    //     });
    // }
    
    // });


});    
const addressShow = async(fn='',id='') => { 
    $.ajax({
        url: "{{ url('cart/checkOut') }}",
        type: "POST",
        data:{_method: 'GET',fn:fn ,id:id},
        dataType: 'JSON',
        cache: false,
        success: (response) => {
            if ($.isEmptyObject(response.error)) {
                // console.log(response);
                // console.log(response.success);
                $('.address-show').html(response.html);

            } else {
                console.log(response.error);
                Swal.fire({
                    icon: 'error',
                    title: "<strong> ERROR </strong>",
                    text: "Error: " + response.error,
                });
            }
        }
    });
    
}

</script>

@endsection