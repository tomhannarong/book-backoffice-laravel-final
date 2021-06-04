@extends('../layouts.front')

@section('menu_products' , 'active')

@section('css')

<style>
.pagination {
    justify-content: center;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 10px;
    padding-left: 10px;
}
.linear-5 {
    background: rgb(102,25,185);
    background: radial-gradient(circle, rgba(102,25,185,1) 0%, rgba(25,182,223,1) 50%, rgba(42,124,222,1) 100%);
    padding-top: 20px ;
    padding-bottom: 20px;
    border: 2px solid Purple;
}
.filter-control {
    text-align: center;
    margin-bottom: 10px;
    padding-top: 10px;
}
/* header */
.head_text {
    border-bottom: 1px solid #8e918f;
    padding-bottom: 5px;
    margin-bottom: 20px;
    position: relative;
}
.option_head_text {
    align-items: center;
    position: absolute;
    right: 0;
    bottom: 7px;
    /* font-family: Helvetica,Thonburi,Tahoma,sans-serif; */
    font-size: 20px;
    color: red;
}
.option_head_text a {
    color: black;
}
.card { 
    border: 0;
}
.card-header {
    padding: 0;
}
.card-body {
    padding: 0;
}
.card-footer {
    padding: 0;
}
.btn {
    padding: 0;
}
/* Sale Styling */
.price-sale .price-amount {
  color: gray;
  text-decoration: line-through;
}
.price-sale .price-sale-amount {
  color: red;
}
.price del {
  color: rgba(128, 128, 128, 0.5);
  text-decoration: none;
  position: relative;
  font-size: 18px;
  font-weight: 100;
}
.price del:before {
  content: " ";
  display: block;
  width: 100%;
  border-top: 2px solid rgba(255, 0, 0, 0.9);
  /* height: 10px; */
  position: absolute;
  bottom: 13px;
  left: 0;
  transform: rotate(-25deg);
}
.price ins {
  font-size: 80px;
  font-weight: 100;
  text-decoration: none;
  padding: 0 0 0 0.5em;
}
.parent {
  overflow: hidden; /* required */
  /* width: 50%; for demo only */
  /* height: 250px some non-zero number; */
  /* margin: 25px auto; for demo only */
  border:1px solid grey;/* for demo only*/
  position: relative; /* required  for demo*/
}

.ribbon {
  margin: 0;
  padding: 0;
  background: DarkRed;
  color:white;
  padding:1em 0;
  position: absolute;
  top:0;
  right:0;
  transform: translateX(30%) translateY(0%) rotate(45deg);
  transform-origin: top left;
}
.ribbon:before,
.ribbon:after {
  content: '';
  position: absolute;
  top:0;
  margin: 0 -1px; /* tweak */
  width: 100%;
  height: 100%;
  background: DarkRed;
}
.ribbon:before {
  right:100%;
}
.disabled{
    position: relative;
}
.disabled:after{
    content: "";
    position: absolute;
    width: 100%;
    height: inherit;
    background-color: rgba(0,0,0,0.1);
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}
a:hover{
    /* background-color: #7CFC00 !important; */
    text-shadow: 0 0 0.9em #F9629F;
}
</style>
@endsection

@section('content')

    <!-- Women Banner Section Begin -->
    <section class="women-banner spad py-4">
        <div class="container" >
            <div class="head_text">
                <div class="head_text_string ">
                        <h2>{{ $head_text ?? '' }} [ ทั้งหมด ]</h2>
                          
                            <div class="mt-4">
                                <a href="{{ url('products') }}" class="product-menu hvr-grow mr-4">
                                    <font size="3" color="black"><b>นิยายมาใหม่</b></font>
                                </a> 
                                <a href="{{ url('products/bestSeller') }}" class="product-menu hvr-grow ml-4 mr-4">
                                    <font size="3" color="black"><b>นิยายขายดี</b></font>
                                </a> 
                                <a href="{{ url('products/blame') }}" class="product-menu hvr-grow ml-4 mr-4">
                                    <font size="3" color="black"><b>สินค้ามือหนึ่งสภาพเก่า</b></font>
                                </a> 
                                <a href="{{ url('products/serie') }}" class="product-menu hvr-grow ml-4 mr-4">
                                    <font size="3" color="black"><b>ซีรีส์ชุด</b></font>
                                </a> 
                                <a href="{{ url('products/buffet') }}" class="product-menu hvr-grow ml-4 mr-4">
                                    <font size="3" color="black"><b>บุฟเฟ่ต์</b></font>
                                </a>
                                <a href="{{ url('products/waitFiction') }}" class="product-menu hvr-grow ml-4 mr-4">
                                    <font size="3" color="black"><b>นิยายรอตีพิมพ์</b></font>
                                </a>
                            </div>
                                <!-- <a href="product_lip.php" class="product-menu">GL ลิปสติก</a> -->
                            
                        
                    
                </div>

              
            </div>

            <div class="row display-flex">
                @foreach ($products_alls as $products_all)
                    <div class="product-item    col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 center text-center">
                        <div class="card" >
                            <!-- <img class="" src=".../100px180/?text=Image cap" alt="Card image cap"> -->
                            <div class="card-header">
                                
                                <div class="pi-pic" 
                                    data-aos="fade-up"
                                    data-aos-anchor-placement="top-bottom">
                                    @if($products_all->picture)   
                                        <!-- <a href="/public/storage/book-images/{{ $products_all->picture  }}" class="image-popup-no-margins hvr-grow" >
                                            <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('storage/book-images/thumbnail/'.$products_all->picture) }}" >
                                        </a> -->
                                        <!-- pic_test -->
                                        <a href="{{ url('img/books_test.jpg') }}" class="ajax-popup-link  hvr-grow" >
                                                <img class="cropped1 parent" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('img/books_test.jpg') }}" >
                                        </a>
                                    @else
                                        <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan" src="{{ asset('img/no_pic.png') }}" >                                
                                    @endif
                                    @if($product_type !== "product_wait_fiction")
                                        @if($products_all->stock_remain <= 0)
                                            <h5 class="ribbon">สินค้าหมด</h5>
                                        @endif
                                    @endif
                                    @if($product_type === "product_best_seller")
                                        <div class="sale hvr-grow">Top : {{ $products_all->top }}</div>
                                    @endif
                                    @auth
                                    <div class="icon">
                                        @if($product_type !== "product_wait_fiction")    
                                            @if(empty($products_all->favor_book_id))
                                            <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-id-favor="{{ $products_all->favor_book_id }}" data-type="book" class="add_mini_heart">
                                            <i style="color: HotPink;-webkit-text-stroke-width: 1px;
                                -webkit-text-stroke-color: HotPink;" class="far fa-heart"></i></a>                                    
                                            @else
                                            <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-id-favor="{{ $products_all->favor_book_id }}" data-type="book" class="add_mini_heart">
                                            <i style="-webkit-text-fill-color: LightPink;
                                -webkit-text-stroke-width: 3px;
                                -webkit-text-stroke-color: HotPink; " class="fas fa-heart"></i></a>
                                            @endif
                                        @endif
                                    </div>
                                    @endauth
                                    <ul>
                                        @auth
                                        @if($product_type !== "product_wait_fiction")
                                            @if($products_all->stock_remain > 0)
                                            <li class="w-icon active hvr-grow">
                                                <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-blame-product="{{ $products_all->blame_product }}" 	 data-buffet="{{ $products_all->buffet }}" data-can-discount="{{ $products_all->can_discount }}" class="add_cart"><i class="fas fa-cart-plus fa-1x"></i></a>
                                            </li>
                                            @endif
                                        @endif
                                        @else
                                        <li class="w-icon active hvr-grow">  
                                            <a href="{{ route('login') }}" class=""><i class="fas fa-cart-plus fa-1x"></i></a>
                                        </li>
                                        @endauth
                                        @if($product_type !== "product_wait_fiction" && $product_type !== "product_blame")
                                        <li class="quick-view hvr-grow"><a href="{{ url('products/detail').'/'.$products_all->id_product }}">+ View</a></li>
                                        @elseif($product_type === "product_wait_fiction")
                                        <li class="quick-view hvr-grow"><a href="{{ url('products/waitFiction/detail').'/'.$products_all->id_product }}">+ View</a></li>
                                        @elseif($product_type === "product_blame")
                                        <li class="quick-view hvr-grow"><a href="{{ url('products/blame/detail').'/'.$products_all->id_product }}">+ View</a></li>                                    
                                        @endif
                                        @if($products_all->picture) 
                                                <!-- <li class="w-icon hvr-grow"><a href="/public/storage/book-images/{{ $products_all->picture  }}" target="_blank" title="ดูรูปปก"><i class="fas fa-search-plus"></i></a></li> -->
                                                <!-- pic_test -->
                                                <li class="w-icon hvr-grow"><a href="{{ url('img/books_test.jpg') }}" target="_blank" title="ดูรูปปก"><i class="fas fa-search-plus"></i></a></li>

                                                
                                        @endif
                                    
                                    </ul>
                                </div>

                            </div>
                            <div class="card-body" style="background-color:White;border: 1px solid WhiteSmoke;">

                                <div class="pi-text mt-1 text-left" >
                                    @if($product_type !== "product_wait_fiction" && $product_type !== "product_blame")
                                        @if($products_all->book_name)
                                            <a href="{{ url('products/detail').'/'.$products_all->id_product }}"><font class="pl-2" size="4"  color="#ff4bc6">{{ $products_all->book_name }}</font></a>
                                        @endif
                                    @elseif($product_type === "product_wait_fiction")
                                        @if($products_all->book_name)
                                            <a href="{{ url('products/waitFiction/detail').'/'.$products_all->id_product }}"><font class="pl-2" size="4"  color="#ff4bc6">{{ $products_all->book_name }}</font></a>
                                        @endif
                                    @elseif($product_type === "product_blame")
                                        @if($products_all->book_name)
                                            <a href="{{ url('products/blame/detail').'/'.$products_all->id_product }}"><font class="pl-2" size="4"  color="#ff4bc6">{{ $products_all->book_name }}</font></a>
                                        @endif
                                        
                                    @endif

                                    @if($products_all->alias)
                                    <!-- <font color="#7c4eff"><b>นามปากกา : </b>{{ $products_all->alias }}</font><br> -->
                                    @else
                                    <!-- <br> -->
                                    @endif
                                    
                                    @if($products_all->writer)
                                       
                                        <a href="{{ url('products/serie/'.$products_all->writer) }}" >
                                            <font class="pl-2" size="3" color="#824300">
                                                <!-- <b>ซีรีส์ชุด : </b> -->
                                                {{ $products_all->writer }}<br>
                                            </font>
                                        </a>
                                        
                                    @else
                                    <font class="pl-2" size="3" color="#824300">
                                        <!-- <b>ซีรีส์ชุด : </b> -->
                                        -<br>
                                    </font>
                                    @endif
                                    @if($products_all->price)
                                    <!-- <b>ราคา : </b>
                                    <font color="#FF0000">{{ $products_all->price }}</font> บาท<br> -->
                                    @else
                                    <br>
                                    @endif
                                    @if(!empty($products_all->stock_remain))
                                        @if($products_all->stock_remain <= 0)
                                        <!-- <img style="background-color: rgba(81, 120, 255, .1);border: 2px solid DarkBlue; " src="{{ asset('images/soldoutlbl.gif') }}" width="100%"> -->
                                        @else
                                        <br>
                                        @endif 
                                    @endif
                                    
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                
                                <div class="pi-text " >
                                    
                                    <div class="wrap_btn_book_list">
                                        <table class="table_btn_book_list" style="width:100%;">
                                        <tbody>
                                            <tr style="width:100%;">
                                                @if(!empty($products_all->attachment) || !empty($products_all->blog_url) || !empty($products_all->youtube_url))  
                                                
                                                <td >
                                                <div>
                                                    @if($products_all->attachment)  
                                                    &nbsp;<a style="display: inline;" href="file/{{ $products_all->attachment }}" target=_blank  title="อ่านเรื่องย่อ"><img src="{{ asset('images/pdf_icon.png') }}" border=0 height=20></a>
                                                    @endif
                                                    
                                                    @if($products_all->blog_url)
                                                        &nbsp;<a style="display: inline;" href="{{ $products_all->blog_url }}" target=_blank  title="ดู Review Blog"><img src="{{ asset('images/blog_icon.png') }}" border=0 height=20></a>
                                                    @endif
                    
                                                    @if($products_all->youtube_url)
                                                        &nbsp;<a style="display: inline;" href="{{ $products_all->youtube_url }}" target=_blank  title="ดู Review Youtube"><img src="{{ asset('images/youtube_icon.png') }}" border=0 height=20></a>
                                                    @endif
                                                </div>
                                                </td>
                                                @endif

                                                @if($product_type !== "product_wait_fiction")   
                                                <td valign="middle"  class="" width="60%" height="100%"  align="center" >
                                                     @if($products_all->price)
                                                    <!-- <b>ราคา : </b>
                                                    -->
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-blame-product="{{ $products_all->blame_product }}" data-buffet="{{ $products_all->buffet }}" data-can-discount="{{ $products_all->can_discount }}" class="btn btn-outline-success add_cart {{ $products_all->stock_remain <= 0 ? 'disabled' : '' }} "  > 
                                                        <b><font size="5" style="text-decoration: underline;" color="red" class="price-sale ">{{number_format($products_all->price)}}</font></b><br>
                                                        <font class="price " >
                                                            <del>
                                                            <span class="amount">{{ $products_all->price }}</span>
                                                            </del>
                                                        </font>
                                                        <b><font color="#006400" class="">   บาท</font></b>
                                                    </a>
                                                    
                                                    @else
                                                    <a href="javascript:void(0)"  class="btn btn-outline-success "  ><b><font size="5" color="red">-</font> บาท</b></a>
                                                    @endif
                                                </td>
                                                @else
                                                <td valign="middle"  class="" width="60%" height="100%"  align="center" >
                                                    @if($products_all->price)
                                                   
                                                   <a href="javascript:void(0)" class="btn btn-outline-success add_cart disabled"  > 
                                                       <b><font size="5" style="text-decoration: underline;" color="red" class="price-sale ">{{number_format($products_all->price)}}</font></b><br>
                                                       <font class="price " >
                                                           <del>
                                                           <span class="amount">{{ $products_all->price }}</span>
                                                           </del>
                                                       </font>
                                                       <b><font color="#006400" class="">   บาท</font></b>
                                                   </a>
                                                   
                                                   @else
                                                   <a href="javascript:void(0)"  class="btn btn-outline-success "  ><b><font size="5" color="red">-</font> บาท</b></a>
                                                   @endif
                                               </td>
                                                @endif

                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- <div class="card">
                            <div class="card-header">Header</div>
                            <div class="card-body">
                                @if($products_all->book_name)
                                    <a href="{{ url('products/detail').'/'.$products_all->id_product }}"><font class="pl-2" size="4"  color="#ff4bc6">{{ $products_all->book_name }}</font></a>
                                @endif
                            </div>
                            <div class="card-footer">Footer</div>
                        </div> -->
                            
                    </div>

                @endforeach 
            </div>



        </div>
    </section>


{{--     
    <section class="women-banner spad py-4">
        <div class="container" >

                    <div class="filter-control ">
                        <div style="width:100%;overflow:hidden;"><center><img src="{{ asset('images/line.png') }}" border="0"></center></div>
                                
                        <ul class="linear-5">
                            <li ><font @if($product_type === "product_blame" || $product_type === "product_serie" || $product_type === "product_buffet") color="White" @else color="Gold" @endif style="text-shadow: 0 0 0.2em #8F7">
                                <b>{{ $head_text ?? '' }}</b>
                            </font></li>
                            <li class="active hvr-grow" ><font color="Chartreuse" style="text-shadow: 0 0 0.2em #8F7">ดูทั้งหมด</font></li>
                            @if($product_type !== "product_wait_fiction" && $product_type !== "product_best_seller")  
                            <li><a href="{{ url('products') }}" class=" product-menu hvr-grow"><font @if($product_type === 'product_normal') color="Gold" @else color="White" @endif style="text-shadow: 0 0 0.2em #8F7">
                                <b>สินค้าปกติ</b>
                            </font></a> <i class="fas fa-grip-lines-vertical" style="color:black"></i> 
                                <a href="{{ url('products/blame') }}" class="product-menu hvr-grow"><font @if($product_type === 'product_blame') color="Gold" @else color="White" @endif style="text-shadow: 0 0 0.2em #8F7">
                                    <b>สินค้ามือหนึ่งสภาพเก่า</b>
                                </font></a> <i class="fas fa-grip-lines-vertical" style="color:black"></i> 
                                <a href="{{ url('products/serie') }}" class="product-menu hvr-grow"><font @if($product_type === 'product_serie') color="Gold" @else color="White" @endif style="text-shadow: 0 0 0.2em #8F7">
                                    <b>ซีรีส์ชุด</b>
                                </font></a> <i class="fas fa-grip-lines-vertical" style="color:black"></i> 
                                <a href="{{ url('products/buffet') }}" class="product-menu hvr-grow"><font @if($product_type === 'product_buffet') color="Gold" @else color="White" @endif style="text-shadow: 0 0 0.2em #8F7">
                                    <b>บุฟเฟ่ต์</b>
                                </font></a>
                                <!-- <a href="product_lip.php" class="product-menu">GL ลิปสติก</a> -->
                            </li>
                            @endif
                        </ul>
                        <div style="width:100%;overflow:hidden;"><center><img src="{{ asset('images/line.png') }}" border="0"></center></div>
                        
                    </div>

                    <div class="head_text"><h2 class="head_text_string">นิยายมาใหม่</h2>
                        <div class="option_head_text">
                            <a href="{{ url('products') }}" style="float: right;">ดูทั้งหมด</a>
                        </div>
                    </div>

                    <div class="row pt-2" style="background-color:rgba(238, 81, 255, .1); border: 2px solid Purple;">
                        @foreach ($products_alls as $products_all)
                            
                        <div class="product-item col-xl-2 col-lg-3 col-md-4 col-sm-6 col-xs-12"  >
                            <div class="pi-pic" >
                                @if($products_all->picture)   
                                    <!-- <a href="/public/storage/book-images/{{ $products_all->picture  }}" class="image-popup-no-margins hvr-grow" >
                                        <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('storage/book-images/thumbnail/'.$products_all->picture) }}" >
                                    </a> -->
                                    <!-- pic_test -->
                                    <a href="{{ url('img/books_test.jpg') }}" class="ajax-popup-link  hvr-grow" >
                                            <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan;" src="{{ asset('img/books_test.jpg') }}" >
                                    </a>
                                @else
                                    <img class="cropped1" style="background-color: HoneyDew;border: 2px solid DarkCyan" src="{{ asset('img/no_pic.png') }}" >                                
                                @endif
                                @if($product_type === "product_best_seller")
                                    <div class="sale hvr-grow">Top : {{ $products_all->top }}</div>
                                @endif
                                @auth
                                <div class="icon">   
                                    @if($product_type !== "product_wait_fiction")                                 
                                    <!-- <i style="color: HotPink;" class="far fa-heart"></i> -->
                                        @if(empty($products_all->favor_book_id))
                                        <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-id-favor="{{ $products_all->favor_book_id }}" data-type="book"  class="add_mini_heart">
                                        <i style="color: HotPink;-webkit-text-stroke-width: 1px;
                                                    -webkit-text-stroke-color: HotPink;" class="far fa-heart"></i></a>                                    
                                        @else
                                        <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-id-favor="{{ $products_all->favor_book_id }}" data-type="book" class="add_mini_heart">
                                        <i style="-webkit-text-fill-color: LightPink;
                                                    -webkit-text-stroke-width: 3px;
                                                    -webkit-text-stroke-color: HotPink; " class="fas fa-heart"></i></a>
                                        @endif
                                    @endif
                                </div>
                                @endauth
                                <ul>@auth
                                    @if($product_type !== "product_wait_fiction")
                                        @if($products_all->stock > 0)
                                        <li class="w-icon active hvr-grow">
                                            <a href="javascript:void(0)" data-id-product="{{ $products_all->id_product }}" data-blame-product="{{ $products_all->blame_product }}" 	 data-buffet="{{ $products_all->buffet }}" data-can-discount="{{ $products_all->can_discount }}" class="add_cart"><i class="fas fa-cart-plus fa-1x"></i></a>
                                        </li>
                                        @endif
                                    @endif
                                    @else
                                    <li class="w-icon active hvr-grow">  
                                        <a href="{{ route('login') }}" class=""><i class="fas fa-cart-plus fa-1x"></i></a>
                                    </li>
                                    @endauth
                                    @if($product_type !== "product_wait_fiction" && $product_type !== "product_blame")
                                    <li class="quick-view hvr-grow"><a href="{{ url('products/detail').'/'.$products_all->id_product }}">+ View</a></li>
                                    @elseif($product_type === "product_wait_fiction")
                                    <li class="quick-view hvr-grow"><a href="{{ url('products/waitFiction/detail').'/'.$products_all->id_product }}">+ View</a></li>
                                    @elseif($product_type === "product_blame")
                                    <li class="quick-view hvr-grow"><a href="{{ url('products/blame/detail').'/'.$products_all->id_product }}">+ View</a></li>                                    
                                    @endif
                                    @if($products_all->picture) 
                                            <!-- <li class="w-icon hvr-grow"><a href="/public/storage/book-images/{{ $products_all->picture  }}" target="_blank" title="ดูรูปปก"><i class="fas fa-search-plus"></i></a></li> -->
                                            <!-- pic_test -->
                                            <li class="w-icon hvr-grow"><a href="{{ url('img/books_test.jpg') }}" target="_blank" title="ดูรูปปก"><i class="fas fa-search-plus"></i></a></li>

                                            
                                    @endif
                                </ul>
                            </div>
                            <div class="pi-text mt-1" style="background-color:White;border: 2px solid Purple;">
                                @if($product_type !== "product_wait_fiction")
                                <div>
                                    @if($products_all->attachment)  
                                    &nbsp;<a style="display: inline;" href="file/{{ $products_all->attachment }}" target=_blank  title="อ่านเรื่องย่อ"><img src="{{ asset('images/pdf_icon.png') }}" border=0 height=16></a>
                                    @endif
                                    
                                    @if($products_all->blog_url)
                                        &nbsp;<a style="display: inline;" href="{{ $products_all->blog_url }}" target=_blank  title="ดู Review Blog"><img src="{{ asset('images/blog_icon.png') }}" border=0 height=16></a>
                                    @endif
    
                                    @if($products_all->youtube_url)
                                        &nbsp;<a style="display: inline;" href="{{ $products_all->youtube_url }}" target=_blank  title="ดู Review Youtube"><img src="{{ asset('images/youtube_icon.png') }}" border=0 height=16></a>
                                    @endif
                                </div>
                                @endif
                                @if($products_all->book_name)
                                    <font size=2 color="#ff4bc6"><b>เรื่อง : </b>{{ $products_all->book_name }}</font><br>
                                @else
                                    <br>
                                @endif
                                @if($products_all->alias)
                                    <font color="#7c4eff"><b>นามปากกา : </b>{{ $products_all->alias }}</font><br>
                                @else
                                    <br>
                                @endif
                                @if($products_all->writer)
                                    <font color="#824300">
                                        <b>ซีรีส์ชุด : </b>{{ $products_all->writer }}<br>
                                    </font>
                                @else
                                    <br>
                                @endif
                                @if($products_all->price)
                                    <b>ราคา : </b><font color="#FF0000">{{ $products_all->price }}</font> บาท<br>
                                @else
                                    <br>
                                @endif
                                @if($product_type !== "product_wait_fiction")
                                    @if($products_all->stock <= 0)
                                        <img style="background-color: coral; " src="{{ asset('images/soldoutlbl.gif') }}" width="100%">
                                    @else
                                        <br>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @endforeach 
                        
                    </div>
                    <br>
                    <center><img src="{{ asset('images/line.png') }}" border="0"></center>
                    <center><font size="4" color="black" style="text-shadow: 0 0 0.3em black">ทั้งหมด <span class="style4"><b>{{ $products_alls->total() }}</b></span> รายการ <b></font></center><br>
                        {{ $products_alls->links() }}

        </div>
    </section> --}}
    <!-- Women Banner Section End -->

    
@endsection

@section('js')
<script>
    $(function(){

        
        
        $('body').on('click', '.add_cart', function() {
            Item_id = $(this).data('id-product');
            var blame_product = $(this).data('blame-product');
            var buffet = $(this).data('buffet');
            var can_discount = $(this).data('can-discount');
            var type = $(this).data('type') ?? '' ;
            
            var user_id = "{{ $user ? $user->id : '' }}" ;
            var username = "{{ $user ? $user->username : '' }}";
            // var user_id = "{{ !empty($user->id) ? $user->id : null  }}" ;
            // var username = "{{ !empty($user->username) ? $user->username : null }}";
            
            //alert(Item_id);
            $.ajax({
                type: "POST",
                url: "{{ url('cart') }}",
                data:{_token: "{{ csrf_token() }}", product_id:Item_id , user_id: user_id ,
                 username: username , blame_product: blame_product , buffet: buffet, can_discount:can_discount ,type:type },
                success: (response) => {    
                    if ($.isEmptyObject(response.error)) {
                            //console.log(response)
                            console.log(response.success);
                            Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้วค่ะ',
                            showConfirmButton: false,
                            timer: 1000,
                            }).then((result) => {
                                mini_cart('show','','book');  
                            });
                    } else {
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

        $('body').on('click', '.add_mini_heart', function() {
            Item_id = $(this).data('id-product');
            var favor = $(this).data('id-favor') ?? '' ;
            var type = $(this).data('type') ?? '' ;
            if(favor){
                var status = 'delete_mini_heart';
            }else{
                var status = 'add_mini_heart';
            }
            // alert(status)
    
            mini_heart(status,Item_id,type).then(
                Swal.fire({
                    icon: 'success',
                    title: 'เพิ่มหนังสือโปรดของคุณเรียบร้อยแล้วค่ะ',
                    showConfirmButton: false,
                    timer: 2000,                          
                }).then(
                    location.reload()
                )
            )
            
            

        });
    });
</script>
@endsection