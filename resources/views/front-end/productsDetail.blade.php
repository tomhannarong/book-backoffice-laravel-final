@extends('../layouts.front')

@section('menu_cart' , 'active')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

  <!-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>

  <link href="{{ asset('plugins/emojionearea/emojionearea.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('plugins/lightgallery/dist/css/lightgallery.css') }}" rel="stylesheet"/>
  
<style>
.cropped1 {
            width: 1000px; /* width of container */
            /* height: 325px; height of container */
            height: 100px; height of container
            object-fit: cover;
            /* border: 5px solid black; */
        }
.error {
        color: black;
        border-color: red;
        padding: 1px 20px 1px 20px;
}
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
a:hover {   
  /* background-color: yellow; */
  color: Navy;
}

.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}

.linear-4 {
background: rgb(0,36,2);
background: linear-gradient(90deg, rgba(0,36,2,1) 0%, rgba(40,121,9,1) 20%, rgba(6,166,81,1) 54%, rgba(3,204,134,1) 79%, rgba(0,212,255,1) 97%);
}




.rate-list {
	 /* width: 600px;
	 text-align: center;
	 position: absolute;
	 top: 10%;
	 left: 50%;
	 margin-left: -300px; */
}
 .rate-list .rate-list-ul li {
	 float: left;
	 list-style: none;
	 padding: 10px;
	 margin-right: 20px;
	 cursor: pointer;
}
 .rate-list .rate-list-ul li .fa-star {
	 font-size: 55px;
	 color: white;
	 text-shadow: 4px 4px 8px black;
	 transition: all 0.5s linear;
}
 .rate-list .total {
	 /* position: absolute;
	 margin-top: 200px; */
}
 .rate-list .total .totalResult {
    font-size: 60px;
	 /* font-size: 45px;
	 position: absolute;
	 width: 100px;
	 height: 50px;
	 text-align: center;
	 left: 50%;
	 margin-left: -50px; */
	 opacity: 0;
}
 .rate-list .total .totalResult.move {
	 /* font-size: 120px; */
     font-size: 60px;
	 opacity: 1;
	 animation: fade 2s linear;
}
 .redStar i.fa.fa-star {
	 color: Gold;
}
 @keyframes fade {
	 0%, 100% {
		 opacity: 0;
	}
	 50% {
		 opacity: 1;
	}
}


.colorGold{
    color:Gold
}


.pagination > li > a
{
    background-color: white;
    color: #5A4181;
}

.pagination > li > a:focus,
.pagination > li > a:hover,
.pagination > li > span:focus,
.pagination > li > span:hover
{
    color: #5a5a5a;
    background-color: #eee;
    border-color: #ddd;
}

.pagination > .active > a
{
    color: white;
    background-color: #5A4181 !Important;
    border: solid 1px #5A4181 !Important;
}

.pagination > .active > a:hover
{
    background-color: #5A4181 !Important;
    border: solid 1px #5A4181;
}








/* .demo-gallery > ul {
    margin-bottom: 0;
}
.demo-gallery > ul > li {
    float: left;
    margin-bottom: 15px;
    margin-right: 20px;
    width: 200px;
}
.demo-gallery > ul > li a {
    border: 3px solid #FFF;
    border-radius: 3px;
    display: block;
    overflow: hidden;
    position: relative;
    float: left;
}
.demo-gallery > ul > li a > img {
    -webkit-transition: -webkit-transform 0.15s ease 0s;
    -moz-transition: -moz-transform 0.15s ease 0s;
    -o-transition: -o-transform 0.15s ease 0s;
    transition: transform 0.15s ease 0s;
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1);
    height: 100%;
    width: 100%;
}
.demo-gallery > ul > li a:hover > img {
    -webkit-transform: scale3d(1.1, 1.1, 1.1);
    transform: scale3d(1.1, 1.1, 1.1);
}
.demo-gallery > ul > li a:hover .demo-gallery-poster > img {
    opacity: 1;
}
.demo-gallery > ul > li a .demo-gallery-poster {
    background-color: rgba(0, 0, 0, 0.1);
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    -webkit-transition: background-color 0.15s ease 0s;
    -o-transition: background-color 0.15s ease 0s;
    transition: background-color 0.15s ease 0s;
}
.demo-gallery > ul > li a .demo-gallery-poster > img {
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    opacity: 0;
    position: absolute;
    top: 50%;
    -webkit-transition: opacity 0.3s ease 0s;
    -o-transition: opacity 0.3s ease 0s;
    transition: opacity 0.3s ease 0s;
}
.demo-gallery > ul > li a:hover .demo-gallery-poster {
    background-color: rgba(0, 0, 0, 0.5);
}
.demo-gallery .justified-gallery > a > img {
    -webkit-transition: -webkit-transform 0.15s ease 0s;
    -moz-transition: -moz-transform 0.15s ease 0s;
    -o-transition: -o-transform 0.15s ease 0s;
    transition: transform 0.15s ease 0s;
    -webkit-transform: scale3d(1, 1, 1);
    transform: scale3d(1, 1, 1);
    height: 100%;
    width: 100%;
}
.demo-gallery .justified-gallery > a:hover > img {
    -webkit-transform: scale3d(1.1, 1.1, 1.1);
    transform: scale3d(1.1, 1.1, 1.1);
}
.demo-gallery .justified-gallery > a:hover .demo-gallery-poster > img {
    opacity: 1;
}
.demo-gallery .justified-gallery > a .demo-gallery-poster {
    background-color: rgba(0, 0, 0, 0.1);
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    -webkit-transition: background-color 0.15s ease 0s;
    -o-transition: background-color 0.15s ease 0s;
    transition: background-color 0.15s ease 0s;
}
.demo-gallery .justified-gallery > a .demo-gallery-poster > img {
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    opacity: 0;
    position: absolute;
    top: 50%;
    -webkit-transition: opacity 0.3s ease 0s;
    -o-transition: opacity 0.3s ease 0s;
    transition: opacity 0.3s ease 0s;
}
.demo-gallery .justified-gallery > a:hover .demo-gallery-poster {
    background-color: rgba(0, 0, 0, 0.5);
}
.demo-gallery .video .demo-gallery-poster img {
    height: 48px;
    margin-left: -24px;
    margin-top: -24px;
    opacity: 0.8;
    width: 48px;
}
.demo-gallery.dark > ul > li a {
    border: 3px solid #04070a;
}
.home .demo-gallery {
    padding-bottom: 80px;
} */

.vcenter {
    display: inline-block;
    vertical-align: middle;
    float: none;
}

.lg-backdrop.in {
    opacity: 0.20;
}
.fixed-size.lg-outer .lg-inner {
  background-color: black;
}
.fixed-size.lg-outer .lg-sub-html {
  position: absolute;
  text-align: left;
}
.fixed-size.lg-outer .lg-toolbar {
  background-color: transparent;
  height: 0;
}
.fixed-size.lg-outer .lg-toolbar .lg-icon {
  color: #FFF;
}
.fixed-size.lg-outer .lg-img-wrap {
  padding: 12px;
}
</style>
@endsection



@section('content')
    <section class="content-header mt-3 py-3">
      <div class="container">
        <div class="head_text">
            <div class="head_text_string row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <h2 class="">{{ $products_alls->book_name }}</h2>
                </div>
                <div class="option_head_text col-12 col-sm-12 col-md-6 col-lg-6">
                    <div style="float: right;">
                        <ol class="breadcrumb float-sm-right" >
                            <li class="breadcrumb-item" ><a href="{{ url('/') }}">หน้าแรก</a></li>
                              @if($product_type == "product_blame")
                                  <li class="breadcrumb-item" ><a href="{{ url('/products/blame') }}">สินค้ามือหนึ่งสภาพเก่า</a></li>
                              @elseif($product_type == "product_serie")
                                  <li class="breadcrumb-item" ><a href="{{ url('/products/serie') }}">ซีรีส์ชุด</a></li>
                              @elseif($product_type == "product_wait_fiction")
                                  <li class="breadcrumb-item" ><a href="{{ url('/products/waitFiction') }}">นิยายรอตีพิมพ์</a></li>
                              @elseif($product_type == "product_best_seller")
                                  <li class="breadcrumb-item" ><a href="{{ url('/products/bestSeller') }}">นิยายขายดี</a></li>
                              @elseif($product_type == "product_buffet")
                                  <li class="breadcrumb-item" ><a href="{{ url('/products/buffet') }}">บุฟเฟ่ต์</a></li>
                              @else
                                  <li class="breadcrumb-item" ><a href="{{ url('/products') }}">สินค้าปกติ</a></li>
                              @endif
                            <li class="breadcrumb-item active" >{{ $products_alls->book_name }}</li>  
                          </ol>
                    </div>
                </div>
            </div>
            
                
                   
        </div>
             
      </div><!-- /.container-fluid -->
    </section>
<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-5">
                <div class="card ">
                    <div class="card-header ">
                            <h4 class="card-title "><font color="black">รายละเอียดสินค้า</font></h4>
                            
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 text-center">

                                @if($product_gallery_photo) 
                                    <!-- <a href="/public/storage/book-images/{{ $products_alls->picture  }}" class="image-popup-no-margins" >
                                        <img style="background-color: HoneyDew;border: 2px solid DarkBlue;" src="{{ asset('storage/book-images/'.$products_alls->picture) }}" width="350" class="img-thumbnail" >
                                    </a> -->
                                    <!-- pic_test -->
                                    <!-- <a href="javascript:void(0)" class="" id="image_cover" >
                                        <img style="" src="{{ asset('img/books_test.jpg') }}" width="350" class="img-thumbnail" >
                                    </a> -->
                                    @if($product_gallery_photo)
                                        @foreach($product_gallery_photo as $photo)
                                            @if($photo->default == "true")
                                                <a href="javascript:void(0)" class="" id="image_cover" >
                                                    <img style="" src="{{ url('storage/book-images/'.$photo->photo) }}" width="350" class="img-responsive image img-thumbnail cropped2" >
                                                </a>
                                                @break
                                            @endif
                                            @if($loop->last)
                                                <a href="javascript:void(0)" class="" id="image_cover" >
                                                    <img style="" src="{{ url('storage/book-images/'.$product_gallery_photo[0]->photo) }}" width="350" class="img-responsive image img-thumbnail cropped2" >
                                                </a>
                                            @endif
                                            
                                        @endforeach
                                    @endif       
                                                                                    
                                @else
                                    <img style="background-color: HoneyDew;border: 2px solid DarkBlue;" src="{{ asset('img/no_pic.png') }}" class="img-thumbnail">                                
                                @endif
                                <div class="home mt-2">
                                    <div class="demo-gallery text-center">
                                        <ul id="lightgallery" class="list-unstyled row" style="@if($product_gallery_photo && count($product_gallery_photo) <= 1)display: none; @endif">
                                            @if($product_gallery_photo)
                                                @foreach($product_gallery_photo as $photo)
                                                                                                         
                                                        <li class="col-3 col-xs-4 col-sm-4 col-md-4 col-lg-3 vcenter" data-src="{{ url('storage/book-images/'.$photo->photo) }}" style="@if($loop->index == 0)display: none; @endif" >
                                                            <a href="" >
                                                                <img class="img-responsive image img-thumbnail p-1 cropped1"  src="{{ url('storage/book-images/thumbnail/'.$photo->photo) }}">
                                                            </a>
                                                        </li>
                                                    
                                                @endforeach
                                            @endif                            

                                        </ul>
                                    </div>	
                                </div>	
                                @if(isset($products_alls->stock_remain))                                            
                                    @if($products_alls->stock_remain <= 0)
                                        <p class="pt-2"><img style="background-color: ;border: 2px solid DarkBlue; " src="{{ asset('images/soldoutlbl.gif') }}"></p>
                                    @else
                                        <p class="pt-2"><h4><b>สินค้าคงเหลือ : <font color="#FF0000">{{ $products_alls->stock_remain }}</font> เล่ม</b></h4></p>
                                    @endif	
                                @endif	
                           

                            </div>
                            <div class="col-md-6 col-lg-6">

                                <div style="padding-top: 15px">
                                    @if(!empty($products_alls->top))
                                        <p><font color="DarkSlateGrey"><b>สินค้าขายดีอันดับที่ : </b>{{ $products_alls->top }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->book_name))
                                        <p><font color="DarkSlateGrey"><b>เรื่อง : </b>{{ $products_alls->book_name }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->book_type))
                                        <p><font color="DarkSlateGrey"><b>ประเภท : </b>{{ $products_alls->book_type }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->writer))
                                        <p><font color="DarkSlateGrey"><b>ซีรีส์ชุด : </b>{{ $products_alls->writer }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->price))
                                        <p><font color="DarkSlateGrey"><b>ราคา : </b><font color="#FF0000"><b>{{ number_format(round((float)$products_alls->price,2),2) }}</b></font> บาท</font></p>
                                    @endif
                                    @if(!empty($products_alls->alias))
                                        <p><font color="DarkSlateGrey"><b>นามปากกา : </b>{{ $products_alls->alias }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->publisher))
                                        <p><font color="DarkSlateGrey"><b>สำนักพิมพ์ : </b>{{ $products_alls->publisher }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->pim_year))
                                        <p><font color="DarkSlateGrey"><b>ปีที่พิมพ์ : </b>{{ $products_alls->pim_year }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->on_market))
                                        <p><font color="DarkSlateGrey"><b>วันที่วางแผง : </b>{{ $products_alls->on_market }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->pim_time))
                                        <p><font color="DarkSlateGrey"><b>พิมพ์ครั้งที่ : </b>{{ $products_alls->pim_time }}</font></p>
                                    @endif
                                    @if(!empty($product_type))
                                        @if($product_type !== "product_wait_fiction")
                                        
                                        
                                            @auth
                                            <div class="quantity">
                                                <div class="form-inline">
                                                    <a href="javascript:void(0)" class="qua_minus" data-id-book="{{ $products_alls->id_product }}" name="quantity" ><font color="MidnightBlue"><i class="far fa-minus-square fa-2x"></i></font></a>
                                                    <input readonly type="text" size="2" class="form-control qua_change" id="quantity_inp" data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity_inp" value="1" />                                                              
                                                    <a href="javascript:void(0)" class="qua_plus"  data-id-book="{{ $products_alls->id_product }}" name="quantity" ><font color="MidnightBlue"><i class="far fa-plus-square fa-2x"></i></font></a>
                                                    <!-- <input style="border: 5px solid red;" class="" type="submit" name="submit" value=" หยิบใส่ตะกร้า "> -->
                                                    <!-- <a href="javascript:void(0)" style="border: 3px solid Orange;" class="btn btn-warning ml-2 add_cart">หยิบใส่ตะกร้า</a> -->
                                                    <a href="javascript:void(0)" style="border: 3px solid Orange;" class="btn btn-warning ml-2 add_cart hvr-grow" data-id-product="{{ $products_alls->id_product }}" data-blame-product="{{ $products_alls->blame_product }}" data-buffet="{{ $products_alls->buffet }}" data-can-discount="{{ $products_alls->can_discount }}" ><i class="fas fa-cart-plus fa-1x"></i> หยิบใส่ตะกร้า</a>
                                                </div>                                                        
                                            </div>
                                            @else
                                            <a href="{{ route('login') }}" style="border: 3px solid Orange;" class="btn btn-warning ml-2 text-center hvr-grow"><i class="fas fa-user fa-1x"></i> {{ __('please Login') }}</a>                                                            
                                            @endauth
                                                                                            
                                        @endif
                                        @endif
                                        
                                    
                                </div> 

                            </div>

                        </div>

                        <div class="">
                        <!-- table-responsive -->
                        
                            <table width="100%"  align="center" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="320" align="center" valign="top">
                                           				
                                        </td>
                                        <td width="320" align="left" valign="top">
                                                                                                                                                      
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="left" style="border-top:1px dashed 000000; " > 
                                            @if(!empty($products_alls->blame_position)) 
                                                @if($product_type == "product_blame")
                                                    <br>
                                                    <p class="text-center"><b>ลักษณะจุดที่มีสภาพเก่า : </b>{{ $products_alls->blame_position }}</p>
                                                @endif
                                            @endif    
                                            
                                            @if(!empty($products_alls->blame_images))   
                                                @if($product_type == "product_blame")
                                                    <a href="/public/storage/blame-picture/{{ $products_alls->blame_images  }}" class="image-popup-no-margins text-center" >
                                                        <img style="background-color: HoneyDew;" src="{{ asset('storage/blame-picture/'.$products_alls->blame_images) }}" width="350" class="img-thumbnail " >   
                                                    </a>                                                 
                                                @endif   
                                            @endif               
                                            @if($product_type !== "product_wait_fiction")                         
                                            <article style="padding-top:15px" id="des"></article>
                                            @else
                                            <article style="padding-top:15px">{!! $products_alls->book_description !!}</article>     
                                            @endif
                                            
                                            @if(!empty($products_alls->can_discount))
                                                @if($products_alls->can_discount != "true")
                                                <center><p style="font-size: 12.7273px;padding-top:15px;"><span style="font-size: large;"><span style="font-size: xx-large;">*** ไม่ร่วมโปรโมชั่น ทุกโปรโมชั่น***</span></span></p></center>
                                                @endif	
                                            @endif	
                                            @if(!empty($product_type))
                                                @if($product_type == "product_blame")
                                                <center><h1 style="margin:10px;font-size:20px;color:#FF0000;">** สินค้าซื้อแล้วไม่รับเปลี่ยนหรือคืน นอกจากหน้าขาดหายจากการผลิต</h1></center>	                                               
                                                @endif 

                                                @if($product_type == "product_buffet")
                                                <center><h1 style="margin:10px;font-size:20px;color:#FF0000;">** สินค้าทุกเล่มสภาพตามกาลเวลา ซื้อแล้วไม่รับ เปลี่ยนหรือคืน นอกจากหน้าขาดหายจากการผลิต</h1></center>	                                                                                           
                                                @endif 
                                            @endif 
                                           			
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <hr>

                                <!-- <div class="align-self-center">
                                    <i class="fa fa-star"></i>
                                    <div class=""><font >CURRENT RATE:</font> <span class="">{{ $products_alls->rate  }}</span></div>
                                </div> -->
                                @if(!empty($products_alls->rate))
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <= $products_alls->rate)
                                            <i class="fa fa-star fa-2x colorGold"></i>
                                        @elseif($i > $products_alls->rate && $i == ceil($products_alls->rate))
                                            <i class="fas fa-star-half-alt colorGold fa-2x"></i>
                                        @else
                                            <i class="far fa-star colorGold fa-2x"></i>
                                        @endif
                                        
                                    @endfor
                                    
                                    Average Rate : {{$products_alls->rate}} 
                                    คนให้คะแนนทั้งหมด : {{$products_alls->rate_num}}
                                @endif
                            
                            <hr>
                            <form id="theForm" > <!--checkout-form -->
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                @if(!empty($products_alls->order_history_id) && empty($products_alls->product_rate_id) )
                                    <div class="rate-list align-self-center">
                                        <ul class="rate-list-ul">
                                        <li class="star-1 star"><i class="fa fa-star"></i></li>
                                        <li class="star-2 star"><i class="fa fa-star"></i></li>
                                        <li class="star-3 star"><i class="fa fa-star"></i></li>
                                        <li class="star-4 star"><i class="fa fa-star"></i></li>
                                        <li class="star-5 star"><i class="fa fa-star"></i></li>
                                        </ul>
                                        <div class="total align-self-center"><font class="align-self-center">CURRENT RATE:</font> <span class="totalResult">0</span></div>
                                    </div>
                                    
                                @endif
                                <div class="input-group">
                                    <input type="hidden" name="rate" id="rate" value="0">                               
                                </div> 
                                
                                
                                <div class="input-group p-2">
                                    <div   div class="col-md-12">
                                        <p class="align-self-center mr-2"><strong >Review Message : </strong></p>
                                        <textarea class="form-control p-2 rounded" id="review_message" name="review_message"  @if(empty($products_alls->order_history_id)) readonly @endif  ></textarea>
                                        <!-- <input type="hidden" name="review_message_temp" id="review_message_temp" value="">   -->
                                        
                                        <button type="submit" class="btn btn-success float-right p-2 m-1" @if(empty($products_alls->order_history_id)) disabled @endif ><i class="fas fa-save"></i> Save</button>                                
                                    </div>
                                </div>

                                <!-- <div class="note-editor note-frame panel panel-default">    
                                </div> -->

                                <!-- <input id="example3" value="Lorem ipsum dolor 😍 sit amet, consectetur 👻 adipiscing elit, 🖐 sed do eiusmod tempor ☔ incididunt ut labore et dolore magna aliqua 🐬."> -->


                                
                            </form>
                            <!-- <hr> -->

                            <!-- <div id="review">
                            </div> -->
                            <table id="example" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Review Message</th>
                                    </tr>
                                </thead>
                            </table>


                        </div>

                      



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
    <!-- jQuery -->

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

    <script type="text/javascript" src="{{ asset('plugins/emojionearea/emojionearea.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-textcomplete@1.8.5/dist/jquery.textcomplete.min.js" ></script>

    <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
    <script type="text/javascript" src="{{ asset('plugins/lightgallery/dist/js/lightgallery-all.min.js') }}"></script>
    




<script>


$(function(){
    jQuery.validator.setDefaults({
    ignore: ":hidden, [contenteditable='true']:not([name])"
    });

    $('#lightgallery').lightGallery({
        "share" : false , 
        "download" :false,
        "mode": 'lg-fade',
        "thumbnail" : true , 
        "animateThumb" :true ,
        width: '855px',
        height: '570px',
        addClass: 'fixed-size',
        
    });
    $("#image_cover").on("click", () => {
        $("#lightgallery a:first-child > img").trigger("click");
    });
    $("#review_message").emojioneArea();
    var table , Item_id = null ;
    var Item_id = "{{ $products_alls->id_product }}";
    // review(Item_id);
    // review(Item_id);
    datatableFilter(Item_id);
    
    if ($("#theForm").length > 0) {
        $("#theForm").validate({
            // ignore: [], 
            // ignore: ":hidden:not(#summernote),.note-editable.panel-body"
            rules: {
                review_message: {
                    required: true,
                },
                rate: {
                    required: true,
                },
            },
            messages: {
                review_message: {
                    required: "Please enter review message",
                },
                rate: {
                    required: "โปรดให้คะแนน 1-5",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            // error.addClass('bg_error');
            // element.closest('.input-group').append(error);
            // element.closest('form-control').append(error);
            error.addClass('bg-warning');
            element.closest('.input-group').append(error);
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
        Item_id = "{{ $products_alls->id_product }}";
        // var rate =  $('.totalResult').attr("data-val");
        // var rate = $('#rate').val(0);
        // if(!rate){
        //     rate = $('#rate').val();
            
        // }
        // alert(rate);
        
       
        if ($("#theForm").valid()) {
            // alert(rate);
            $.LoadingOverlay("show" , {
                image : "",
                fontawesome : "fas fa-star fa-spin" ,
                fontawesomeColor : "#00cbf9"
            });
            $.ajax({
                url: "{{ url('rate') }}"+'/' + Item_id,
                type: "POST",
                data:  new FormData(this),
                cache:false,
                processData: false,
                contentType: false,
                success: (response) => {
                    if ($.isEmptyObject(response.error)) {
                        // const { warning , success } = response ;
                        // console.log(response);
                        // console.log(response.warning);
                        $.LoadingOverlay("hide");
                        if(response.success){
                            Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'บันทึกสำเร็จแล้วค่ะ',
                            showConfirmButton: false,
                            timer: 1000,
                        }).then((result) =>{
                            // review(Item_id);
                            // datatableFilter(Item_id);
                            $(".rate-list").html('');
                            table.ajax.reload(null, false)
                            $("#review_message").data("emojioneArea").setText('');
                        });
                        }else {
                            Swal.fire({
                                icon: 'warning',
                                title: "<strong> "+response.warning+" </strong>",
                                showConfirmButton: true,
                            });
                        }
                        
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
                        }
                        
                    }
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                }
            });
        }
    }));


        $.ajax({
            url: "{{ url('/products/detail') }}/{{$products_alls->id_product}}",
            type: "GET",
            dataType: 'JSON',
            cache: false,
            success: (response) => {
                $('#des').html(response.des);
            }
        });
        $(document).ready(function() {
            var resultDisplay = $('.totalResult');
            //Select single star
            var star1 = $('.star-1').attr('data-star', 1);
            var star2 = $('.star-2').attr('data-star', 2);
            var star3 = $('.star-3').attr('data-star', 3);
            var star4 = $('.star-4').attr('data-star', 4);
            var star5 = $('.star-5').attr('data-star', 5);
            var allStars = [star1, star2, star3, star4, star5];
            function getValue (element, dataName) {
                element.on('click', function() {
                var maxRate = 5;
                var minRate = 1;
                var currentStarData = $(this).data(dataName);
                resultDisplay.removeClass("move");
                if (currentStarData >= minRate) {
                    $(this).prevAll('.star').addClass('redStar');
                    $(this).addClass("redStar");
                    resultDisplay.addClass("move");
                    } 
                if (currentStarData  <= maxRate) {
                    $(this).nextAll('.star').removeClass('redStar');
                    $(this).addClass("redStar");
                    resultDisplay.addClass("move");
                    }
                resultDisplay.text(currentStarData);
                resultDisplay.attr('data-val', currentStarData)
                // alert(currentStarData);
                $('#rate').val(currentStarData);
                });
            }
            for (var i = 0; i < allStars.length; i++) {
                getValue(allStars[i], "star");
            }
        });


    

    $('body').on('click', '.qua_minus', function() {
        //var id_cart = $(this).data('id-cart');
        var id_book = $(this).data('id-book');
        var qua = $('#quantity_inp').val();
        //alert(qua);
        //var qua = $(this).data('value');
        updateCart('qua_minus',id_book ,qua );
        //alert(id_book);
        
        //alert("123");
    });
    $('body').on('click', '.qua_plus', function() {

        var id_book = $(this).data('id-book');
        var qua = $('#quantity_inp').val();
        //alert(id_book);
        //var qua = $(this).data('value');
        updateCart('qua_plus',id_book,qua);
        
        //alert("123");
    });
    $('body').on('click', '.add_cart', function() {
        var Item_id = $(this).data('id-product');
        var blame_product = $(this).data('blame-product');
        var buffet = $(this).data('buffet');
        var can_discount = $(this).data('can-discount');
        
        var user_id = "{{ $user ? $user->id : '' }}" ;
        var username = "{{ $user ? $user->username : '' }}";
        var qua = $('#quantity_inp').val();
        
        // var user_id = "{{ !empty($user->id) ? $user->id : null  }}" ;
        // var username = "{{ !empty($user->username) ? $user->username : null }}";
        $.ajax({
            type: "POST",
            url: "{{ url('cart') }}",
            data:{_token: "{{ csrf_token() }}", product_id:Item_id , user_id: user_id ,
                username: username , blame_product: blame_product , buffet: buffet, can_discount:can_discount, qua:qua },
            success: (response) => {    
                if ($.isEmptyObject(response.error)) {
                        console.log(response)
                        console.log(response.success);
                        Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้วค่ะ',
                        showConfirmButton: false,
                        timer: 1000,
                        }).then((result) => {
                            mini_cart('show','','book');  
                            var qua = $('#quantity_inp').val(1);
                        });
                } else {
                    console.log(response)
                    console.log(response.error);
                    Swal.fire({
                        icon: 'warning',
                        title: "เตือน",
                        text: "" + response.error,
                    });
                }
            },
            error: (response) => {
                console.log('Error:', response);
                Swal.fire({
                    icon: 'error',
                    title: "<strong>Error edit record.</strong>",
                    html: "<strong>Error Code: </strong>" + response.status +
                        "<p><strong>Message: </strong>" + JSON.stringify(response
                            .responseJSON.message) + "</p>",
                });
            }
        });
    });

    function updateCart(fn='',id_book='', qua='') {
        $.ajax({
            url: "{{ url('cart') }}",
            type: "POST",
            dataType: 'JSON',
            cache: false,
            //add or demis 
            data: {fn:fn ,id_book:id_book , qua: qua},
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $('#quantity_inp').val(response.qua);
   
                    //mini_cart();  
                } else {
                    console.log(response.error);
                    Swal.fire({
                        icon: 'warning',
                        title: "<strong> เตือน </strong>",
                        text: response.error,
                    });
                }
            }
        });
    }
    // function review(book_id=''){ 
    //     $.ajax({
    //         url: "{{ url('review') }}",
    //         type: "GET",
    //         data:{book_id:book_id },
    //         dataType: 'JSON',
    //         cache: false,
    //         success: (response) => {
    //             if ($.isEmptyObject(response.error)) {
    //                 console.log(response);
    //                 let html = `<table class="table table-dark rounded-lg">
    //                                 <tbody>`;
    //                 if(response.val){
    //                     for (const e of response.val) {
    //                         const {name , email , avatar , message ,rate , createdDate} = e ;
    //                         html += `<tr>
    //                                     <th scope="row" colspan="2">`;
    //                                     var i= 1 ;
    //                                     while(i <= 5 ){          
    //                                         if(i <= rate){
    //                         html += ' <i class="fas fa-star colorGold"></i> ';
    //                                         }
    //                                         if(i > rate){                                                
    //                         html += ' <i class="fas fa-star"> ';
    //                                         }
    //                                         i++ ;
    //                                     }
    //                         html +=     `                                                  
    //                                     </th>                                                
    //                                 </tr>` ;
    //                         html += `<tr>
    //                                     <th scope="row" colspan="2">                            
    //                                         <font>ข้อความ : </font>
    //                                         <font>${message}</font>                                                    
    //                                     </th>                                                
    //                                 </tr>
    //                                 <tr>
    //                                     <td scope="row" class="text-right">`;
    //                                     if(avatar){
    //                         html +=         `   <img src="{{url('storage/profile-uploads/${avatar}')}}" width="30px" class="rounded" style="background-color:white" > `;                            
    //                                     }else{
    //                         html +=         `   <img src="{{url('img/no_pic.png')}}" width="30px" class="rounded" style="background-color:white" > `;
    //                                     }
    //                         html +=                `  <font>${name}</font> | 
    //                                         <small>${createdDate}</small> 
    //                                     </td>
    //                                 </tr>
    //                             `;
    //                     }
    //                 }else {
    //                     html += `<i class="fas fa-star"></i> <h3>ไม่มีการรีวิว</h3> <i class="fas fa-star"></i>`
    //                 }
    //                 html += `   </tbody>
    //                         </table>`
    //                 $("#review").html(html);
                    
    //                 // console.log(response.success);
    //                 // $('.cart-icon').html(response.html);

    //             } else {
    //                 console.log(response.error);
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: "<strong> ERROR </strong>",
    //                     text: "Error: " + response.error,
    //                 });
    //             }
    //         }
    //     });
        
    // }

    function datatableFilter(book_id ='') {
        table = $("#example").DataTable({
            lengthChange: false,
            iDisplayLength: 3,
            bFilter: false,
            // destroy: true,
            searching: false,
            // dom: 'Bfrtip',
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
                "processing": false ,
                //processing: "กำลังประมวลผล...",
                //processing: '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i>',
                // processing: '<i class=" fa fa-spinner fa-spin fa-3x fa-fw " style="font-size:60px;color:red;"></i>',
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ต่อไป",
                    previous: "ย้อนกลับ",
                },
            },
            processing: true,
            // serverSide: true,
            ajax: {
                url: "{{ url('review') }}",
                type: 'GET',
                data : {book_id:book_id}
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [
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
   
</script>
@endsection
