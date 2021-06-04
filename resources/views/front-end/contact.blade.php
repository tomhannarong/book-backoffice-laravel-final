@extends('../layouts.front')

@section('menu_contact' , 'active')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

  <!-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
  


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
a.disabled {
  pointer-events: none;
  cursor: default;
}
.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}
</style>
@endsection



@section('content')
<section>
    <div class="container">
        <div class="row justify-content-center p-3">
            <div class="col-md-12">
                <div class="card" style="border: 2px solid DarkBlue;">
                    <div class="card-header linear-2" style="background-color:LightCyan;border-bottom: 2px solid DarkBlue;">
                            <h3 class="card-title"><font color="White" style="text-shadow: 0 0 0.5em DeepSkyBlue">ติดต่อเรา</font></h3>
                            
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                        
                            <div class="pt-2 pb-2" style="background-color:rgba(81, 120, 255, .1);border: 2px solid Purple;">
                                <div style="text-align: center;"><span style="color: #cc0000; font-size: xx-large;"><strong>&nbsp;อีเมล&nbsp;<em>lightoflove2009@hotmail.com
                                </em></strong></span></div>
                                <div style="text-align: center;"><strong style="color: #cc0000;"><span style="font-size: large;">สำนักงาน-โทรสาร 02-171-6636</span></strong></div>
                                <div style="text-align: center;"><span style="color: #cc0000; font-size: large;"><strong>มือถือ&nbsp;</strong></span><strong style="color: #cc0000; font-size: large;">087-978-4527, 064-690-1784&nbsp;</strong><strong style="color: #cc0000; font-size: large;">, 087-039-0707&nbsp;</strong></div>
                                <div style="text-align: center;"><strong style="font-size: large;"><span style="color: #330066;">&nbsp;</span></strong></div>
                                <div style="text-align: center;"><strong style="font-size: large;"><span style="color: #330066;">เพื่อความสะดวกในการติดต่อ</span></strong></div>
                                <div style="text-align: center;"><strong style="font-size: large;"><span style="color: #330066;">สำนักพิมพ์เปิดทำการวันจันทร์-ศุกร์ เวลา 9.00-17.00 น.</span></strong></div>
                                <div style="text-align: center;"><span style="color: #330066;"><strong style="font-size: large;">วันเสาร์-วันอาทิตย์ และวันหยุด</strong><span style="font-size: large;"><strong>นักขัตฤกษ์ (หยุดทำการ)</strong></span></span></div>
                            </div>
                        @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success mt-2">
                                <ul>                                    
                                    <li>{{ $message }}</li>                                    
                                </ul>                             
                            </div>
                        @endif
                            <form id="theForm" method="post" action="{{ url('contact') }}" >
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="topic">เรื่อง : </label>
                                        <input type="text" class="form-control" id="topic" name="topic" 
                                            placeholder="Enter topic" value="{{ old('topic') }}">

                                    </div>
                                    <div class="form-group">
                                        <label for="name">ชื่อ - สกุล : </label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                            placeholder="Enter name" autocomplete="off" value="{{ old('name') }}">

                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-Mail : </label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                            placeholder="Enter email" autocomplete="off" value="{{ old('email') }}">

                                    </div>
                                    <div class="form-group">
                                        <label for="phone">เบอร์โทร : </label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Enter phone" autocomplete="off" value="{{ old('phone') }}">

                                    </div>
                                    <div class="form-group">
                                        <label for="detail">ข้อความถึงเรา : </label>
                                        <textarea class="form-control" id="detail" name="detail" rows="5" cols="50" 
                                        placeholder="Enter message" >{{ old('detail') }}</textarea>

                                    </div>
                                    <div class="form-group">                        
                                        <div class="captcha">
                                        <label for="detail">กรอกตัวเลขให้ถูกต้อง :    </label>
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-danger" class="reload" id="reload">
                                                &#x21bb;
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">                                     
                                        <input id="captcha" type="text" class="form-control" placeholder="Enter Code" name="captcha" autocomplete="off">
                                    </div>
                          
                                </div>
                                <div class="modal-footer ">
                                  
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </div>
                            </form>
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
        $("#theForm").on('submit',(function(e) {
            $.LoadingOverlay("show");
        }));
    });
$(function(){
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: "{{ url('reload-captcha') }}",
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
});
// end jquery
    
</script>
@endsection
