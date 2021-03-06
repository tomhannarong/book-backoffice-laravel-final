@extends('../layouts.app')

@section('menu_board' , 'active')

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
                <font id="header_title" class="header_title">Settings & Privacy </font>
            </div>
            
            <div class="col-lg-12 col-md-12 col-sm-12 col-sx-12 pt-2 pl-4">
                <ol class="breadcrumb ">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('board.index') }}">Webboard</a></li>
                <li class="breadcrumb-item active">Edit Webboard</li></ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="justify-content-center py-4">
        <div class="">
            <div class="card" style="border: none">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs ">
                        <li class="nav-item" >
                            <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                <strong class="span_vertical_active">
                                    Webboard 
                                </strong>  
                                
                            </a>
                        </li>
                    </ul>
                </div>
                <form id="theForm" >
                    <div class="card-body text-middle" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                        <div class="text-middle">
                            
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                    <div class="form-group col-md-6 row">
                                        <label for="topic" class="col-sm-4 col-md-4 col-lg-4 col-form-label">??????????????????</label>
                                        <div class="input-group col-sm-8 col-md-8 col-lg-8">
                                        <input class="form-control btn_rounded" type="text" id="topic" name="topic" value="{{ $boardPost->topic }}">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="username" id="username" value="{{ Auth::user()->username ?? '' }}">

                                <div class="form-group">
                                    <label for="description">?????????????????????????????????????????? :</label>
                                    <textarea id="description" name="description" >{{ $boardPost->post_description }}</textarea>
                                </div>     
                            
                        </div>
                    </div>
                    <div class="card-footer text-right" style="background-color: white;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);">
                        <button type="button" class="btn btn-light btn-default-custom" onclick="return window.history.back();">??????????????????</button>
                        <button type="submit" class="btn btn-success-custom">??????????????????</button>
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

<script>
  
    $(function(){
        var theForm = $("#theForm");
        var table, Item_id = null;
        if (theForm.length > 0) {
            theForm.validate({
                rules: {
                    topic: {
                        required: true,
                    },    
                },
                messages: {
                    topic: {
                        required: "??????????????????????????????????????????",
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
            
            var Item_id = {{ $boardPost->id }}  ;
            if ($("#theForm").valid()) {
                $.LoadingOverlay("show");
                $.ajax({
                    url: "{{ url('admin/board') }}"+'/' + Item_id,
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
                    url: "{{ url('admin/board') }}",
                    data:data ,
                    cache : false,
                    processData: false,
                    contentType: false,
                    success: (response) => {
                        // blobInfo.filename()
                        success(response.location.toString());
                        console.log(response.location.toString());
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