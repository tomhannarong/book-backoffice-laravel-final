@extends('../layouts.front-second')

@section('css')

<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery.Thailand.js/dist/jquery.Thailand.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-datetimepicker/css/yearpicker.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}" />
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

#img-upload{
    width: 100%;
}
.required-start:after {
    content:" *";
    color: red;
  }
</style>

@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}
                    
                </div>

                <div class="card-body">
                    <form id="theForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right required-start">{{ __('ID :') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right required-start">{{ __('รหัสผ่าน :') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right required-start">{{ __('ยืนยันรหัสผ่าน :') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right required-start">{{ __('ชื่อ-นามสกุล :') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alias" class="col-md-4 col-form-label text-md-right required-start">{{ __('นามปากกา :') }}</label>

                            <div class="col-md-6">
                                <input id="alias" type="text" class="form-control @error('alias') is-invalid @enderror" name="alias" value="{{ old('alias') }}" required autocomplete="alias" >

                                @error('alias')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="sid" class="col-md-4 col-form-label text-md-right required-start">{{ __('เลขบัตรประชาชน :') }}</label>

                            <div class="col-md-6">
                                <input id="sid" type="text" class="form-control @error('sid') is-invalid @enderror" name="sid" value="{{ old('sid') }}" required autocomplete="sid" >

                                @error('sid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="class_user" class="col-md-4 col-form-label text-md-right required-start">{{ __('ประเภทสมาชิก :') }}</label>

                            <div class="col-md-6">
                                <select name="class_user" id="class_user" class="form-control @error('class_user') is-invalid @enderror">
                                    <option value="user" @if(old('class_user') ==  'user') SELECTED @endif>สำหรับนักอ่าน</option>
                                    <option value="pub" @if(old('class_user') ==  'pub') SELECTED @endif>ฝากขาย (สำนักพิมพ์)</option>
                                    <option value="writer" @if(old('class_user') ==  'writer') SELECTED @endif>สำหรับนักเขียน</option>
                                    
                                </select>
                                @error('class_user')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right required-start">{{ __('เพศ :') }}</label>

                            <div class="col-md-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @if(old('sex') ==  'm') checked @endif type="radio" name="sex" id="sex_man" value="m" required >
                                <label class="form-check-label" for="sex_man">ชาย</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @if(old('sex') ==  'f') checked @endif type="radio" name="sex" id="sex_female" value="f">
                                <label class="form-check-label" for="sex_female">หญิง</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @if(old('sex') ==  'LGBT') checked @endif type="radio" name="sex" id="sex_LGBT" value="LGBT">
                                <label class="form-check-label" for="sex_LGBT">LGBT</label>
                            </div>
                             
                                @error('sex')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-4 col-form-label text-md-right required-start">{{ __('วันเกิด :') }}</label>

                            <div class="col-md-6">
                                <input id="birthday" type="text" class="form-control datepicker date @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') }}" required autocomplete="off">

                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        

                        <div class="form-group row">
                            <label for="address_full" class="col-md-4 col-form-label text-md-right">{{ __('ที่อยู่ :') }}</label>

                            <div class="col-md-6">
                                <textarea id="address_full" type="text" class="form-control @error('address_full') is-invalid @enderror" name="address_full" value="{{ old('address_full') }}" autocomplete="address_full" >{{ old('address_full') }}</textarea>

                                @error('address_full')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subdistric" class="col-md-4 col-form-label text-md-right">{{ __('ตำบล :') }}</label>

                            <div class="col-md-6">
                                <input id="subdistric" type="text" class="form-control @error('subdistric') is-invalid @enderror" name="subdistric" value="{{ old('subdistric') }}" autocomplete="subdistric" >

                                @error('subdistric')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="distric" class="col-md-4 col-form-label text-md-right">{{ __('อำเภอ :') }}</label>

                            <div class="col-md-6">
                                <input id="distric" type="text" class="form-control @error('distric') is-invalid @enderror" name="distric" value="{{ old('distric') }}" autocomplete="distric" >

                                @error('distric')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="province" class="col-md-4 col-form-label text-md-right">{{ __('จังหวัด :') }}</label>

                            <div class="col-md-6">
                                <input id="province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ old('province') }}" autocomplete="province" >

                                @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="zipcode" class="col-md-4 col-form-label text-md-right">{{ __('รหัสไปรษณีย์ :') }}</label>

                            <div class="col-md-6">
                                <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}" autocomplete="zipcode" >

                                @error('zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right required-start">{{ __('E-Mail :') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tel" class="col-md-4 col-form-label text-md-right required-start">{{ __('เบอร์โทรศัพท์ :') }}</label>

                            <div class="col-md-6">
                                <input id="tel" type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ old('tel') }}" required autocomplete="tel" >

                                @error('tel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div id="pub" style="@if(empty(old('class_user'))) display:none @else @if(old('class_user') == 'pub' || old('class_user') == 'writer') display:block @else display:none @endif @endif">
                            <hr>
                            
                            <center><font size="5" color="green">ข้อมูลรับเงิน	 ( กรุณากรอกข้อมูลที่เป็นจริง )</font></center>

                            <div class="form-group row">
                                <label for="bank_name" class="col-md-4 col-form-label text-md-right  required-start">{{ __('ธนาคาร :') }}</label>

                                <div class="col-md-6">
                                    <select name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                                    <option value="">-------------- เลือกธนาคาร --------------</option>
                                        @foreach($payments as $payment)       
                                            <option value="{{ $payment->id }}">{{ $payment->payment }}</option>
                                        @endforeach
                                    </select>
                                    @error('bank_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="bank_no" class="col-md-4 col-form-label text-md-right  required-start">{{ __('เลขที่บัญชี :') }}</label>

                                <div class="col-md-6">
                                    <input id="bank_no" type="text" class="form-control @error('bank_no') is-invalid @enderror" name="bank_no" value="{{ old('bank_no') }}" autocomplete="bank_no" >

                                    @error('bank_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bank_acc" class="col-md-4 col-form-label text-md-right  required-start">{{ __('ชื่อบัญชี :') }}</label>

                                <div class="col-md-6">
                                    <input id="bank_acc" type="text" class="form-control @error('bank_acc') is-invalid @enderror" name="bank_acc" value="{{ old('bank_acc') }}" autocomplete="bank_acc" >

                                    @error('bank_acc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bank_type" class="col-md-4 col-form-label text-md-right  required-start">{{ __('ประเภทบัญชี :') }}</label>

                                <div class="col-md-6">
                                    <select name="bank_type" id="bank_type" class="form-control @error('bank_type') is-invalid @enderror">
                                        <option value="1">ออมทรัพย์</option>
                                        <option value="2">ประจำ</option>
                                    </select>
                                    @error('bank_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bank_branch" class="col-md-4 col-form-label text-md-right required-start">{{ __('สาขา :') }}</label>

                                <div class="col-md-6">
                                    <input id="bank_branch" type="text" class="form-control @error('bank_branch') is-invalid @enderror" name="bank_branch" value="{{ old('bank_branch') }}" autocomplete="bank_branch" >

                                    @error('bank_branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="imgInp" class="col-md-4 col-form-label text-md-right required-start">{{ __('หน้า Book bank :') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group ">
                                        <input type="text" class="form-control @error('imgInp') is-invalid @enderror" readonly>
                                        <span class="input-group-btn">
                                            <span class="btn btn-outline-danger btn-file">
                                                Browse… <input type="file" id="imgInp" name="imgInp" accept="image/*">
                                            </span>
                                        </span>    
                                        @error('imgInp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror                                    
                                    </div>
                                    <img src="{{ asset('img/no_pic.png') }}" width="50" id='img-upload' alt="img" class="img-thumbnail"/>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





@section('js')

<!-- dependencies for zip mode -->
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/zip.js/zip.js') }}"></script>
<!-- / dependencies for zip mode -->

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/JQL.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dependencies/typeahead.bundle.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/jquery.Thailand.js/dist/jquery.Thailand.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/yearpicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

<script>
    $(function(){
        $.validator.addMethod("checkIDCard", function(value, element) {
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(value.charAt(i)) * (13 - i);
        if ((11 - sum % 11) % 10 != parseFloat(value.charAt(12))) return false;
        return true;
    }, 'รูปแบบบัตรประชาชนไม่ถูกต้อง!');


        $('.datepicker').datepicker({
            uiLibrary: 'bootstrap4' ,
            // dateFormat: 'yy-mm-dd' ,
            dateFormat: 'yy-mm-dd',
            // altFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-80:+0",
        });
        $('#class_user').on('change', function() {
            var x = document.getElementById("pub");
            // alert( this.value );
            if(this.value == "pub" || this.value == "writer"){             
                x.style.display = "block";
                $("#pub").css("color","red");
            }else{
                x.style.display = "none";
            }
        });
        $('#imgInp').on('change', function() {
            
        });
        
        $("#theForm").on('submit',(function(e) {
            $.LoadingOverlay("show");
        }));
    });
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

    $(document).on('change', '.btn-file :file', function() {
           
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
        // alert(input.val());
        if(!input.val()){
            $("#img-upload").attr("src","{{ asset('img/no_pic.png') }}");
        }
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
