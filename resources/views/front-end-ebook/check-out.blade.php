@extends('../layouts.front-ebook')

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
.checkout-section {
    padding-top: 0;
    padding-bottom: 80px;
}

</style>
@endsection

@section('content')

<!-- Shopping Cart Section Begin -->
<section class="checkout-section spad ">
    <div class="py-4">
        <center>
            <h1>
            <strong>
            Check Out
            </strong><br/>
            </h1>
        </center>
    </div>
    <div class="container">
        
        <form id="theForm" class="checkout-form"> <!--checkout-form -->
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row center">
                
                <div class="col-lg-12">
                    <!-- <div class="checkout-content">
                        <a href="javascript:void(0)" draggable="false" style="background-color: Azure;border: 2px solid Beige;" class="content-btn" >Your Order</a>
                    </div> -->
                    <div class="card" style="border:0; border: 0px solid #ebebeb;">
                        <!-- <div class="card-header">
                                <h3 class="card-title text-center"><font color="black">สรุปรายการสินค้าของคุณ</font></h3>     
                        </div> -->
                        <div class="card-body ">
                            <div class="place-order" >
                                <div class="order-total" >
                                    <ul class="order-table align-self-center">
                                        <li ><font>Product</font> <span>Total</span></li>
                                        
                                        @if(!empty($tmp_carts_ebooks[0]))
                                            <li style="background-color: PowderBlue" class="text-center">รายการ E-Books</li>
                                            @foreach ($tmp_carts_ebooks as $tmp_cart)
                                        <li class="fw-normal">{{$tmp_cart->product_name}} x {{$tmp_cart->sum_quantity}} <span>{{number_format(round((float)($tmp_cart->product_price * $tmp_cart->sum_quantity),2),2)}} บาท</span></li>
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
                                        <li class="total-price double"><font color="OrangeRed" size="3"><b>รวมทั้งหมด <span class="double total_final">{{number_format(round((float)($total_final),2),2)}}</span></b></font></li>
                                    </ul>
                                    <input type="hidden" name="discount_percen" id="discount_percen" value="{{$discount_percen}}">
                                    <input type="hidden" name="net_price" id="net_price" value="{{$total_book_price_all}}">
                                    <input type="hidden" name="buffet_check" id="buffet_check" value="{{$buffet_check}}">
                                    <input type="hidden" name="sum_pridce_buf_final" id="sum_pridce_buf_final" value="{{$sum_pridce_buf_final}}">
                                    
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
    
    mini_cart('show','','ebook');  

    $('.cart-icon').addClass("disabledbutton");

    $.Thailand({
        database: "{{ asset('plugins/jquery.Thailand.js/database/db.json') }}", 

        $district: $('#distric'),
        $amphoe: $('#subdistric'),
        $province: $('#province'),
        $zipcode: $('#zipcode'),

        onDataFill: function(data){
            console.info('Data Filled', data);
            
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
                product_tmp: {
                    required: true,
                }, 
            },
            messages: {
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
                    if ($.isEmptyObject(response.error)) {
                        console.log(response);
                        console.log(response.success);
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
                            if(response.is_ebook === 'true'){
                                window.location='{{ url("ebook/order") }}';
                            }else{
                                window.location='{{ url("order") }}';
                            }
                            
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
});    

</script>

@endsection