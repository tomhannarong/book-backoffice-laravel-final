@extends('../layouts.app')

@section('menu_product_menu_open' , 'menu-open')
@section('menu_product_menu_open_active' , 'active')
@section('menu_pre_product' , 'active')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-datetimepicker/css/yearpicker.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-ui/jquery-ui.min.css') }}" />
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
                <li class="breadcrumb-item "><a href="{{ route('productsEbook.index') }}">Pre-Products</a></li>
                <li class="breadcrumb-item active">Edit Pre-Product</li></ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="justify-content-center py-4"">
        <div class="">
            <div class="card" style="border: none ;">
                
                <form id="theForm" >
                    <div class="card-body text-middle" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;border-top-left-radius: 25px;">
                        <div class="text-middle">                            
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
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
                                        <input class="form-control btn_rounded border_box" type="text" id="isbn" name="isbn" value="{{ $product->isbn }}">
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
                                                    <img src="{{ $product->picture ? asset('storage/book-images/' . $product->picture) : asset('img/icon_pages/no_img-bg.png') }}" class="imagePreview cropped" alt="" sizes="" srcset="">
                                                    <!-- <div class="imagePreview cropped"></div> -->
                                                    <label class="btn btn-upload-img btn-default">Upload
                                                        <input type="file" id="name_picture" name="name_picture" class="uploadFile img imageClick" data-row="1" value="{{ $product->picture }}" style="width: 0px;height: 0px;overflow: hidden;">
                                                    </label>
                                                </div><!-- col-2 -->  
                                                <!-- <i class="fa fa-plus imgAdd"></i> -->
                                            </div>
                                        </div> 
                                    </div>             
                                </div>   
                                <div class="form-group col-lg-6 col-md-12 row"  >
                                    <label for="alias" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">จำนวนหน้า</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" min="0" type="number" id="pages" name="pages" placeholder="ระบุตัวเลข" value="{{ $product->pages }}">
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
                                                    <label for="price" class="col-form-label text-color_main " >ราคาขาย</label>
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
                                    <label for="pim_time" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">จำนวนตีพิมพ์ครั้งที่</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box" type="text" id="pim_time" name="pim_time" placeholder="ระบุตัวเลข" value="{{ $product->pim_time }}">
                                    </div>                        
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 row" >
                                    <label for="pim_year" class="col-sm-3 col-md-3 col-lg-3 pl-4 col-form-label text-color_main ">ปีที่ตีพิมพ์</label>
                                    <div class="input-group col-sm-9 col-md-9 col-lg-9">
                                        <input class="form-control btn_rounded border_box yearpicker" type="text" id="pim_year" name="pim_year" placeholder="2021" autocomplete="off" value="{{ $product->pim_year }}">
                                    </div>                        
                                </div>                                                                       
                            </div> 

                            <div class="row ">
                                <div class="col-md-12 col-lg-12 mt-4 mb-4 pl-4">
                                    <font class="font_add_product pt-2 pb-2 ">รายละเอียดหนังสือ</font>
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12" >
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
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/yearpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>


    $(function(){
        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4' ,
            dateFormat: 'yy-mm-dd' ,
        });
        // $('.yearpicker').yearpicker();

        var theForm = $("#theForm");
        var table, Item_id = null;
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
                    url: "{{ url('admin/preProducts') }}"+'/' + Item_id,
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
                        url: "{{ url('admin/preProducts') }}",
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

    $("#blame_picture").change(function(){
        readURL(this , $("#img_blame_picture"));
    });
    $("#name_picture").change(function(){
        readURL(this , $("#img_name_picture"));
    });
    </script>

@endsection