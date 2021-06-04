@extends('../layouts.app')

@section('menu_member_menu_open' , 'menu-open')
@section('menu_member_menu_open_active' , 'active')
@section('menu_member' , 'active')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/magnific-popup/magnific-popup.css') }}" />
<style>
/* start state */
.mfp-zoom-out {
	/* animate in */
	/* animate out */
}
 .mfp-zoom-out .mfp-with-anim {
	 opacity: 0;
	 transition: all 0.3s ease-in-out;
	 transform: scale(1.3);
}
 .mfp-zoom-out.mfp-bg {
	 opacity: 0;
	 transition: all 0.3s ease-out;
}
 .mfp-zoom-out.mfp-ready .mfp-with-anim {
	 opacity: 1;
	 transform: scale(1);
}
 .mfp-zoom-out.mfp-ready.mfp-bg {
	 opacity: 0.8;
}
 .mfp-zoom-out.mfp-removing .mfp-with-anim {
	 transform: scale(1.3);
	 opacity: 0;
}
 .mfp-zoom-out.mfp-removing.mfp-bg {
	 opacity: 0;
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
                <li class="breadcrumb-item "><a href="{{ route('memberConsignment.index') }}">Members Consignment</a></li>
                <li class="breadcrumb-item active">Detail</li></ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <div class="justify-content-center py-4">
        <div class="" style="border: none">
            <div class="card ">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link nav-link-header  active"  href="{{ route('memberConsignment.index') }}"><strong class="span_vertical_active ">Register Consignment</strong></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body text-middle" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                    <div class="text-middle">
                        <table class="table text-left table-fixed" cellspacing="0" style="width:100% ">
                            <thead style="background-color:#ebeef3;color:#7F92A3; ">
                                <tr >
                                    <th scope="col" colspan="2" class="border_conner_left border_conner_right text-left" style="border-top: 0 solid #dee2e6;"><h3>ข้อมูลส่วนบุคคล</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr >
                                    <th scope="col" style="border-top: 0 solid #dee2e6;">ชื่อ - นามสกุล</th>
                                    <th scope="col" style="border-top: 0 solid #dee2e6;">{{ $user->name }}</th>
                                </tr>
                                <tr>
                                    <th scope="row">ประเภทสมาชิก ณ ปัจจุบัน {{$user->class_user}}</th>
                                    <th scope="row">@if($user->class_user == "user") สำหรับนักอ่าน @elseif($user->class_user == "pub") สำนักพิมพ์ฝากขาย @elseif($user->class_user == "writer") สำหรับนักเขียน @else Admin  @endif</th>
                                </tr>
                                <tr>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">{{ $user->email }}</th>
                                </tr>
                                <tr>
                                    <th scope="col">เบอร์โทรศัพท์</th>
                                    <th scope="col">{{ $user->tel }}</th>
                                </tr>
                                <tr>
                                    <th scope="col">เลขบัตรประชาชน</th>
                                    <th scope="col">{{ $user->sid }}</th>
                                </tr>
                                <tr>
                                    <th scope="col">เพศ</th>
                                    <th scope="col">{{ $user->sex }}</th>
                                </tr>
                                <tr>
                                    <th scope="col">วันเกิด</th>
                                    <th scope="col">{{ $user->birthday }}</th>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table text-left table-fixed" cellspacing="0" style="width:100% ">
                            <thead style="background-color:#ebeef3;color:#7F92A3; " >
                                <tr>
                                    <th scope="col" colspan="2" class="border_conner_left border_conner_right text-left" style="border-top: 0 solid #dee2e6;"><h3>ข้อมูลธนาคาร</h3></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="col" style="border-top: 0 solid #dee2e6;">ธนาคาร</th>
                                    <th scope="col" style="border-top: 0 solid #dee2e6;">{{ $user->getPayment->payment }}</th>
                                </tr>
                                <tr>
                                    <th scope="row">เลขที่บัญชี</th>
                                    <th scope="row">{{ $user->bank_no }}</th>
                                </tr>
                                <tr>
                                    <th scope="col">ชื่อบัญชี</th>
                                    <th scope="col">{{ $user->bank_acc }}</th>
                                </tr>
                                <tr>
                                    <th scope="col">ประเภทบัญชี</th>
                                    <th scope="col">@if($user->bank_type == '1') ออมทรัพย์ @else ประจำ @endif</th>
                                </tr>
                                <tr>
                                    <th scope="col">ประเภทบัญชี</th>
                                    <th scope="col">{{ $user->bank_branch }}</th>
                                </tr>
                                <tr>
                                    <th scope="col">หน้า Book bank</th>
                                    <th scope="col">
                                        {{ $user->bank_file }}
                                        <div style="display: inline;" class="link_image_popups">
                                            <a href="{{ url('storage/book-bank-images/'.$user->bank_file) }}" class="btn btn-danger p-2 image_popup_link rcorners2 hvr-grow shadow1" data-effect="mfp-zoom-out" style="width: 50px" ><i class="fas fa-expand-arrows-alt"></i></a>                                                      
                                        </div>
                                        
                                    </th>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right" style="background-color: white;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);">
                        
                        <button type="button" data-id="{{$user->id}}" class="btn btn-success-custom ml-2 approveBtn">อนุมัติสถานะ @if($user->class_user == "user") สำหรับนักอ่าน @elseif($user->class_user == "pub") สำนักพิมพ์ฝากขาย @elseif($user->class_user == "writer") สำหรับนักเขียน @else Admin  @endif </button>
                        <button type="button" data-id="{{$user->id}}" class="btn btn-paid-sendback ml-2 mr-4 rejectBtn" >ไม่อนุมัติ</button>
                </div>
            </div>
            
            
        </div>
    </div>

</div>
<!-- /.content-wrapper -->



@endsection

@section('js')
<script type="text/javascript" src="{{ asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script>
$(function() {
    var table, Item_id , Value = null;

    
    $('body').on('click', '.approveBtn', function() {
        Item_id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันอนุมัติ?',
            text: "คุณตรวจสอบและยืนยันการทำรายการนี้",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2DC8A8',
            cancelButtonColor: 'dark',
            confirmButtonText: 'ยืนยัน' ,
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:'POST',
                    url:"{{ url('admin/memberConsignment') }}"+"/"+Item_id,
                    data:{_token: "{{ csrf_token() }}", _method: 'PUT',value:"approved"},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'ทำรายการสำเร็จ',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                timer: 1500,
                            }).then((result) =>{
                                    window.history.back();
                            });
                        } else {
                            console.log(response.error);
                        }
                    }
                });   
            }
        });
         
    });
    $('body').on('click', '.rejectBtn', function() {
        Item_id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันไม่อนุมัติ?',
            text: "คุณตรวจสอบและยืนยันการทำรายการนี้",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2DC8A8',
            cancelButtonColor: 'dark',
            confirmButtonText: 'ยืนยัน' ,
            cancelButtonText: 'ปิด'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:'POST',
                    url:"{{ url('admin/memberConsignment') }}"+"/"+Item_id,
                    data:{_token: "{{ csrf_token() }}", _method: 'PUT',value:"reject"},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'ทำรายการสำเร็จ',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                timer: 1500,
                            }).then((result) =>{
                                    window.history.back();
                            });
                        } else {
                            console.log(response.error);
                        }
                    }
                });    
            }
        });
        
    });
    

    $('.link_image_popups').magnificPopup({
            delegate: 'a',
            type: 'image',
            removalDelay: 500, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function() {
                // just a hack that adds mfp-anim class to markup 
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeOnContentClick: true,
            midClick: true 
        });

});
</script>
@endsection
