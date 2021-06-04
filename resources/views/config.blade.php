@extends('../layouts.app')

@section('menu_config' , 'active')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.Thailand.js/dist/jquery.Thailand.min.css') }}" />
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

#img-upload{
    /* width: 100%; */
}
</style>
@endsection

@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-4 pl-4">
                <font id="header_title" class="header_title">Settings & Privacy </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Config Web</ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

 <form id="theForm" >
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row ml-4 mr-4 py-4">
        <div class="col-md-12 col-sm-12 col-lg-4">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="row justify-content-center ">
                        <div class="col">
                            <div class="card" style="border: none;margin-left: 0;" >
                                <div class="card-header text-center">
                                    <ul class="nav nav-tabs card-header-tabs ">
                                        <li class="nav-item" >
                                            <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                                <strong class="span_vertical_active">
                                                    Logo 
                                                </strong>  
                                                
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body ">   
                                @if(!empty($web_config->logo))
                                    <img src="{{ asset('storage/logo-uploads/'.$web_config->logo) }}" width="300px" id='img-upload' alt="img" class="img-thumbnail"/>
                                @else
                                    <img src="{{ asset('img/no_pic.png') }}" width="300px" id='img-upload' alt="img" class="img-thumbnail"/>
                                @endif        
                                    
                                    <div class="form-group mt-2">
                                        <label>Upload Image</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-success-custom btn-file" style="border-top-right-radius: 0;border-bottom-right-radius: 0;">
                                                    Browse… <input type="file" id="imgInp" name="imgInp" class="">
                                                </span>
                                            </span>
                                            <input type="text" class="form-control btn_rounded" readonly value="{{ $web_config->logo }}">
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="card" style="border: none;margin-left: 0;margin-top: 20px;">
                                <div class="card-header text-center">
                                    <ul class="nav nav-tabs card-header-tabs ">
                                        <li class="nav-item" >
                                            <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                                <strong class="span_vertical_active">
                                                    ส่วนแบ่งฝากขาย / ค่าธรรมเนียม 
                                                </strong>  
                                                
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body ">   
                                    <div class="">
                                        
                                        <div class="input-group text-center row">
                                            <div class=" text-center col-lg-5 col-md-5 col-sm-5" style="display: inline">
                                                <label for="share_admin">ส่วนแบ่งสำนักพิมพ์ (%)</label>
                                                <input type="number" min="0" step="1" max=100 class="form-control btn_rounded" id="share_admin"  name="share_admin" a placeholder="Enter share_admin" value="{{$web_config->share_admin}}">
                                            </div>
                                            <div class=" text-center col-lg-2 col-md-2 col-sm-2" style="display: inline">
                                                <i class="fas fa-arrows-alt-h fa-2x"></i>
                                            </div>
                                            <div class=" text-center col-lg-5 col-md-5 col-sm-5" style="display: inline">
                                                <label for="">ส่วนแบ่ง admin (%)</label>
                                                <input type="number" min="0" step="1"  class="form-control btn_rounded" id="share_admin_temp"  name="share_admin_temp" disabled value="{{100-$web_config->share_admin}}">
                                            </div>

                                            <div class=" text-center  col-lg-5 col-md-5 col-sm-5" style="display: inline">
                                                <label for="share_pub">ส่วนแบ่งนักเขียน(%)</label>
                                                <input type="number" min="0" max=100 step="1" class="form-control btn_rounded" id="share_pub"  name="share_pub" placeholder="Enter share_pub" value="{{$web_config->share_pub}}">
                                            </div>
                                            <div class=" text-center col-lg-2 col-md-2 col-sm-2" style="display: inline">
                                                <i class="fas fa-arrows-alt-h fa-2x"></i>
                                            </div>
                                            <div class=" text-center col-lg-5 col-md-5 col-sm-5" style="display: inline">
                                                <label for="share_admin">ส่วนแบ่ง admin (%)</label>
                                                <input type="number" min="0" step="1"  class="form-control btn_rounded" id="share_pub_temp"  name="share_pub_temp" disabled value="{{100-$web_config->share_pub}}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="">
                                        <label for="fee">ค่าธรรมเนียม (บาท)</label>
                                        <div class="input-group">
                                            <input type="number" min="0" step="1" class="form-control btn_rounded" id="fee"  name="fee" a placeholder="Enter fee" value="{{$web_config->fee}}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        

        <div class="col-md-12  col-sm-12 col-lg-8">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card" style="border: none;margin-left: 0;">
                        <div class="card-header text-center">
                            <ul class="nav nav-tabs card-header-tabs ">
                                <li class="nav-item" >
                                    <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                        <strong class="span_vertical_active">
                                            ตั้งค่า 
                                        </strong>  
                                        
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body " style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <label for="shop_name">ชื่อร้านค้า</label>
                                    <div class="form-group "> 
                                        <input type="text" class="form-control btn_rounded" id="shop_name" name="shop_name" placeholder="Enter shop_name" value="{{$web_config->shop_name}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <label for="publisher">สํานักพิมพ์</label>
                                    <div class="form-group "> 
                                        <input type="text" class="form-control btn_rounded" id="publisher" name="publisher" placeholder="Enter publisher" value="{{$web_config->publisher}}">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <label for="tag_title">tag title</label>
                                    <div class="form-group ">          
                                        <input type="text" class="form-control btn_rounded" id="tag_title" name="tag_title" placeholder="Enter tag_title" value="{{$web_config->tag_title}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="tag_keyword">tag keyword</label>
                                    <div class="form-group ">          
                                        <input type="text" class="form-control btn_rounded" id="tag_keyword" name="tag_keyword" placeholder="Enter tag_keyword" value="{{$web_config->tag_keyword}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="tag_description">tag description</label>
                                    <div class="input-group">
                                        <textarea class="form-control btn_rounded" id="tag_description"  name="tag_description" a placeholder="Enter tag_description">{{$web_config->tag_description}}</textarea>
                                    </div>
                                </div>
                            
                                
                                <div class="col-lg-6">
                                    <label for="address">ที่อยู่ : </label>
                                    <div class="input-group">
                                        <textarea class="form-control btn_rounded" id="address" name="address" autocomplete="off" placeholder="ที่อยู่ ,บ้านเลขที่">{{$web_config->address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="distric">ตำบล : </label>
                                    <div class="input-group">
                                        <input type="text" class="street-first form-control btn_rounded" id="distric" name="distric" placeholder="ตำบล" autocomplete="off"  value="{{$web_config->distric}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <label for="subdistric">อำเภอ : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control btn_rounded"  id="subdistric" name="subdistric" placeholder="อำเภอ" autocomplete="off" value="{{$web_config->subdistric}}">
                                    </div>
                                </div>                        
                                <div class="col-lg-6 ">
                                    <label for="province">จังหวัด : </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control btn_rounded" id="province" name="province" placeholder="จังหวัด" autocomplete="off" value="{{$web_config->province}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 ">
                                    <label for="zipcode">รหัสไปรษณีย์ : </label> 
                                    <div class="input-group">
                                        <input type="text" class="form-control btn_rounded"  id="zipcode" name="zipcode" placeholder="รหัสไปรษณีย์" autocomplete="off" value="{{$web_config->zipcode}}">                                                         
                                    </div> 
                                </div> 
                                <div class="col-lg-6">
                                    <label for="email">E-Mail Address</label>
                                    <div class="form-group ">                             
                                        <input type="email" class="form-control btn_rounded" id="email" name="email" placeholder="Enter Email" value="{{$web_config->email}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="email_news">E-Mail News</label>
                                    <div class="form-group ">                             
                                        <input type="email" class="form-control btn_rounded" id="email_news" name="email_news" placeholder="Enter email_news" value="{{$web_config->email_news}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="tel">โทรศัพท์</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control btn_rounded" id="tel"  name="tel" a placeholder="Enter tel" value="{{$web_config->tel}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="mobile_number">โทรศัพท์มือถือ</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control btn_rounded" id="mobile_number"  name="mobile_number" a placeholder="Enter mobile_number" value="{{$web_config->mobile_number}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="fax">fax</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control btn_rounded" id="fax"  name="fax" a placeholder="Enter fax" value="{{$web_config->fax}}">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <label for="buffet">buffet (เปิด/ปิด)</label> <i id="icon_switch" style="color: @if($web_config->buffet =='true') green @else red @endif" class="fas fa-circle"></i>
                                    <div class="form-group">
                                        <select class="form-control btn_rounded" id="buffet" name="buffet">
                                            <option value="true" @if($web_config->buffet =="true") SELECTED @endif >เปิด</option>
                                            <option value="false" @if($web_config->buffet =="false") SELECTED @endif>ปิด</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="fax">cancel time / day</label>
                                    <div class="input-group">
                                        <input type="text"  class="form-control btn_rounded" id="cancel_time"  name="cancel_time" a placeholder="Enter time / day" value="{{$web_config->cancel_time}}">
                                    </div>
                                </div>
                                
                                <!-- <div class="col-lg-6 text-center">
                                    
                                    <div class="input-group text-center">
                                        <div class="m-2 text-center">
                                            <label for="share_admin">ส่วนแบ่ง admin (%)</label>
                                            <input type="number" min="0" step="1"  class="form-control" id="share_admin"  name="share_admin" a placeholder="Enter share_admin" value="{{$web_config->share_admin}}">
                                        </div>
                                        <div class="m-2 text-center">
                                            <label for="share_pub">ส่วนแบ่งฝากขาย(%)</label>
                                            <input type="number" min="0" step="1" class="form-control" id="share_pub"  name="share_pub" a placeholder="Enter share_pub" value="{{$web_config->share_pub}}">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    <label for="fee">ค่าธรรมเนียม (บาท)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" step="1" class="form-control" id="fee"  name="fee" a placeholder="Enter fee" value="{{$web_config->fee}}">
                                    </div>
                                </div> -->
                                
                            </div>
                            <!-- <hr> -->
                           
                        </div>
                        <div class="card-footer text-right" style="background-color: white;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);">
                            <button type="button" class="btn btn-light btn-default-custom" onclick="return window.history.back();">ยกเลิก</button>
                            <button type="submit" class="btn btn-success-custom">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<!-- /.content-wrapper -->


@endsection

@section('js')
<!-- dependencies for zip mode -->
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/zip.js/zip.js') }}"></script>
<!-- / dependencies for zip mode -->

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/JQL.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/typeahead.bundle.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dist/jquery.Thailand.min.js') }}"></script>
<script>

$(function() {
    
    var theForm = $("#theForm");
    var table, Item_id = null;

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

    if (theForm.length > 0) {
        theForm.validate({
            rules: {
                email: {
                    required: true,
                    maxlength: 255,
                    email: true,
                },
            },
            messages: {
                email: {
                    required: "Please enter email",
                    maxlength: "The email should less than or equal to 255 characters",
                    email: "Please enter email format",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            error.addClass('bg_error');
            element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            },
            // submitHandler: function(form) {
            //     var url = theForm.attr('action');
            //     var type = theForm.attr('method');
            //     var title = "Cannot add new records.";
            //     Item_id = "{{ $web_config->id }}"
            //     $('#_method').val('POST');
            //     if (theForm.attr("typeForm") === "update") {
            //         $('#_method').val('PUT');
            //         url += '/' + Item_id;
            //         type = "POST";
            //         title = "Cannot update records.";
            //     }
            //     $.LoadingOverlay("show");
            //     $.ajax({
            //         url: "{{ url('admin/config') }}/" + Item_id,
            //         type: "POST",
            //         data:  new FormData(this),
            //         data: theForm.serialize(),
            //         cache:false,
            //         processData: false,
            //         contentType: false,
            //         success: (response) => {
            //             if ($.isEmptyObject(response.error)) {
            //                 console.log(response);
            //                 console.log(response.success);
            //                 $.LoadingOverlay("hide");
            //                 Swal.fire({
            //                     position: 'top-end',
            //                     icon: 'success',
            //                     title: 'Your work has been saved',
            //                     showConfirmButton: false,
            //                     timer: 800,
            //                 }).then((result) => {

            //                 });
            //             } else {
            //                 console.log(response.error);
            //                 $.LoadingOverlay("hide");
            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: "<strong>" + title + "</strong>",
            //                     text: "Error: " + response.error,
            //                 });
            //             }
            //         },
            //         error: (response) => {
            //             console.log('Error:', response);
            //             $.LoadingOverlay("hide");
            //             Swal.fire({
            //                 icon: 'error',
            //                 title: "<strong>" + title + "</strong>",
            //                 html: "<strong>Error Code: </strong>" + response
            //                     .status + "<p><strong>Message: </strong>" + JSON
            //                     .stringify(response.responseJSON.message) +
            //                     "</p>",
            //             })
            //         }
            //     });
            // }
        });
    }

    $("#theForm").on('submit',(function(e) {
        e.preventDefault();
        let Item_id = "{{ $web_config->id }}"
        if ($("#theForm").valid()) {
            $.LoadingOverlay("show");
            $.ajax({
                url: "{{ url('admin/config') }}/" + Item_id,
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
                            timer: 800,
                        }).then((result) => {
                            if(response.buffet == "true"){
                                $("#icon_switch").css('color','green');
                            }else{
                                $("#icon_switch").css('color','red');
                            }
                        });
                    } else {
                        console.log(response.error);
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            icon: 'error',
                            title: "<strong>" + title + "</strong>",
                            text: "Error: " + response.error,
                        });
                    }
                },
                error: (response) => {
                    console.log('Error:', response);
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        icon: 'error',
                        title: "<strong>" + title + "</strong>",
                        html: "<strong>Error Code: </strong>" + response
                            .status + "<p><strong>Message: </strong>" + JSON
                            .stringify(response.responseJSON.message) +
                            "</p>",
                    })
                },

                error: function(jqXHR, textStatus, errorThrown) {
                    $.LoadingOverlay("hide");
                }
            });
        }
    }));

});

    $(document).on('keyup change', '#share_admin', function() {
        let value = 100 - this.value ;
        $("#share_admin_temp").val(value);
    });
    $(document).on('keyup change', '#share_pub', function() {
        let value = 100 - this.value ;
        $("#share_pub_temp").val(value);
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

    $("#imgInp").change(function(){
        readURL(this , $("#img-upload"));
    });
</script>
@endsection
