@extends('../layouts.front')

@section('menu_home' , 'active')

@section('css')
<!-- Link Swiper's CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<link rel="stylesheet" type="text/css" href="{{ asset('css/front-end/index.style.css') }}" />
<style>



</style>

    
@endsection

@section('content')

    <section class="py-4">
        <!-- Swiper -->
        <div class="swiper-container swiper-main">
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach ($slides as $slide)
                <div class="swiper-slide" data-title="Slide Three" data-subtitle="This is a slide three" data-link="https://www.facebook.com/" data-img="{{ asset('storage/slide-images/'.$slide->slide_images) }}"></div>
                @endforeach
            </div>
            <!-- Slide captions -->
            <div class="slide-captions"></div>
            <!-- Slide buttom -->
            <div class="slide-captions-buttom"></div>
            <!-- Slide image -->
            <div class="slide-captions-image"></div>
            
            
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-main"></div>
        </div>
    </section>
    <section class="py-1">
        <!-- Slider main container -->
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @foreach ($slides as $slide)
                <div class="swiper-slide"><img width="100%" class="cropped" src="{{ asset('storage/slide-images/'.$slide->slide_images) }}" ></div>
                @endforeach
                
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination "></div>
            
            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>




<section class="bg-light" style="background-image: url({{url('images/bg/bg_top_10_2.png')}}) ;background-size: 100% 100%;">
        <div class="container " >
            <div class="head_text" style="padding-top:20px;margin-bottom: 20px;"><h2 class="head_text_string">10 อันดับนิยายขายดี </h2>
                <div class="option_head_text">
                    <a href="{{ url('products/bestSeller') }}" style="float: right;">ดูทั้งหมด</a>
                </div>
            </div>
            <div class="main-content" >
                <div class="owl-carousel owl-theme">
                    

                    @foreach ($best_sellers as $best_seller)
                    <div class=" shape" data-name="{{ $best_seller->getProduct->book_name ?? '' }}" data-writer ="{{ $best_seller->getProduct->writer ?? '' }}"
                        data-price="{{ $best_seller->getProduct->price ?? '' }}" data-product-price="{{ $best_seller->getProduct->product_price ?? '' }}"  data-id-product="{{ $best_seller->book_id ?? '' }}" data-blame-product="{{ $best_seller->getProduct->blame_product ?? '' }}" 
                        data-buffet="{{ $best_seller->getProduct->buffet ?? '' }}" data-can-discount="{{ $best_seller->getProduct->can_discount ?? '' }}">
                        @if(!empty($best_seller->getProduct->picture)) 
                        <div class="item book" style="">
                                    <!-- {{ asset('img/books_test.jpg') }} -->
                                <img class="frame parent"  src="{{ asset('storage/book-images/thumbnail/'.$best_seller->getProduct->picture) }}" >
                                
                                @if($best_seller->getProduct->stock_remain > 0)
                                    <div class="ml-1" >
                                        <h5 class="tab_book" style="background-color:green;border: 1px solid DarkGreen;">ขายดี {{ $best_seller->top }}</h5>
                                    </div>
   
                                @else
                                    
                                    <div class="ml-1" >
                                        <h5 class="tab_book" style="background-color:red;border: 1px solid DarkRed;">หมด</h5>
                                    </div>
                                @endif
                                @auth
                                    <div class="icon_heart">
                                        @if(empty($best_seller->getFavorBook))
                                        <a href="javascript:void(0)" data-id-product="{{ $best_seller->book_id }}" data-id-favor="{{ $best_seller->getFavorBook->id ?? '' }}" data-type="book"  class="add_mini_heart">
                                        <i style="color: black;background-color: white;" class="far fa-heart fa-heart-book"></i></a>                                    
                                        @else
                                        <a href="javascript:void(0)" data-id-product="{{ $best_seller->book_id }}" data-id-favor="{{ $best_seller->getFavorBook->id ?? '' }}" data-type="book" class="add_mini_heart">
                                        <i style="color: red;background-color: white;" class="fas fa-heart fa-heart-book"></i></a>
                                        @endif
                                    </div>
                                @endauth        
                                                
                        </div>
                            @else
                                <img  src="{{ asset('img/no_pic.png') }}" >                                
                            @endif
                    </div>
                    @endforeach 
 
                </div>
                <div class="owl-theme">
                    <div class="owl-controls">
                        <div class="custom-nav owl-nav"></div>
                    </div>
                </div>
                <div class="text-center card-img-top-best">
                    <p><font id="best_price"class="p-2 mb-4 rcorners2 bg-white" style="border: solid 1px red;color:red;"><b>฿{{ $best_sellers[0]->getProduct->product_price ?? '-' }}</b></font></p>
                    <a id="best_name_url" href="{{ url('products/detail/'.($best_sellers[0]->getProduct->id ?? '')) }} " ><h5  class="mb-2"><b><font id="best_name" size="4" color="red">{{ $best_sellers[0]->getProduct->book_name ?? '-' }}</font></b></h5></a>
                    <h6 id="best_writer">{{ $best_sellers[0]->getProduct->writer ?? '-' }}</h6>
                    
                    @auth
                        @if(($best_sellers[0]->getProduct->stock_remain ?? 0) > 0)
                        
                        <p></p>
                        <a href="javascript:void(0)" id="best_cart" data-id-product="{{ $best_sellers[0]->getProduct->id }}" data-blame-product="{{ $best_sellers[0]->getProduct->blame_product }}" data-buffet="{{ $best_sellers[0]->getProduct->buffet }}" data-can-discount="{{ $best_sellers[0]->getProduct->can_discount }}" class="add_cart btn btn-danger pl-2 pr-2"><font>หยิบใส่ตระกร้า </font> <span class="vr"></span><i class="fas fa-cart-plus fa-1x"></i></a>
                        
                        @endif
                    @else
                          
                        <a href="{{ route('login') }}" class="btn btn-danger mt-3 pl-2 pr-2"><font>เพิ่มใส่ตระกร้า </font> <span class="vr"></span><i class="fas fa-cart-plus fa-1x"></i></a>
                        
                    @endauth
                </div>  

            </div>
        </div>
    </section>

    <!-- ebook_real -->
    <section class="women-banner spad py-4">
        <div class="container " >

            <div class="head_text"><h2 class="head_text_string">นิยายมาใหม่</h2>
                <div class="option_head_text">
                    <a href="{{ url('products') }}" style="float: right;">ดูทั้งหมด</a>
                </div>
            </div>
                    <div class="row display-flex rcorners">
                        @foreach ($products_news as $products_new)
                            <div class="product-item  product_img two    rcorners  col-12 col-xs-6 col-sm-6 col-md-6 col-lg-4 col-xl-3 center text-center">
                                <div class="card rcorners "  >
                                    <!-- <img class="" src=".../100px180/?text=Image cap" alt="Card image cap"> -->

                                    <div style=" max-width: 55vh;" class="rcorners card-img-top ">
                                        <figure class='book3d '>
                                          <!-- Front -->
                                          <ul class='hardcover_front '>
                                            <li style="background-color: #43202F; " class="pi-pic">
                                                @if($products_new->getPhoto) 
                                                      
                                                        @foreach ($products_new->getPhoto as $value )
                                                            @if($value->default == "true")
                                                                <img src="{{asset('storage/book-images/thumbnail/'.($value->photo ?? '') )}}" class="cropped1 parent" />
                                                               @break
                                                            
                                                            @else
                                                                @if(!$loop->last)
                                                                    @continue
                                                                @endif
                                                                <img src="{{asset('storage/book-images/thumbnail/'.($products_new->getPhoto[0]->photo ?? '') )}}" class="cropped1 parent" />
                                                                
                                                            @endif
                                                        @endforeach
                                                @else
                                                    <img class="cropped1" src="{{ asset('img/no_pic.png') }}" >                                
                                                @endif
                                                
                                                
                                                @if($products_new->stock_remain > 0)
                     
                                                    <div class="" >
                                                        <h5 class="tab_book" style="background-color:Purple;border: 1px solid DarkMagenta;">ใหม่</h5>
                                                    </div>
                                                @else
                                                    
                                                    <div class="" >
                                                        <h5 class="tab_book" style="background-color:red;border: 1px solid DarkRed;">หมด</h5>
                                                    </div>
                                                @endif

                                                @auth
                                                <div class="icon_heart">
                                                    @if(empty($products_new->getFavorBook->book_id))
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_new->id }}" data-id-favor="{{ $products_new->getFavorBook->book_id ?? '' }}" data-type="book" class="add_mini_heart">
                                                    <i style="color: black;background-color: white;" class="far fa-heart fa-heart-book"></i></a>                                    
                                                    @else
                                                    <a href="javascript:void(0)" data-id-product="{{ $products_new->id }}" data-id-favor="{{ $products_new->getFavorBook->book_id ?? '' }}" data-type="book" class="add_mini_heart">
                                                    <i style="color: red;background-color: white;" class="fas fa-heart fa-heart-book"></i></a>
                                                    @endif                                                                                        
                                                </div>
                                                @endauth
                                            </li>
                                            <li style="background-color: #43202F;"></li>
                                          </ul>
                                          <!-- Pages -->
                                          <ul class='page'>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                          </ul>
                                          <!-- Back -->
                                          <ul class='hardcover_back'>
                                            <li style="background-color: #43202F;"></li>
                                            <li style="background-color: #43202F;"></li>
                                          </ul>
                                        </figure>
                                      </div>
                                
                                    <div class="card-body" >
                                        <div class="pi-text mt-1 text-left" >
                                            
                                            @if($products_new->book_name)
                                                <a href="{{ url('products/detail').'/'.$products_new->id }}"><font class="pl-4" size="4" color="black"><b>{{ $products_new->book_name }}</b></font></a>                                           
                                            @endif                                        
                                            @if($products_new->writer)
                                                <font class="pl-4" size="3" color="SlateGrey">{{ $products_new->writer }}<br></font> <!--ซีรีส์ชุด -->
                                            @else
                                                <font class="pl-4" size="3" color="SlateGrey">-</font> <!-- ซีรีส์ชุด -->
                                            @endif
                                             
                                        </div>
                                        
                                    </div>
                                    <div class="" style="width:100%;height: 70px;">
                                        <table  style="width:100%;height: 100%;">
                                            <tbody>
                                                <tr>                                                    
                                                    <td class="text-left pl-4">
                                                        @if($products_new->price)                                           
                                                            <b><font size="4"  color="red" class="" >฿{{number_format($products_new->price)}}</font></b>
                                                        @else
                                                            <b><font size="4" color="red">฿ -</font></b>
                                                        @endif
                                                    </td>
                                                    <td class="text-right pr-4">
                                                        @if($products_new->stock_remain > 0)
                                                            <font size="3" color="DarkGrey" class="">{{number_format($products_new->stock_remain)}} เล่ม</font>
                                                        @else
                                                            <font size="3" color="DarkGrey" class="">0 เล่ม</font>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>  

                                    </div>
                                    <div class="caption rcorners " >   
                                        <table  style="width:100%;height: 100%;">
                                            <tbody>
                                                <tr>                                                    
                                                    <td>
                                                    @auth
                                                        <a href="javascript:void(0)" class="add_cart btn btn-danger p-2 rcorners2 hvr-grow shadow1 {{ $products_new->stock_remain <= 0 ? 'disabled' :'' }}" style="width: 50px" data-id-product="{{ $products_new->id }}" data-blame-product="{{ $products_new->blame_product }}" data-buffet="{{ $products_new->buffet }}" data-can-discount="{{ $products_new->can_discount }}" ><i class="fas fa-shopping-cart"></i></a>                
                                                    @else 
                                                        <a href="{{ route('login') }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1" style="width: 50px"><i class="fas fa-shopping-cart"></i></a>                                                        
                                                    @endauth
                                                        <a href="{{ url('file/'.$products_new->attachment) }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1 {{ !$products_new->attachment ? 'disabled': '' }}" style="width: 50px" target=_blank  title="อ่านเรื่องย่อ"  ><i class="far fa-file-pdf"></i></a>                                                                            
                                                        <a href="{{ url('products/detail/'.$products_new->id) }}" class="btn btn-danger p-2 rcorners2 hvr-grow shadow1 " style="width: 50px"><i class="far fa-eye"></i></a>
                                                        <div style="display: inline;" class="link_image_popups">
                                                            <a href="{{ url('storage/book-images/'.$products_new->picture) }}" class="btn btn-danger p-2 image_popup_link rcorners2 hvr-grow shadow1" data-effect="mfp-zoom-out" style="width: 50px" ><i class="fas fa-expand-arrows-alt"></i></a>                                                      
                                                        </div>
                                                        
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                                                                                                                
                                                                                                                    
                                    </div> 
                                </div>                                 
                            </div>

                        @endforeach 
                    </div>

        </div>
    </section>
  
    <!-- <section class="py-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8" >
                    <div class="blog-slider">
                        <div class="blog-slider__wrp swiper-wrapper">
                        @foreach ($wait_fictions as $wait_fiction)
                          <div class="blog-slider__item swiper-slide">
                            <div class=" row" style="width: 100%;height:100%">
                
                                <div class="blog-slider__content col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center" >
                                    <span class=""><b><font size="6">นิยายรอตีพิมพ์</font></b></span><br><br>   {{-- blog-slider__code --}}            
                                    <div class="blog-slider__title "style="width: 100%">
                                          @if($wait_fiction->book_name)
                                          <a href="{{ url('products/waitFiction/detail/'.$wait_fiction->id) }}"><font size="5"  color="red">{{ $wait_fiction->book_name }}</font></a>
                                      @else
                                          <br>
                                      @endif
                                    </div>
                                    <div class="blog-slider__text" style="width: 100%">
                                          @if($wait_fiction->writer)
                                          <font size="3" color="black">
                                              {{ $wait_fiction->writer }}
                                          </font>
                                          @else
                                          <font  size="3" color="black">
                                              -   
                                          </font>
                                          @endif
                                    </div>
                                    <a href="{{ url('products/waitFiction') }}" class=" btn btn-danger blog-slider__button">ดูทั้งหมด</a>
                                </div>
                
                                <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6 text-center" >
                                    <div class="">
                                        @if($wait_fiction->picture)              
                                            <img class="rcorners blog-slider__img" src="{{ asset('img/books_test.jpg') }}" >
                                        @else
                                            <img class="rcorners cropped1 blog-slider__img"  src="{{ asset('img/no_pic.png') }}" >                                
                                        @endif 
                                    </div>
                                    
                                </div>
                            </div>
                          </div>
                        @endforeach
                          
                        </div>
                        <div class="row mt-4">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="blog-slider__pagination text-center " style="padding-left: 15px;padding-right: 25px;"></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                
                            </div>
                        </div>
                        
                    </div>

                </div>
                <div class="col-lg-4 col-md-4 text-center">
                    <div id="fb-root"></div>
                    <div class="fb-page" style="width: 100%" data-href="https://web.facebook.com/lightoflovebooksfanpage/" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                        <blockquote cite="https://web.facebook.com/lightoflovebooksfanpage/" class="fb-xfbml-parse-ignore">
                            <a href="https://web.facebook.com/lightoflovebooksfanpage/">ไลต์ ออฟ เลิฟ บุ๊คส์ - เขียนฝัน แสนรัก แก้วชวาลา</a>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section> -->


@endsection

@section('js')
<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.5/gsap.min.js"></script>
<script>
        $(document).ready(function() {
            let swiper_main = new Swiper('.swiper-main', {
                direction: 'horizontal',
                loop: false,
                speed: 1200,
                grabCursor: true,
                // mousewheel: true,
                autoplay: false,
                pagination: {
                    el: '.swiper-pagination-main',
                    // dynamicBullets: true,
                    type: 'bullets',
                    clickable: true,
                },
                on: {
                    slideChangeTransitionStart: function () {
                        // Slide captions
                        let swiper_main = this;
                        setTimeout(function () {
                            let slideTitle = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-title");
                            let slideSubtitle = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-subtitle");
                            let slideLink = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-link");
                            let slideImg = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-img");                            
                        }, 500);
                        gsap.to($(".current-title"), 0.4, {autoAlpha: 0, y: -40, ease: Power1.easeIn});
                        gsap.to($(".current-subtitle"), 0.4, {autoAlpha: 0, y: -40, delay: 0.15, ease: Power1.easeIn});
                        gsap.to($(".slideImageMainStyle"), 0.4, {autoAlpha: 0, y: 0, x: 80, delay: 0.15, ease: Power1.easeIn});
                        
                        
                        // $(".slide-captions").html(function() {
                        //     return `<h2 class='current-title'>${slideTitle}</h2>
                        //             <h5 class='current-subtitle'>${slideSubtitle}</h5>`;
                        // });
                        // $(".slide-captions-buttom").html(function() {
                        //     return `<a href="${slideLink}" class="slideDesMainStyle" target="_blank">ดูรายละเอียดเพิ่มเติม</a>`;
                        // });
                        
                    },
                    slideChangeTransitionEnd: function () {
                        // Slide captions
                        let swiper_main = this;
                        let slideTitle = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-title");
                        let slideSubtitle = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-subtitle");
                        let slideLink = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-link");
                        let slideImg = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-img");    
                        $(".slide-captions").html(function() {
                            return `<h2 class='current-title'>${slideTitle}</h2>
                                     <h5 class='current-subtitle'>${slideSubtitle}</h5>`;
                        });
                        $(".slide-captions-buttom").html(function() {
                            return `<a href="${slideLink}" class="slideDesMainStyle" target="_blank">ดูรายละเอียดเพิ่มเติม</a>`;
                        });
                        $(".slide-captions-image").html(function() {
                            return `<img src="${slideImg}" class="slideImageMainStyle cropped1">`;
                        });
                        gsap.from($(".current-title"), 0.4, {autoAlpha: 0, y: 40, ease: Power1.easeOut});
                        gsap.from($(".current-subtitle"), 0.4, {autoAlpha: 0, y: 40, delay: 0.15, ease: Power1.easeOut});
                        gsap.from($(".slideImageMainStyle"), 0.4, {autoAlpha: 0,x: -80 , y: 0, delay: 0.15, ease: Power1.easeIn});
                    }
                }
            });
            // Slide captions on load
            let slideTitle = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-title");
            let slideSubtitle = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-subtitle");
            let slideLink = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-link");
            let slideImg = $(swiper_main.slides[swiper_main.activeIndex]).attr("data-img");    
            $(".slide-captions").html(function() {
                    return `<h2 class='current-title'>${slideTitle}</h2>
                            <h5 class='current-subtitle'>${slideSubtitle}</h5>`;
                });
            $(".slide-captions-buttom").html(function() {
                return `<a href="${slideLink}" class="slideDesMainStyle" target="_blank">ดูรายละเอียดเพิ่มเติม</a>`;
            });
            $(".slide-captions-image").html(function() {
                return `<img src="${slideImg}" class="slideImageMainStyle cropped1">`;
            });

            
            // var menu = ['Slide 1', 'Slide 2', 'Slide 3', 'Slide 4']
            // new Swiper('.swiper-container', {
            //     loop: true,
            //     slidesPerView: 1,
            //     speed: 400,
            //     spaceBetween: 10,
            //     autoplay: {
            //         delay: 2500,
            //         disableOnInteraction: true,
            //     },
            //     // disableOnInteraction: true,
            //     pagination: {
            //     el: '.swiper-pagination',
            //             clickable: true,
            //         renderBullet: function (index, className) {
            //         return '<span class="btn btn-dark pl-2 pr-2 ' + className + '">' + ([index+1]) + '</span>';
            //         },
            //     },
            //     //Navigation arrows
            //     navigation: {
            //         nextEl: '.swiper-button-next',
            //         prevEl: '.swiper-button-prev',
            //     },
            // });
            // new Swiper ('.swiper-container-best-test', {
            //     spaceBetween: 30,
            //     breakpoints: {
            //         0:{
            //             slidesPerView:1
            //         },
            //         320: {
            //             slidesPerView: 1,
            //         },
            //         480: {
            //             slidesPerView: 1,
            //         },
            //         640:{
            //             slidesPerView:1
            //         },
            //         960:{
            //             slidesPerView:1
            //         },
            //         1200:{
            //             slidesPerView:2
            //         }                    
            //     }
            // });
            // var swiper = new Swiper('.blog-slider', {
            //     spaceBetween: 30,
            //     effect: 'fade',
            //     loop: true,
            //     mousewheel: {
            //         invert: false,
            //     },
            //     // autoHeight: true,
            //     pagination: {
            //         el: '.blog-slider__pagination',
            //         clickable: true,
            //     }
            // });
          
            var mySwiper = document.querySelector('.swiper-container').swiper

            $(".swiper-container").mouseenter(function() {
                mySwiper.autoplay.stop();
            });

            $(".swiper-container").mouseleave(function() {
                mySwiper.autoplay.start();
            });
           
        });
    
    $(function(){

        var $owl = $('.owl-carousel');

        $owl.children().each( function( index ) {
            $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
            // $(this).attr( 'data-name', index );
            
            });

            $owl.owlCarousel({
                nav: true,
                navText: [
                    '<i class="fas fa-arrow-circle-left" style="color:red;background-color:white;border: 1px solid DarkRed;border-radius: 100%;" ></i>',
                    '<i class="fas fa-arrow-circle-right" style="color:red;background-color:white;border: 1px solid DarkRed;border-radius: 100%;" ></i>'
                ],
                navContainer: '.main-content .custom-nav',
                // autoplay:true,
                // autoplayTimeout:3000,
                // autoplayHoverPause:true,
                smartSpeed:1000,
                dots: false,
                center: true,
                loop: true,
                items: 3,
                margin:10,
                afterUpdate: function () {
                updateSize();
            },
        afterInit:function(){
            updateSize();
        },
            responsive:{
                0:{
                    items:1
                },
                640:{
                    items:2
                },
                960:{
                    items:3
                },
                1200:{
                    items:3
                }
            }
            });
          

            $(document).on('click', '.owl-item>div', function() {
                // see https://owlcarousel2.github.io/OwlCarousel2/docs/api-events.html#to-owl-carousel
                var $speed = 600;  // in ms
                // alert($(this).data( 'position' ));
                $('#best_name').html($(this).data( 'name' ) ?? '-')
                $('#best_writer').html($(this).data( 'writer' ) ?? '-')
                $('#best_price').html('฿'+$(this).data( 'product-price' ) ?? '-')
                // $('#best_price').html('฿'+$(this).data( 'price' ) ?? '-')

                $('#best_cart').attr('data-id-product',$(this).data( 'id-product' ))
                $('#best_cart').attr('data-blame-product',$(this).data( 'blame-product' ))
                $('#best_cart').attr('data-buffet',$(this).data( 'buffet' ))
                $('#best_cart').attr('data-can-discount',$(this).data( 'can-discount' ))
                $('#best_name_url').attr('href',"{{ url('products/detail') }}/"+$(this).data( 'id-product' ))
                
                
                $owl.trigger('to.owl.carousel', [$(this).data( 'position' ), $speed] );
            });
            function updateSize(){
                var minHeight=parseInt($('.owl-item').eq(0).css('height'));
                $('.owl-item').each(function () {
                    var thisHeight = parseInt($(this).css('height'));
                    minHeight=(minHeight<=thisHeight?minHeight:thisHeight);
                });
                $('.owl-wrapper-outer').css('height',minHeight+'px');

                /*show the bottom part of the cropped images*/
                $('.owl-carousel .owl-item img').each(function(){
                    var thisHeight = parseInt($(this).css('height'));
                    if(thisHeight>minHeight){
                        $(this).css('margin-top',-1*(thisHeight-minHeight)+'px');
                    }
                });

            }

        
        // $owl.on('changed.owl.carousel', function(event) {
        //     var item      = event.item.index;
        //     alert($(this).data( 'name' ))
        // })
        $owl.on('changed.owl.carousel',function(property){
            var current = property.item.index;
            var e = $(property.target).find(".owl-item").eq(current).children();
            // var price = $(property.target).find(".owl-item").eq(current).children().data('price');
            // var witer = $(property.target).find(".owl-item").eq(current).children().data('witer');
            $('#best_name').html(e.data('name') )
            $('#best_writer').html(e.data('writer') )
            // alert(e.data('price'));
            if(e.data('product-price')){
                var text_price = '฿'+ e.data('product-price') ;
            }
            $('#best_price').html(text_price);
            if(e.data( 'id-product' )){
                $('#best_name_url').attr('href',"{{ url('products/detail') }}/"+e.data( 'id-product' ))
                $('#best_cart').attr('data-id-product',e.data( 'id-product' ))
            }
            

            
            $('#best_cart').attr('data-blame-product',e.data( 'blame-product' ))
            $('#best_cart').attr('data-buffet',e.data( 'buffet' ))
            $('#best_cart').attr('data-can-discount',e.data( 'can-discount' ))

            // var src = $(property.target).find(".owl-item")
            // console.log('Image current is ' + e.data('name'));
        });



        // Image popups
        $('.link_image_popups').magnificPopup({
            delegate: 'a',
            type: 'image',
            removalDelay: 500, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function() {
                // just a hack that adds mfp-anim class to markup 
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeOnContentClick: true,
            midClick: true 
        });
       


        
        $('body').on('click', '.add_cart', function() {
            // var Item_id = $(this).data('id-product');
            var Item_id = $(this).attr('data-id-product');
            var blame_product = $(this).data('blame-product');
            var buffet = $(this).data('buffet');
            var can_discount = $(this).data('can-discount');
            var type = $(this).data('type');

            // alert(Item_id);
            
            
            var user_id = "{{ $user ? $user->id : '' }}" ;
            var username = "{{ $user ? $user->username : '' }}";
            // var user_id = "{{ !empty($user->id) ? $user->id : null  }}" ;
            // var username = "{{ !empty($user->username) ? $user->username : null }}";
            $.ajax({
                type: "POST",
                url: "{{ url('cart') }}",
                data:{_token: "{{ csrf_token() }}", product_id:Item_id , user_id: user_id ,
                 username: username , blame_product: blame_product , buffet: buffet, can_discount:can_discount,type:type },
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