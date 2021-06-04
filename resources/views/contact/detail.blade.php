@extends('../layouts.app')

@section('menu_contact' , 'active')

@section('css')
<style>
tr.border_bottom td {
  border-bottom: 2px solid LightSkyBlue;
}
.centerAligned{
    text-align: center;
    margin-top: 50%;
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
                <li class="breadcrumb-item "><a href="{{ url('admin/contact') }}">Contact</a>
                <li class="breadcrumb-item active">Detail</ol>
            </div>
        </div>
        

      </div><!-- /.container-fluid -->
    </section>

<div class="justify-content-center py-4">
    <div class="row" style="margin-right: 0">
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs ">
                        <li class="nav-item" >
                            <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                <strong class="span_vertical_active">
                                    ข้อมูลการติดต่อ 
                                </strong>  
                                
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body ">               
                    <div class="row">
                        <div class="col-12">
                            <table  class="table text-left table-fixed" cellspacing="0" style="width:100% ">
                                
                                <tbody>
                                    <tr>
                                        <th scope="col"><b>เรื่อง : </b></th>
                                        <th scope="col">{{ $contact_us->topic }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="row"><b>ชื่อ - สกุล : </b></th>
                                        <th scope="row">{{ $contact_us->name }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col"><b>อีเมล์ : </b></th>
                                        <th scope="col">{{ $contact_us->email }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col"><b>เบอร์โทร : </b></th>
                                        <th scope="col">{{ $contact_us->tel }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col"><b>ข้อความ : </b></th>
                                        <th scope="col">{{ $contact_us->message }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col"><b>เปิดอ่านแล้วหรือยัง : </b></th>
                                        <th scope="col">
                                            @if($contact_us->read == "true")
                                                <h4><span class="badge badge-dark">เปิดอ่านแล้ว</span></h4>
                                            @elseif($contact_us->read == "false")
                                                <h4><span class="badge badge-success">ยังไม่เคยเปิดอ่าน</span></h4>
                                            @endif
                                        </th>
                                    </tr>
                                    
                                </tbody>
                            </table>

                            
                            <!-- $message="";
            $message=$message."<font color=\"#ffa14d\">ชื่อ - สกุล : </font>".$name."<br>";
            $message=$message."<font color=\"#ffa14d\">E-Mail : </font>".$email."<br>";
            $message=$message."<font color=\"#ffa14d\">หมายเลขโทรศัพท์ : </font>".$tel."<br>";
            $message=$message."<font color=\"#ffa14d\">รายละเอียดการติดต่อ : </font>".$detail."<br>";

                $header = "From: noreply@lightoflovebookgroup.com\r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-Type: text/html; charset=utf-8\n"; // Mime type

            if (mail($reciever_email, $subject, $message, $header)){	                                   -->
                        </div>
                        
                    </div>                                   
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <ul class="nav nav-tabs card-header-tabs ">
                        <li class="nav-item" >
                            <a class="nav-link nav-link-header active nav-item-left" href="javascript:void(0)">
                                <strong class="span_vertical_active">
                                    Send E-mail 
                                </strong>  
                                
                            </a>
                        </li>
                    </ul>
                </div>           
                <div class="card-body ">               
                    <div class="row">
                            
                        <div class="col-12"> 
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success test-center">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif                         
                            <form id="theForm" method="post" action="{{ url('admin/sendEmail') }}">
                                {{ csrf_field() }}
                                <div class="modal-body">                                
                                    <div class="form-group">
                                        <label for="detail">ข้อความถึงผู้ส่ง : </label>
                                        <textarea class="form-control" id="detail" name="detail" rows="5" cols="50" placeholder="Enter message"></textarea>

                                    </div>
                                </div> 
                                <input type="hidden" name="id" id="id" value="{{ $contact_us->id }}">  
                                <input type="hidden" name="topic" id="topic" value="{{ $contact_us->topic }}">  
                                <input type="hidden" name="email" id="email" value="{{ $contact_us->email }}">   
                                <input type="hidden" name="name" id="name" value="{{ $contact_us->name }}">  
                                <input type="hidden" name="message" id="message" value="{{ $contact_us->message }}">                  
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light btn-default-custom" onclick="return window.history.back();">ยกเลิก</button>
                                    <button type="submit" class="btn btn-success-custom">ส่ง</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>                                   
                </div>
            </div>
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
        $("#theForm").on('submit',(function(e) {
            $.LoadingOverlay("show");
        }));
    });
$(function() {
    var theForm = $("#theForm");
    var table, Item_id = null;

    //datatableFilter()
    $('body').on('click', '.viewBtn', function() {
        Item_id = $(this).data('id');
        window.location = "{{ url('admin/contact')}}" + '/' + Item_id ;
    });

    $('body').on('click', '.deleteBtn', function() {
        Item_id = $(this).data("id");
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: theForm.attr('action') + '/' + Item_id,
                    data:{ _method: 'DELETE' },
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then((result) => table.ajax.reload(null, false));
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
            }
        });
    });


});

</script>
@endsection
