@extends('../layouts.front')

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

#img-upload{
    width: 100%;
}
.linear-5 {
    background: rgb(102,25,185);
    background: radial-gradient(circle, rgba(102,25,185,1) 0%, rgba(25,182,223,1) 50%, rgba(42,124,222,1) 100%);
}

</style>
@endsection



@section('content')
<div class="container py-4">
    <form id="theForm" >
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="row">
        <div class="col-md-6 p-1 col-sm-12 col-lg-4">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card" >
                        <div class="card-header " >
                            <strong><font color="black">รูปปก</font></strong>
                        </div>
                        <div class="card-body ">
                            <!-- <img src="img/plus.png" alt="img" class="img-thumbnail"> -->
                            @if($user->avatar)
                                @if(filter_var($user->avatar, FILTER_VALIDATE_URL) === FALSE)
                                    
                                    <img src="{{ asset('storage/profile-uploads/'.$user->avatar) }}" id='img-upload' alt="img" class="img-thumbnail"/>
                                
                                @else
                                    <img src="{{ $user->avatar }}" id='img-upload' alt="img" class="img-thumbnail"/>
                                @endif        
                            @else
                            <img src="{{ asset('img/no_pic.png') }}" id='img-upload' alt="img" class="img-thumbnail"/>
                            @endif
                            <div class="form-group mt-2">
                                <label>Upload Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-outline-danger btn-file">
                                            Browse… <input type="file" id="imgInp" name="imgInp">
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly value="{{ $user->avatar }}">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 p-1 col-sm-12 col-lg-8">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card">

                        <div class="card-header " >
                            <strong><font color="black" >โปรไฟล์</font> </strong>
                        </div>
                        <div class="card-body ">
                            <div class="form-group m-1">
                                <label for="username">ID :</label>
                                <input type="text" class="form-control" id="username" name="username" readonly
                            aria-describedby="username" placeholder="Enter username" value="{{ $user->username }}">

                            </div>
                            <div class="form-group m-1">
                                <label for="name">ชื่อ-นามสกุล :</label>
                                <input type="text" class="form-control" id="name" name="name"
                            aria-describedby="name" placeholder="Enter Name" value="{{ $user->name }}">

                            </div>
                            <div class="form-group m-1">
                                <label for="email">E-Mail Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    aria-describedby="email" placeholder="Enter Email" value="{{ $user->email }}">

                            </div>
                            <div class="form-group m-1">
                                <label for="password">รหัสผ่าน :</label>
                                <input type="password" class="form-control" id="password" name="password"
                            aria-describedby="password" placeholder="Enter password" value="@if($user->check_repass == 'false')@if($user->social_type == 'line'){{'my-line-generator'}}@elseif($user->social_type == 'google'){{'my-google-generator'}}@elseif($user->social_type == 'facebook'){{'my-facebook-generator'}}@endif{{''}}@endif">
                            </div>
                            <div class="form-group m-1">
                                <label for="confirmpassword">ยืนยันรหัสผ่าน :</label>
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword"
                                    aria-describedby="confirmpassword" placeholder="Enter Confirm Password" value="@if($user->check_repass == 'false')@if($user->social_type == 'line'){{'my-line-generator'}}@elseif($user->social_type == 'google'){{'my-google-generator'}}@elseif($user->social_type == 'facebook'){{'my-facebook-generator'}}@endif{{''}}@endif">
                            </div>
                            <hr>
                            <p>
                                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    RE-PASSWORD
                                </button>
                            </p>
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="newpassword" name="newpassword"
                                            aria-describedby="newpassword" placeholder="รหัสผ่านใหม่ :">
                                    </div>
                                    <div class="form-group m-1">
                                        <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword"
                                            aria-describedby="confirmnewpassword" placeholder="ยืนยันรหัสผ่านใหม่ :">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="m-1">
                                <button type="button" class="btn btn-danger " onclick=window.history.back()>Cancel</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

@endsection



@section('js')
<script>

$(function(){

    //show()

    var theForm = $("#theForm");
    if (theForm.length > 0) {
        theForm.validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                username: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    maxlength: 255,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 4,
                    maxlength: 50,
                },
                confirmpassword: {
                    equalTo: "#password"
                },
                newpassword: {
                    required: false,
                    minlength: 4,
                    maxlength: 50,
                },
                confirmnewpassword: {
                    equalTo: "#newpassword"
                }
            },
            messages: {
                name: {
                    required: "Please enter name",
                    maxlength: "code maxlength should be 255 characters long."
                },
                username: {
                    required: "Please enter ID",
                    maxlength: "code maxlength should be 255 characters long."
                },
                email: {
                    required: "Please enter email",
                    maxlength: "The email should less than or equal to 50 characters",
                    email: "Please enter email format",
                },
                password: {
                    required: "Please enter password",
                    minlength: "The password should be accept minimum 4 characters",
                    maxlength: "The password should be accept minimum 50 characters",
                },
                confirmpassword: " Enter Confirm Password Same as Password",

                newpassword: {
                    required: "Please enter new password",
                    minlength: "The new password should be accept minimum 4 characters",
                    maxlength: "The new password should be accept minimum 50 characters",
                },
                confirmnewpassword: " Enter Confirm New Password Same as New Password",
            },
            errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                error.addClass('bg_error');
                // error.addClass('bg_error');
                element.closest('.form-group').append(error);
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
        
        var Item_id ="{{ $user->id }}" ;
        if ($("#theForm").valid()) {
            $.LoadingOverlay("show");
            $.ajax({
                url: "{{ url('profile') }}"+'/' + Item_id,
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
                        }).then((result) =>{
                            //window.history.back();
                            location.reload();
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
// end jquery
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
