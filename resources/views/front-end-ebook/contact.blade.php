@extends('../layouts.front-ebook')

@section('menu_contact_ebook' , 'active_nav')

@section('css')

<style>

</style>
@endsection



@section('content')
<section>
    <div class="py-4">
        <center>
            <h1>
            <strong>
            Contact
            </strong><br/>
            </h1>
        </center>
    </div>
    <div class="container">
        <div class=" justify-content-center p-3">
            <div class="">
                <div class="card" style="border-left: 0;border-right: 0;" >
                    {{-- <div class="card-header" >
                            <h3 class="card-title"><font color="black" >ติดต่อเรา</font></h3>
                            
                    </div> --}}
                    <div class="card-body ">
                        <div class="">
                        
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
                                <div class="modal-body row">
                                    <div class="form-group col-md-6">
                                        <label for="topic">เรื่อง : </label>
                                        <input type="text" class="form-control" id="topic" name="topic" 
                                            placeholder="Enter topic">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name">ชื่อ - สกุล : </label>
                                        <input type="text" class="form-control" id="name" name="name" 
                                            placeholder="Enter name" autocomplete="off">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">E-Mail : </label>
                                        <input type="email" class="form-control" id="email" name="email" 
                                            placeholder="Enter email" autocomplete="off">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">เบอร์โทร : </label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Enter phone" autocomplete="off">

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="detail">ข้อความถึงเรา : </label>
                                        <textarea class="form-control" id="detail" name="detail" rows="5" cols="50" placeholder="Enter message"></textarea>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">                        
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
                                        <button type="submit" style="float: right" class="btn btn-primary">บันทึก</button>
                                    </div>
                          
                                </div>
                                {{-- <div class="modal-footer ">
                                  
                                    
                                </div> --}}
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
