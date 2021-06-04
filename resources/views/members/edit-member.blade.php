@extends('../layouts.app')

@section('menu_member_menu_open' , 'menu-open')
@section('menu_member_menu_open_active' , 'active')
@section('menu_member' , 'active')

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
                <font id="header_title" class="header_title">Member Menu </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item "><a href="{{ route('member.index') }}">Members</a></li>
                <li class="breadcrumb-item active">Edit Member</li></ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="justify-content-center py-4">
        <div class="">
            <div class="card " style="border: none ;">
            <form id="theForm">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    <div class="card-header text-center">
                        <ul class="nav nav-tabs card-header-tabs ">
                            <li class="nav-item" >
                                <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                    <strong class="span_vertical_active">
                                        Member 
                                    </strong>  
                                    
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body text-middle" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                        <div class="text-middle">
                            <div class="row">
                                <div class="form-group col-md-6 row">
                                    <label for="name" class="col-sm-4 col-md-4 col-lg-4 col-form-label" >ชื่อ-นามสกุล : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="text" id="name" name="name" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row ">
                                    <label for="class_user" class="col-sm-4 col-md-4 col-lg-4 col-form-label">User Class : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <select name="class_user" id="class_user" class="form-control btn_rounded">
                                            <option value="" >------------เลือกระดับ------------</option>
                                            <option value="admin" @if($user->class_user == "admin") SELECTED @endif>admin</option>
                                            <option value="pub" @if($user->class_user == "pub") SELECTED @endif>ฝากขาย (สำนักพิมพ์)</option>
                                            <option value="user" @if($user->class_user == "user") SELECTED @endif>สำหรับนักอ่าน</option>
                                            <option value="writer" @if($user->class_user == "writer") SELECTED @endif>สำหรับนักเขียน</option>
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 row">
                                    <label for="id_card " class="col-sm-4 col-md-4 col-lg-4 col-form-label">เลขบัตรประชาชน : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="text" id="id_card" name="id_card" value="{{ $user->sid }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row">
                                    <label for="address_full" class="col-sm-4 col-md-4 col-lg-4 col-form-label" >ที่อยู่ : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <textarea class="form-control btn_rounded" name="address_full" id="address_full" rows="2">{{ $user->address_full }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 row">
                                    <label for="subdistric" class="col-sm-4 col-md-4 col-lg-4 col-form-label">ตำบล : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="text" id="subdistric" name="subdistric" value="{{ $user->subdistric }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row">
                                    <label for="distric" class="col-sm-4 col-md-4 col-lg-4 col-form-label" >อำเภอ : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="text" id="distric" name="distric" value="{{ $user->distric }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 row">
                                    <label for="province" class="col-sm-4 col-md-4 col-lg-4 col-form-label">จังหวัด : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="text" id="province" name="province" value="{{ $user->province }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row">
                                    <label for="zipcode" class="col-sm-4 col-md-4 col-lg-4 col-form-label" >รหัสไปรษณีย์ : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="text" id="zipcode" name="zipcode" value="{{ $user->zipcode }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="form-group col-md-6 row">
                                    <label for="email" class="col-sm-4 col-md-4 col-lg-4 col-form-label" >E-mail : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="email" id="email" name="email" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6 row">
                                    <label for="mobile" class="col-sm-4 col-md-4 col-lg-4 col-form-label">เบอร์โทรศัพท์มือถือ : </label>
                                    <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="tel" id="mobile" name="mobile" value="{{ $user->tel }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2" >
                                <div class="form-group col-md-6 row">
                                    <label for="" class="col-sm-8 col-md-12 col-lg-12 col-form-label">รูปโปรไฟล์ : </label>
                                    <div class="input-group col-sm-8 col-md-12 col-lg-12">
                                        <input type="text" class="form-control btn_rounded" value="{{ $user->avatar }}" readonly >
                                        <span class="input-group-btn">
                                            <span class="btn btn-outline-success btn-file">
                                                Browse… <input type="file" id="name_picture" name="name_picture">
                                            </span>
                                        </span>
                                    </div>
                                    <img src="{{ $user->avatar ? asset('storage/profile-uploads/' . $user->avatar) : asset('images/noimage.png') }}" id='img_name_picture' width="250" height="250" alt="img" class="img-thumbnail m-4"/>
                                </div>                         
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right" style="background-color: white;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);">
                        <button type="button" class="btn btn-light btn-default-custom" onclick="return window.history.back();">ยกเลิก</button>
                        <button type="submit" class="btn btn-success-custom">บันทึก</button>
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
<!-- dependencies for zip mode -->
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/zip.js/zip.js') }}"></script>
<!-- / dependencies for zip mode -->

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/JQL.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/typeahead.bundle.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dist/jquery.Thailand.min.js') }}"></script>
<script>
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
    $(function(){
        
        var theForm = $("#theForm");
        if (theForm.length > 0) {
            theForm.validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 255,
                    },
                    class_user: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    name: {
                        required: true,
                    },
                },
                messages: {
                    username: {
                        required: "กรุณาใส่ Username ด้วยค่ะ",
                        minlength: "The password should be accept minimum 4 characters",
                        maxlength: "The password should be accept maximum 255 characters",
                    },
                    class_user: {
                        required: "กรุณาเลือก user class ด้วยค่ะ",
                    }, 
                    email: {
                        required: "Please enter email",
                        email: "Please enter email format",
                    },
                    name: {
                        required: "กรุณากรอกชื่อด้วยค่ะ",
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
            
            var Item_id = {{ $user->id }}  ;
            if ($("#theForm").valid()) {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{ url('admin/member') }}"+'/' + Item_id,
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
                                window.history.back();
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