@extends('../layouts.front')

@section('menu_cart' , 'active')

@section('css')

<style>
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
.card ,.proceed-checkout ,tfoot{
    border: 2px solid DarkGoldenRod ;
}
.card-header{
    background-color: Goldenrod;
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
.disabled{
    pointer-events: none;
    cursor: default;
}

</style>
@endsection

@section('content')


<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad py-4 women-banner spad">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="cart-table">
                    <table border="0" style="background-color: White;border: 2px solid DarkGoldenRod;">
                        <thead style="border: 2px solid DarkGoldenRod;">
                            <tr>                                
                                <th colspan="3">รายการหนังสือ</th>
                                <th>จำนวน</th>
                                <th>ส่วนลด</th>
                                <th>ราคา/เล่ม</th>
                                <th>รวม</th>
                                <th><i class="far fa-times-circle fa-2x"></i></th>
                            </tr>
                            <!-- <tr>                                
                                <th colspan="8" style="background-color: Khaki">รายการหนังสือปกติ</th>                           
                            </tr> -->
                        </thead>
                        <tbody id="html">
                            
                        </tbody>
                        
                        <tfoot style="background-color: Khaki;">
                            <tr>
                                <th colspan="3">รวมรายการหนังสือทั้งหมด</th>
                                <th><span id="html_quantity_all">{{$sum_quantity_all}}</span> เล่ม</th>
                                <th colspan="4"><span class="line-single">{{ number_format(round((float)$total_book_price_all,2),2) }}</span> บาท</th> 
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-7 ">
                    </div>
                    <div class="col-lg-5 ">
                        <div class="proceed-checkout">
                            <ul>                               
                                <li class="cart-total total_final">Total <span class="double">{{ number_format(round((float)$total_book_price_all,2),2) }}</span></li>
                            </ul>
                            
                            <a href="{{ url('cart/checkOut') }}" style="width:100%" class="btn btn-dark proceed-btn">PROCEED TO CHECK OUT</a>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->
    
@endsection

@section('js')

<script>
$(function(){
    var table =null;

    tableupdate('','','','','','book');

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
                        tableupdate(name ,rate);
                        mini_cart('show','','book');                         
                    });
                
                //$(".transport_name").html(html_trans);
                //$(".total_final").html(html_final);
                //alert(rate);
            }
    });
    function tableupdate(transport_name='' ,transport_rate='',fn='' , id_cart='',id_book='',type='') {
        $.ajax({
            url: "{{ url('cart') }}",
            type: "GET",
            dataType: 'JSON',
            cache: false,
            //add or demis 
            data: {transport_name:transport_name , transport_rate: transport_rate,fn:fn , id_cart:id_cart,id_book:id_book,type:type},
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    //console.log(response.success);
                    $('#html').html(response.html);
                    $('.line-single').html(response.html_total_book_price_all);
                    $('#html_quantity_all').html(response.sum_quantity_all);
                    //$(".total_final").html(html_final);
                    $(".transport_name").html(response.html_transport);
                    // $('.double').html(response.html_total_final);
                    $('.double').html(response.html_total_book_price_all);
                    
                    mini_cart('show','','book');      
                } else {
                    console.log(response.error);
                    Swal.fire({
                        icon: 'warning',
                        title: "<strong> เตือน </strong>",
                        text: "" + response.error,
                    });
                }
            }
        });
    }
 
    $('body').on('click', '.qua_minus', function() {
        var id_cart = $(this).data('id-cart');
        var id_book = $(this).data('id-book');
        var qua = $(this).data('value');
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'คุณได้ลบสินค้าออกเรียบร้อยแล้วค่ะ',
            showConfirmButton: false,
            timer: 800,
        }).then((result) => {
            tableupdate('','','qua_minus',id_cart ,id_book);
            
        });
        
        //alert("123");
    });
    $('body').on('click', '.qua_plus', function() {
        var id_cart = $(this).data('id-cart');
        var id_book = $(this).data('id-book');
        var qua = $(this).data('value');
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'คุณได้เพิ่มสินค้าเรียบร้อยแล้วค่ะ',
            showConfirmButton: false,
            timer: 800,
        }).then((result) => {
            tableupdate('','','qua_plus',id_cart,id_book);
        });
        
        //alert("123");
    });
    $('body').on('click', '.delete', function() {
        var id_cart = $(this).data('id-cart');
        var id_book = $(this).data('id-book');
        var qua = $(this).data('value');
        Swal.fire({
            position: 'top-end',
            icon: 'info',
            title: 'คุณได้ลบสินค้าออกเรียบร้อยแล้วค่ะ',
            showConfirmButton: false,
            timer: 800,
        }).then((result) => {
            tableupdate('','','delete',id_cart,id_book,'book');
        });
        
        //alert("123");
    });
 
});    

</script>

@endsection