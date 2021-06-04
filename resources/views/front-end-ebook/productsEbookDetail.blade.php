@extends('../layouts.front-ebook')

@section('menu_products_ebook' , 'active_nav')


@section('css')
<style>
.breadcrumb {
    margin-bottom: 0rem;
}
.option_head_text {
    align-items: center;
    /* position: absolute; */
    right: 0;
    bottom: 7px;
    /* font-family: Helvetica,Thonburi,Tahoma,sans-serif; */
    font-size: 20px;
    /* color: red; */
}
.head_text {
    border-bottom: 1px solid #8e918f;
    /* padding-bottom: 5px; */
    margin-bottom: 20px;
    position: relative;
}

.option_head_text a {
    color: black;
}
.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}

.linear-4 {
background: rgb(0,36,2);
background: linear-gradient(90deg, rgba(0,36,2,1) 0%, rgba(40,121,9,1) 20%, rgba(6,166,81,1) 54%, rgba(3,204,134,1) 79%, rgba(0,212,255,1) 97%);
}
.vr{
  display: inline-block; vertical-align: middle;
  height: 30px;
  margin-left: 5px;
  margin-right: 5px;
  width: 1px;
  background-color: white;
}
</style>
@endsection



@section('content')
<div class="py-4">
    <center>
        <h1>
        <strong>
        E-Books
        </strong><br/>
        </h1>
    </center>
</div>
<section>
    <div class="container">
        <section class="content-header">
            <div class="container">
                  <div class="head_text">
                  <div class="head_text_string row">
                      <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                          <h2 class="">{{ $products_alls->book_name }}</h2>
                      </div>
                      <div class="option_head_text col-12 col-sm-12 col-md-6 col-lg-6">
                          <div style="float: right;">
                              <ol class="breadcrumb float-sm-right" >
                                    <li class="breadcrumb-item" ><a href="{{ url('ebook') }}">หน้าแรก</a></li>
                                @if($product_type == "product_serie")
                                    <li class="breadcrumb-item" ><a href="{{ url('ebook/productsEbook/serie') }}">ซีรีส์ชุด E-Books</a></li>
                                @else
                                    <li class="breadcrumb-item" ><a href="{{ url('ebook/productsEbook') }}">E-Books</a></li>
                                @endif
                                    <li class="breadcrumb-item active" >{{ $products_alls->book_name }}</li>  
                              </ol>
                          </div>
                      </div>
                  </div>
                  
                      
                         
                  </div>
                  
            </div><!-- /.container-fluid -->
        </section>
        <div class="row justify-content-center">
            <div class="col-md-12 mb-5">
                <div class="card" >
                    {{-- <div class="card-header " >
                            <h4 class="card-title "><font color="black" >รายละเอียดสินค้า</font></h4>
                            
                    </div> --}}
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 text-center">
                                @if($products_alls->picture ) 
                                    <!-- <a href="/public/storage/book-images/{{ $products_alls->picture  }}" class="image-popup-no-margins" >
                                        <img style="background-color: HoneyDew;border: 2px solid DarkBlue;" src="{{ asset('storage/book-images/'.$products_alls->picture) }}" width="350" class="img-thumbnail" >
                                    </a> -->
                                    <!-- pic_test -->
                                    <a href="{{ url('storage/book-images/'.$products_alls->picture) }}" class="image-popup-no-margins" >
                                        <img style="background-color: HoneyDew;border: 2px solid DarkBlue;" width="300px" src="{{ asset('storage/book-images/'.$products_alls->picture) }}" width="350" class="img-thumbnail" >
                                    </a>                                                                                        
                                @else
                                    <img style="background-color: HoneyDew;border: 2px solid DarkBlue;" src="{{ asset('img/no_pic.png') }}" class="img-thumbnail">                                
                                @endif
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div style="padding-top: 15px">
                                    @if(!empty($products_alls->book_name))
                                        <p><font color="DarkSlateGrey" size="6"><b>{{ $products_alls->book_name }}</b></font></p>
                                    @endif
                                    @if(!empty($products_alls->product_price))
                                        @if(empty($products_alls->getApproveReadEbook->id))
                                            <p><font color="DarkSlateGrey">
                                                <font color="#FF0000"><b>฿{{ number_format(round((float)$products_alls->product_price,2),2) }}</b></font></font>
                                                <font color="black"><s>฿{{ number_format(round((float)$products_alls->price,2),2) }}</s></font>                                            
                                            </p>
                                        @else
                                            <p><font color="DarkSlateGrey">
                                            <font color="#FF0000"><b>ซื้อแล้ว</b></font></font><br>                                            
                                        @endif
                                    @endif
                                    <br>
                                    @if(!empty($products_alls->getBookType->book_type))
                                        <p><font color="DarkSlateGrey"><b>ประเภท : </b>{{ $products_alls->getBookType->book_type }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->writer))
                                        <p><font color="DarkSlateGrey"><b>ซีรีส์ชุด : </b>{{ $products_alls->writer }}</font></p>
                                    @endif
                                    
                                    @if(!empty($products_alls->alias))
                                        <p><font color="DarkSlateGrey"><b>ผู้แต่ง : </b>{{ $products_alls->alias }}</font></p>
                                    @endif
                                    @if(!empty($products_alls->getPublisher->publisher))
                                        <p><font color="DarkSlateGrey"><b>สำนักพิมพ์ : </b>{{ $products_alls->getPublisher->publisher }}</font></p>
                                    @endif
                                    
                                    @if(!empty($product_type))
                                        @if($product_type !== "product_wait_fiction")
                                        
                                            @if($products_alls->attachment)  
                                                &nbsp;<a style="display: inline;" href="{{ url('file/'.$products_alls->attachment) }}" target=_blank  title="อ่านเรื่องย่อ"><img src="{{ asset('images/pdf_icon.png') }}" border=0 height=30></a>
                                                <br>
                                                <br>
                                            @endif
                                            <br>
                                            @auth
                                            <div class="quantity">
                                                <div class="form-inline">
                                                    <a href="javascript:void(0)" class="qua_minus pr-2 {{ !empty($products_alls->getApproveReadEbook->id) ? 'disabled' : '' }}" data-id-book="{{ $products_alls->id }}" name="quantity" ><font color="red"><i class="fas fa-minus-circle fa-2x"></i></font></a>
                                                    <input readonly type="text" size="2" class="form-control qua_change" id="quantity_inp" data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity_inp" value="1" />                                                              
                                                    <a href="javascript:void(0)" class="qua_plus pl-2 pr-2 {{ !empty($products_alls->getApproveReadEbook->id) ? 'disabled' : '' }}"  data-id-book="{{ $products_alls->id }}" name="quantity" ><font color="red"><i class="fas fa-plus-circle fa-2x"></i></font></a>
                                                    <a href="javascript:void(0)" style="border: 3px solid DarkRed;" class="btn btn-danger pl-2 pr-2 ml-2 add_cart hvr-grow {{ !empty($products_alls->getApproveReadEbook->id) ? 'disabled' : '' }}" data-id-product="{{ $products_alls->id ?? '' }}" data-has-product="{{ $products_alls->getCartEbook->id ?? '' }}" data-type="ebook" ><font>เพิ่มใส่ตระกร้า </font> <span class="vr"></span><i class="fas fa-cart-plus fa-1x"></i></a>
                                        
                                                </div>                                                        
                                            </div>
                                            @else
                                            <a href="{{ route('login') }}" style="border: 3px solid Orange;" class="btn btn-warning ml-2 text-center hvr-grow"><i class="fas fa-user fa-1x"></i> {{ __('please Login') }}</a>                                                            
                                            @endauth
                                                                                         
                                        @endif
                                     @endif

                                     
                                        
                                    
                                </div> 
                                
                            </div>
                            
                            <div class="col-md-12 col-lg-12 py-4">
                            <hr>
                                    <article style="padding-top:15px" id="des"></article>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
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

<script>

$(function(){

        $.ajax({
            url: "{{ url('ebook/productsEbook/detail') }}/{{$products_alls->id_product}}",
            type: "GET",
            dataType: 'JSON',
            cache: false,
            success: (response) => {
                $('#des').html(response.des);
            }
        });
    var table , Item_id = null ;

    $('body').on('click', '.add_cart', function() {
        var Item_id = $(this).data('id-product');
        var blame_product = $(this).data('blame-product');
        var buffet = $(this).data('buffet');
        var can_discount = $(this).data('can-discount');
        var type = $(this).data('type');
        var has_product = $(this).attr('data-has-product');

        if(has_product){ // has a producet in cart
            //   alert(type)
              mini_cart('delete_mini',Item_id ,type).then(  
                Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้วค่ะ',
                  showConfirmButton: false,
                  timer: 1000,
                }).then((result) => {
                    // mini_cart('show','','ebook');  
                    location.reload()
                    
                })
              );
              
        }else{
            // alert(type)
            var user_id = "{{ $user ? $user->id : '' }}" ;
            var username = "{{ $user ? $user->username : '' }}";
            var qua = $('#quantity_inp').val();
            
            // var user_id = "{{ !empty($user->id) ? $user->id : null  }}" ;
            // var username = "{{ !empty($user->username) ? $user->username : null }}";
            $.ajax({
                type: "POST",
                url: "{{ url('cart') }}",
                data:{_token: "{{ csrf_token() }}", product_id:Item_id , user_id: user_id ,
                    username: username , blame_product: blame_product , buffet: buffet, can_discount:can_discount, qua:qua,type:type },
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
                                mini_cart('show','','ebook');  
                                var qua = $('#quantity_inp').val(1);
                                location.reload()
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
        }
    });

});
// end jquery
   
</script>
@endsection
