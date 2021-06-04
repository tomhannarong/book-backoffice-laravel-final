@extends('../layouts.app')

@section('menu_product_ebooks_menu_open' , 'menu-open')
@section('menu_product_ebooks_menu_open_active' , 'active')
@section('menu_product_ebooks' , 'active')

@section('css')
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

    .img-div {
    position: relative;
    /* width: 46%; */
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
    /* width: 100%; */
    max-width: auto;
    transition: .5s ease;
    backface-visibility: hidden;
    float: left;
    width:  200px;
    height: 200px;
    object-fit: cover;
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
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-4 pl-4">
                <font id="header_title" class="header_title">Products Menu </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item "><a href="{{ route('productsEbook.index') }}">E-Book Products</a></li>
                <li class="breadcrumb-item active">Edit Product</li></ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="justify-content-center py-4">
        <div class="">
            <div class="card" style="border: none ;">
                <form id="theForm" >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="card-body text-middle" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;border-top-left-radius: 25px;">
                        <div class="text-middle">
                            
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row ">
                                <div class="col-md-12 col-lg-12 mt-4 mb-4 pl-4">
                                    <font class="font_add_product pt-2 pb-2 ">ข้อมูลหนังสือ</font>
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 row" >
                                    <label for="isbn" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">ISBN</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" type="text" id="isbn" name="isbn" value="{{ $product->ISBN }}">
                                    </div>                            
                                </div>    
                                <div class="form-group col-md-6 row" >
                                    <label for="promote_link" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">Link หนังสือเป็นเล่ม</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" type="text" id="promote_link" name="promote_link" placeholder="https://" value="{{ $product->promote_link }}">
                                    </div>                            
                                </div>                                     
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 row" >
                                    <label for="book_name" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">ชื่อหนังสือ</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" type="text" id="book_name" name="book_name" value="{{ $product->book_name }}">
                                    </div>                        
                                </div>
                                <div class="form-group col-md-6 row" >
                                    <label for="alias" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">นามปากกา</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" type="text" id="alias" name="alias" value="{{ $product->alias }}">
                                    </div>                        
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 row" >
                                    <label for="book_type" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">ประเภทหนังสือ</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <select class="form-control btn_rounded border_box" name="book_type">	
                                            <option value="">ระบุประเภทหนังสือ</option>
                                            @foreach ($booktypes as $booktype)
                                                <option value="{{ $booktype->id }}" @if($booktype->id == $product->book_type_id) selected @endif >{{ $booktype->book_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>                        
                                </div>            
                                <div class="form-group col-md-6 row" >
                                    <label for="writer" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">ซีรีส์ชุด</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" type="text" id="writer" name="writer" value="{{ $product->writer }}">
                                    </div>                        
                                </div>
                            </div> 
                            <div class="row" >
                                <div class="form-group col-lg-6 col-md-12 row"  >
                                    <label for="" class="col-sm-12 col-md-12 col-lg-12 col-form-label text-color_main pl-4" style="padding-left:0">ภาพปก</label>
                                    <div class="col-sm-12 col-md-12 col-lg-12 pl-4" >
                                        <div class="box_ellipsis">
                                            <div class="row ">
                                                <div class="col-lg-3 col-md-3 col-sm-6  imgUp ">
                                                    <img src="{{ url('img/icon_pages/no_img-bg.png')}}" class="imagePreview cropped" alt="" sizes="" srcset="">
                                                    <!-- <div class="imagePreview cropped"></div> -->
                                                    <label class="btn btn-upload-img btn-default">Upload
                                                        <input type="file" id="name_picture" name="name_picture[]" class="uploadFile img imageClick" data-row="1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                                                    </label>
                                                </div><!-- col-2 -->  
                                                <i class="fa fa-plus imgAdd"></i>
                                            </div>
                                        </div> 
                                    </div>             
                                </div>                             
                                <div class="col-lg-6 col-md-12 "  >
                                    <div class="row">
                                        
                                        <div class="form-group col-lg-12 row">
                                            <label for="" class="col-sm-3 col-md-3 col-lg-3 col-form-label text-color_main pl-4" >ไฟล์เรื่องย่อ </label>
                                            <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                                <input type="text" class="form-control btn_rounded bg-white" readonly  placeholder="Choose File" value="{{ $product->attachment }}">
                                                    @if(!empty($product->attachment))
                                                    <span class="input-group-btn input-group-prepend" style="display: inline;">
                                                        <bottom class="btn text_sub_group_pdf btn-file">
                                                            <a style="display: inline;" href="{{ url('file/'.explode('.',$product->attachment)[0]) }}" target=_blank  title="อ่านเรื่องย่อ"><img src="{{ asset('images/pdf_icon.png') }}" border=0 height=20></a>
                                                        </bottom>
                                                    </span>
                                                    @endif
                                                <span class="input-group-btn input-group-prepend" style="display: inline;">
                                                    <bottom class="btn text_sub_group btn-file">
                                                        Browse… <input type="file" id="readpdf" name="readpdf">
                                                    </bottom>
                                                </span>
                                            </div>  
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <label for="" class="col-sm-3 col-md-3 col-lg-3 col-form-label text-color_main pl-4" >ไฟล์ E-Book</label>
                                            <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                                <input type="text" class="form-control btn_rounded bg-white" readonly  placeholder="Choose File" value="{{ $product->product_pdf }}">
                                                    @if(!empty($product->product_pdf))                                                
                                                    <span class="input-group-btn input-group-prepend" style="display: inline;">
                                                        <bottom class="btn text_sub_group_pdf btn-file">
                                                            <a style="display: inline;" href="{{ url('fileEbook/'.explode('.',$product->product_pdf)[0]) }}" target=_blank  title="อ่านเรื่องย่อ"><img src="{{ asset('images/pdf_icon.png') }}" border=0 height=20></a>
                                                        </bottom>
                                                    </span>
                                                    @endif                                                
                                                <span class="input-group-btn input-group-prepend" style="display: inline;">
                                                    <bottom class="btn text_sub_group btn-file">
                                                        Browse… <input type="file" id="pdf" name="pdf">
                                                    </bottom>
                                                </span>
                                            </div> 
                                        </div>
                                        <div class="form-group col-lg-12 row">
                                            <div id="photo_current" class="pl-4" style="width:100%;">
                                                @foreach($product->getPhoto as $val)
                                                    <div class="img-div">
                                                        <img src="{{ asset('storage/book-images/' . $val->photo) }}" width="200px"  class="img-responsive image img-thumbnail btn_rounded"> 
                                                        <div class="middle">
                                                            <a href="javascript:void(0)" class="btn @if($val->default =='true') btn-success-custom @else btn-default-custom @endif default_photo" data-id="{{ $val->id }}" data-id-product="{{ $val->product_id }}"><i class="fas fa-check"></i></a>
                                                            <a href="javascript:void(0)" class='btn btn-paid-sendback del_photo' data-id="{{ $val->id }}"><i class='fa fa-trash'></i></a>
                                                        </div>                                                                                  
                                                    </div>
                                                @endforeach
                                            
                                            </div>
                                        </div>
                                    </div>
                                                                                                   
                                </div>                                        
                            </div> 

                            <div class="row ">
                                <div class="col-md-12 col-lg-12 mt-4 mb-4 pl-4">
                                    <font class="font_add_product pt-2 pb-2 ">ข้อมูลการขาย</font>
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6 col-md-12 row "  >
                                    
                                    <div class="col-lg-12 col-md-12 py-2">            
                                        <div class="row">
                                            <div class="col-sm-3 col-md-3 col-lg-3 pl-4">
                                                <div>
                                                    <label for="price_real" class="col-form-label text-color_main " >ราคาขาย</label>
                                                </div>                                                
                                            </div>                                            
                                            <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                                <input type="number"  min="0" class="form-control btn_rounded" id="price_real" name="price_real" placeholder="ระบุตัวเลข" value="{{ $product->product_price }}">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text text_sub_group">บาท</div>
                                                </div>                                                    
                                            </div> 
                                        </div> 
                                    </div>  
                                    <div class="col-lg-12 col-md-12 py-2">            
                                        <div class="row">
                                            <div class="col-sm-3 col-md-3 col-lg-3 pl-4">
                                                <div>
                                                    <label for="price" class="col-form-label text-color_main " >ราคาปกติ</label>
                                                </div>                                                
                                            </div>                                            
                                            <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                                <input type="number"  min="0" class="form-control btn_rounded" id="price" name="price" placeholder="ระบุตัวเลข" value="{{ $product->price }}">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text text_sub_group">บาท</div>
                                                </div>                                                    
                                            </div> 
                                        </div> 
                                    </div>                                                                       
                                </div>
                                <div class="form-group col-lg-6 col-md-12 row "  >                                   
                                    <div class="col-lg-12 col-md-12 py-2 box_des_price">
                                        <div class="pt-2">
                                            <p><u>ตัวอย่างการแสดงราคา</u> เช่น ราคาปกติ <font class="price_normal">{{ $product->price ?? 0 }}</font> บาท ราคาขาย <font class="price_sele">{{ $product->product_price ?? 0 }}</font> บาท จะแสดงผลราคา คือ <s><font class="price_normal">{{ $product->price ?? 0 }}</font></s> <font class="price_sele">{{ $product->product_price ?? 0 }}</font> บาท</p>
                                            <p>ส่วนลด <b><font class="discountPercent">{{ number_format( ( (($product->price - $product->product_price ) / $product->price)*100 ), 0) }}</font>%</b> | ส่วนต่าง <b><font class="discountDiff">{{ $product->price - $product->product_price }}</font> บาท</b></p>
                                            <p>ส่วนแบ่งที่จะได้จากการขายแต่ละเล่ม : <b><font class="valShare">{{ ( $product->product_price * $product->affiliate_price ) / 100 }}</font> บาท</b> | คิดเป็น <b><font class="valPercentShare">{{ $product->affiliate_price }}</font>%</b> จากราคาขาย</p>
                                        </div>                                                
                                    </div> 
                                </div>                                                                     
                            </div>

                            <div class="row ">
                                <div class="col-md-12 col-lg-12 mt-4 mb-4 pl-4">
                                    <font class="font_add_product pt-2 pb-2 ">ข้อมูลสำนักพิมพ์</font>
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 row" >
                                    <label for="publisher" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">สำนักพิมพ์</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <select class="form-control btn_rounded border_box" name="publisher">	
                                            <option value="">ระบุสำนักพิมพ์</option>
                                            @foreach ($publishers as $publisher)
                                                <option value="{{ $publisher->id }}" @if($publisher->id == $product->publisher_id) selected @endif >{{ $publisher->publisher }}</option>
                                            @endforeach
                                        </select>
                                    </div>                        
                                </div>  
                                <div class="form-group col-md-6 row" >
                                    <label for="affiliate_price" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">ส่วนแบ่งให้สมาชิก</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" min="0" type="number" id="affiliate_price" name="affiliate_price" placeholder="ระบุตัวเลข" value="{{ $product->affiliate_price }}">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text text_sub_group">%</div>
                                        </div>  
                                    </div>                        
                                </div>
                                                              
                            </div>

                            <div class="row ">
                                <div class="col-md-12 col-lg-12 mt-4 mb-4 pl-4">
                                    <font class="font_add_product pt-2 pb-2 ">รายละเอียดหนังสือ</font>
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 py-3" >
                                    <div class="input-group ">
                                        <textarea id="description" name="description" class="btn_rounded form-control border_box">{{ $product->book_description }}</textarea>
                                    </div>                        
                                </div>           
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right order_status_footer" style="box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);">
                        <button type="button" class="btn btn-light btn-default-custom btn-paid-sendback" onclick="return window.history.back();"><img src="{{ url('img/icon_pages/sendback.png') }}"> <font>ยกเลิก</font></button>
                        <button type="submit" class="btn btn-success-custom btn-paid-success pl-4 pr-4"><img src="{{ url('img/icon_pages/correct.png') }}"> <font>บันทึก</font></button>
                    </div>                   
                </form>
            
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<script>

    $(function(){
        var theForm = $("#theForm");
        var table, Item_id = null;

        var fileArr = [];
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        $("#name_picture").change(function(){
            // check if fileArr length is greater than 0
            if (fileArr.length > 0) fileArr = [];
            
                $('#image_preview').html("");
                var total_file = document.getElementById("name_picture").files;
                var MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB //1048576 = 1 mb
                if (!total_file.length) return;
                for (var i = 0; i < total_file.length; i++) {
                if (total_file[i].size > MAX_FILE_SIZE) {
                    Swal.fire(
                        'Warning!',
                        '5MB Maximum for Attachment File Size',
                        ''
                    );
                    return false;
                }else if(!validImageTypes.includes(total_file[i].type)){
                    
                    Swal.fire(
                        'Warning!',
                        'format image only !!',
                        ''
                    );
                    return false;
                } else {
                    fileArr.push(total_file[i]);
                    $('#image_preview').append("<div class='img-div' id='img-div"+i+"'><img src='"+URL.createObjectURL(event.target.files[i])+"' width='200px'  class='img-responsive image img-thumbnail' title='"+total_file[i].name+"'><div class='middle'><button  value='img-div"+i+"' class='btn btn-paid-sendback action-icon' role='"+total_file[i].name+"'><i class='fa fa-trash'></i></button></div></div>");
                }
            }
        });
        function show_photo() {
            var Item_id = {{ $product->id }}  ;
            // alert(Item_id);
            $.ajax({
                type: "GET",
                url: "{{ url('admin/productsEbook') }}" + '/' + Item_id + '/edit',
                data:{_method: 'GET',fn:"show_photo"},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                cache:false,
                success: (response) => {
                    // console.log(response);
                    if ($.isEmptyObject(response.error)) {
                        $("#photo_current").html(response.html);
                        $('#image_preview').html('');
                    } 
                },
            });
        }
        
        $('body').on('click', '.default_photo', function(evt){
            let id = $(this).attr('data-id');
            let id_product = $(this).attr('data-id-product');
            
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ url('admin/productsEbook') }}" + '/' + id,
                data:{_method: 'PUT',id_product:id_product,fn:"default_photo"},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                cache:false,
                success: (response) => {
                    $.LoadingOverlay("hide");
                    if ($.isEmptyObject(response.error)) {
                        console.log(response);
                        Swal.fire(
                            'ตั้งหน้าปก!',
                            'ตั้งหน้าปกเรียบร้อยแล้วค่ะ.',
                            'success'
                        ).then((result) => {
                            show_photo();
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
                    $.LoadingOverlay("hide");
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
            
        });
       
        $('body').on('click', '.del_photo', function(evt){
            let id = $(this).attr('data-id');
            $.LoadingOverlay("show");
            $.ajax({
                type: "POST",
                url: "{{ url('admin/productsEbook') }}" + '/' + id,
                data:{_method: 'DELETE',fn:"del_photo"},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                cache:false,
                success: (response) => {
                    $.LoadingOverlay("hide");
                    if ($.isEmptyObject(response.error)) {
                        console.log(response);
                        Swal.fire(
                            'ลบ!',
                            'ลบเรียบร้อยแล้วค่ะ.',
                            'success'
                        ).then((result) => {
                            show_photo();
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
                    $.LoadingOverlay("hide");
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
            
        });
        
        
        $('body').on('click', '.action-icon', function(evt){
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
            document.getElementById('name_picture').files = FileListItem(fileArr);
            evt.preventDefault();
        });
        
        function FileListItem(file) {
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }

        $('body').on('keyup change', '#price', function() {    
            $('.price_normal').html($(this).val());        

            let price = $(this).val() ;
            let price_real = $("#price_real").val();  
            let affiliate_price = $("#affiliate_price").val();  
            

            if(price == ""){
                $('.price_normal').html("0");
            } else{
                calDiscount(price, price_real);
                calShare(price, price_real,affiliate_price);
            }
            
        });
        $('body').on('keyup change', '#price_real', function() {
            $('.price_sele').html($(this).val());

            let price = $("#price").val() ;
            let price_real = $(this).val();    
            let affiliate_price = $("#affiliate_price").val();  

            if(price_real == ""){
                $('.price_sele').html("0");
            } else{
                calDiscount(price, price_real);
                calShare(price, price_real,affiliate_price);
            }            
        });
        $('body').on('keyup change', '#affiliate_price', function() {
            let affiliate_price = $(this).val();     
            let price = $("#price").val() ;
            let price_real = $("#price_real").val();  

            if(affiliate_price == ""){
                $(".valShare").html("0");
                $('.valPercentShare').html("0");
            } else{
                calShare(price, price_real,affiliate_price);
            }            
        });
        const calDiscount = (price=0,price_real=0) =>{
            if(parseInt(price) > parseInt(price_real)  ){
                let dif =  price - price_real; 
                let discountPercent = ((dif / price) * 100 ) ;
                
                $(".discountPercent").html(discountPercent.toFixed(0));
                $(".discountDiff").html(dif);
                
            }else{
                $(".discountPercent").html("0");
                $(".discountDiff").html("0");
            }
            
            // console.log("price_real" ,price_real);
        }
        const calShare = (price=0,price_real=0,percentShare=0) =>{
            if(parseInt(price) >= parseInt(price_real)  ){
                if(percentShare){
                    let valDif = (price_real*percentShare) / 100 ;
                    
                    $(".valShare").html(valDif);
                    $(".valPercentShare").html(percentShare);
                }else{
                    $(".valShare").html("0");
                    $(".valPercentShare").html("0");
                }    
            }else{
                $(".valShare").html("0");
                $(".valPercentShare").html("0");
            }
            
            // console.log("price_real" ,price_real);
        }


        $('body').on('keyup', '#price', function() {
            $('#price_normal').html($(this).val());
            if($(this).val() == ""){
                $('#price_normal').html("0");
            } 
        });
        $('body').on('keyup', '#price_real', function() {
            $('#price_sele').html($(this).val());
            if($(this).val() == ""){
                $('#price_sele').html("0");
            } 
        });

        if (theForm.length > 0) {
            theForm.validate({
                rules: {
                    book_type: {
                        required: true,
                    },
                    book_name: {
                        required: true,
                    },
                    alias: {
                        required: true,
                    },
                    price: {
                        required: true,
                    },
                    price_real: {
                        required: true,
                    },
                    
                },
                messages: {
                    book_type: {
                        required: "กรุณาเลือกประเภทของหนังสือด้วยค่ะ",
                    },
                    book_name: {
                        required: "กรุณาใส่ชื่อหนังสือด้วยค่ะ",
                    },
                    alias: {
                        required: "กรุณาใส่นามปากกาของผู้แต่งด้วยค่ะ",
                    },
                    price: {
                        required: "กรุณาใส่ราคาปกติด้วยค่ะ",
                    },
                    price_real: {
                        required: "กรุณาใส่ราคาขายด้วยค่ะ",
                    },
                   
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                error.addClass('bg_error');         
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
            
            var Item_id = {{ $product->id }}  ;
            if ($("#theForm").valid()) {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{ url('admin/productsEbook') }}"+'/' + Item_id,
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
                                show_photo();
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

        $(document).on("change",".uploadFile", function(){
            var uploadFile = $(this);
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
    
            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file
    
                reader.onloadend = function(){ // set image data as background of div
                    //alert(uploadFile.closest(".upimage").find('.imagePreview').length);

                    // uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
                    uploadFile.closest(".imgUp").find('.imagePreview').attr('src', this.result);
                }
            }        
        });

    });
    
      tinymce.init({
        selector: '#description',
        menubar: true,
        height: 500,
        theme: 'modern',
        plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks fullscreen',
                'insertdatetime media table paste help wordcount' ,
                'directionality visualchars template codesample hr pagebreak nonbreaking ',
                'toc textcolor imagetools contextmenu colorpicker textpattern'
            ],
            toolbar: 'undo redo | image | formatselect | ' +
                'bold italic strikethrough forecolor backcolor | link | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            image_advtab: true,
            relative_urls : false,
            remove_script_host : true,
            document_base_url : 'http://www.example.com/path1/',
            images_upload_handler: function (blobInfo, success, failure) {
                    let data = new FormData();
                    data.append('file', blobInfo.blob(), blobInfo.filename());
                    data.append('fn', "upload_image_detail");
                    data.append('_method', "POST");
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/productsEbook') }}",
                        data:data ,
                        cache : false,
                        processData: false,
                        contentType: false,
                        success: (response) => {
                            // blobInfo.filename()
                            success(response.location.toString());
                            // console.log(response.location.toString());
                        },
                    });   
            }
      });

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

    $("#name_picture").change(function(){
        readURL(this , $("#img_name_picture"));
    });

    $(".imgAdd").click(function(){
        let rowCurrent =  $(".imageClick").data('row');
        // console.log(rowCurrent)
        // if(rowCurrent <= 3){
            $(".imageClick").removeClass( "imageClick" );
            let rowNew = rowCurrent + 1 ;
            $(this).closest(".row").find('.imgAdd')
            .before(`<div class="col-lg-3 col-md-3 col-sm-6 imgUp">
                        <img src="{{ url('img/icon_pages/no_img-bg.png')}}" class="imagePreview cropped" alt="" sizes="" srcset="">
                            <label class="btn btn-upload-img btn-default">
                                Upload<input type="file" id="name_picture" name="name_picture[]" class="uploadFile img imageClick" data-row="${rowNew}" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;">
                            </label>
                            <i class="fa fa-times del"></i>
                        </div>`);   
        // }else{
        //     Swal.fire({
        //         position: 'center',
        //         icon: 'success',
        //         title: 'จำกัดรูปภาพไม่เกิน 8 ',
        //         showConfirmButton: true,
        //         iconColor: '#ffffffff',
        //     })
        // }
        
            
    });

    $(document).on("click", ".imgAdd" , function() {
        let rowCurrent =  $(".imageClick").data('row');
        // if(rowCurrent <=  ){
            $(".imageClick").click();
        // }
        // $(".imageClick").removeClass( "imageClick" )
    });
    $(document).on("click", "i.del" , function() {
    // 	to remove card
    $(this).parent().remove();
    // to clear image
    // $(this).parent().find('.imagePreview').css("background-image","url('')");
    // Swal.fire({
    //     position: 'center',
    //     icon: 'success',
    //     title: 'จำกัดรูปภาพไม่เกิน 8 ',
    //     showConfirmButton: true,
    //     iconColor: '#ffffffff',
    // })

        
    });
    </script>

@endsection