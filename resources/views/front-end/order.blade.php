@extends('../layouts.front')

@section('menu_order' , 'active')

@section('css')
 <!-- Latest compiled and minified CSS -->
 {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}

<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

  <!-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
  
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"> --}}
<link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
<link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'>


<style>
.btn-file  {
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

#img-upload {
    width: 100%;
}

a.disabled {
  pointer-events: none;
  cursor: default;
}
.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}

.filepond--drop-label {
  color: #4c4e53;
}

.filepond--label-action {
  -webkit-text-decoration-color: #babdc0;
          text-decoration-color: #babdc0;
}

.filepond--panel-root {
  border-radius: 2em;
  background-color: #edf0f4;
  height: 1em;
}

.filepond--item-panel {
  background-color: #595e68;
}

.filepond--drip-blob {
  background-color: #7f8a9a;
}



.img-div {
    position: relative;
    width: 46%;
    /* width: 100%; */
    float:left;
    margin-right:5px;
    margin-left:5px;
    margin-bottom:10px;
    margin-top:10px;
}

.image {
    opacity: 1;
    display: block;
    width: 100%;
    max-width: auto;
    transition: .5s ease;
    backface-visibility: hidden;
}

.middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
}

.img-div:hover .image {
    opacity: 0.3;
}

.img-div:hover .middle {
    opacity: 1;
}

.tooltip {
  display: inline;
  position: relative;
}
.tooltip:hover:after{
  display: -webkit-flex;
  display: flex;
  -webkit-justify-content: center;
  justify-content: center;
  background: #444;
  border-radius: 8px;
  color: #fff;
  content: attr(title);
  margin: -82px auto 0;
  font-size: 16px;
  padding: 13px;
  width: 220px;
}
.tooltip:hover:before{
  border: solid;
  border-color: #444 transparent;
  border-width: 12px 6px 0 6px;
  content: "";
  left: 45%;
  bottom: 30px;
  position: absolute;
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
                            <h3 class="card-title"><font color="White" style="text-shadow: 0 0 0.5em DeepSkyBlue">รายการสั่งซื้อสินค้า</font></h3>
                    </div>
                    
                    <div class="card-body ">
                        
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-fixed " style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>เลขที่ใบสั่งซื้อ</th>
                                    <th>วันที่</th>
                                    <th>สถานะ</th>
                                    <th>ราคา</th>
                                    <th>หมายเลขพัสดู</th>
                                    <th width="25%">Action</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="theModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แจ้งชำระเงิน</h5>
                        <button type="button" class="close btn btn-danger " data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="theForm" >
                        {{-- enctype="multipart/form-data" --}}
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="account_tranfer">เลขที่ใบสั่งซื้อ : </label>
                                <input type="text" class="form-control" id="account_tranfer" name="account_tranfer" aria-describedby="account_tranfer"
                                    placeholder="Enter order number" readonly>

                            </div>
                            <div class="form-group">
                                <label for="tranfer_date">วันที่ : </label>
                                <input type="text" class="form-control datepicker date" id="tranfer_date" name="tranfer_date" aria-describedby="tranfer_date"
                                    placeholder="Enter date" autocomplete="off">

                            </div>
                            <div class="form-group">
                                <label for="tranfer_time">เวลา : </label>
                                <input type="text" class="form-control timepicker" id="tranfer_time" name="tranfer_time" aria-describedby="tranfer_time"
                                    placeholder="Enter time" autocomplete="off">

                            </div>
                            <div class="form-group">
                                <label for="amount">จำนวนเงิน : </label>
                                <input type="number" class="form-control" id="amount" name="amount" aria-describedby="amount"
                                    placeholder="Enter amount" autocomplete="off">

                            </div>
                            <div class="form-group">
                                <label for="name">โอนมายังธนาคาร : </label>
                                <select class="form-control " name="bank_tranfer" id="bank_tranfer">	
                                        <option value="">----- เลือกธนาคาร -----</option>
                                        @foreach ($payments as $payment)
                                            <option value="{{ $payment->payment }}">{{ $payment->payment }}</option>
                                        @endforeach
                                </select>
                            </div>

                            {{-- <input type="file" 
                                class="filepond" 
                                name="imgInp[]"
                                id="imgInp" 
                                multiple 
                                data-allow-image-edit="false" 
                                data-max-file-size="5MB" 
                                data-max-files="3" /> --}}

                                {{-- <input type="file" id="imgInp" name="imgInp" class="filepond"  data-allow-image-edit="false"  data-max-file-size="5MB" 
                                data-max-files="3" data-allow-reorder="true" multiple>
        --}}

                        <div class="form-group">
                            {{-- <label for="images">Images</label> --}}
                        
                            <label>Upload Slip</label>
                            <div class="input-group ">
                                <span class="input-group-btn ">
                                    <span class="btn btn-outline-danger btn-file">
                                        Browse… <input type="file" name="images[]" id="images" multiple class="form-control " required>
                                    </span>
                                </span>
                                <input type="text" class="form-control text-empty" readonly >
                                <div id="image_preview" style="width:100%;">
                                
                                </div>
                            </div>
                            
                            
                        </div>
                        
                        

                            
                            {{-- <div class="form-group mt-2">
                                <label>Upload Image</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-outline-success btn-file">
                                            Browse… <input type="file" id="imgInp" name="imgInp" multiple>
                                        </span>
                                    </span>
                                    <input type="text" class="form-control" readonly >
                                </div>

                            </div>
                            <img src="{{ asset('img/no_pic.png') }}" width="250" height="300" id='img-upload' alt="img" class="img-thumbnail"/> --}}
                            <input type="hidden" name="username" id="username" value="{{ $user->username }}">
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection



@section('js')
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> 

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

{{-- <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
<script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
<script src='https://unpkg.com/filepond/dist/filepond.min.js'></script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script> --}}

 

  <!-- jQuery library -->
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
 

<script>

$(document).ready(function() {
  var fileArr = [];

//   $('[data-toggle="tooltip"]').tooltip()
 $('[data-toggle="popover"]').popover();


   $("#images").change(function(){
      // check if fileArr length is greater than 0
       if (fileArr.length > 0) fileArr = [];
     
        $('#image_preview').html("");
        var total_file = document.getElementById("images").files;
        if (!total_file.length) return;
        for (var i = 0; i < total_file.length; i++) {
          if (total_file[i].size > 1048576) {
            return false;
          } else {
            fileArr.push(total_file[i]);
            $('#image_preview').append("<div class='img-div' id='img-div"+i+"'><img src='"+URL.createObjectURL(event.target.files[i])+"' class='img-responsive image img-thumbnail' title='"+total_file[i].name+"'><div class='middle'><button id='action-icon' value='img-div"+i+"' class='btn btn-danger' role='"+total_file[i].name+"'><i class='fa fa-trash'></i></button></div></div>");
          }
        }
   });
  
   

  $('body').on('click', '#action-icon', function(evt){
      var divName = this.value;
      var fileName = $(this).attr('role');
      $(`#${divName}`).remove();
    
    
      for (var i = 0; i < fileArr.length; i++) {
        if (fileArr[i].name === fileName) {
          fileArr.splice(i, 1);
        //   file_name += fileArr[i].name + ',' ;
        // console.log(fileArr[i].name);
        }
      }
      var file_name_new = '';
      for (var i = 0; i < fileArr.length; i++) {
        file_name_new += fileArr[i].name + ',' ;
      }
      $('.text-empty').val(file_name_new);
      console.log(file_name_new);
    //   alert(FileListItem(fileArr));
    document.getElementById('images').files = FileListItem(fileArr);
      evt.preventDefault();
  });
  
   function FileListItem(file) {
            file = [].slice.call(Array.isArray(file) ? file : arguments)
            for (var c, b = c = file.length, d = !0; b-- && d;) d = file[b] instanceof File
            if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
            for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(file[c])
            return b.files
        }
});
$(function(){
//     FilePond.registerPlugin(
	
// 	// encodes the file as base64 data
//   FilePondPluginFileEncode,
	
// 	// validates the size of the file
// 	FilePondPluginFileValidateSize,
	
// 	// corrects mobile image orientation
// 	FilePondPluginImageExifOrientation,
	
// 	// previews dropped images
//   FilePondPluginImagePreview
//     );

// // Select the file input and use create() to turn it into a pond
// var filePond = FilePond.create(
// 	document.querySelector('.filepond')
// );
//         var element = document.querySelector('meta[name="csrf-token"]');
//         var csrf = element && element.getAttribute("content");
//           FilePond.setOptions({
//             server: {
//                   url: "{{ url('order')}}",
//                   process: {
//                       headers: {
//                         'X-CSRF-TOKEN': csrf 
//                       },
//                   }
//               }
//           });


    //show()
    datatableFilter();
    // $( window ).on( "load", function() {
    //     $('[data-toggle="tooltip"]').tooltip()
    // });
    
    
    var table , Item_id ,tranfer_id , url = null ;
    var theForm = $("#theForm");
    if (theForm.length > 0) {
        theForm.validate({
            rules: {
                account_tranfer: {
                    required: true,
                },
                tranfer_date: {
                    required: true,
                },
                tranfer_time: {
                    required: true,
                },
                amount: {
                    required: true,
                },
                bank_tranfer: {
                    required: true,
                },
                images: {
                    required: true,
                    extension: "jpeg|png|jpg|gif|svg"
                },
            },
            messages: {
                account_tranfer: {
                    required: "Please enter order number",
                },
                tranfer_date: {
                    required: "Please enter date",
                },
                tranfer_time: {
                    required: "Please enter time",
                },
                amount: {
                    required: "Please enter amount",
                },
                bank_tranfer: {
                    required: "Please enter bank",
                },
                images: {
                    images: "Please enter image",
                    extension: "Please choose file jpeg,png,jpg,gif,svg only"
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
        });
    }

    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4' ,
        dateFormat: 'yy-mm-dd' ,
    });
    $('.timepicker').datetimepicker({
        format: 'HH:mm',
        icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'far fa-times-circle'
                }
    });
    
  
    $("#theForm").on('submit',(function(e) {
        e.preventDefault();
        
        if ($("#theForm").valid()) {
            $.LoadingOverlay("show");
            
            $.ajax({
                tranfer_id , 
            
                url: url,
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
                            title: 'แจ้งชำระเงินสำเร็จแล้วค่ะ',
                            showConfirmButton: false,
                            timer: 800,
                        }).then((result) =>{
                            //window.history.back();
                            //location.reload();
                            $('#theModal').modal('hide');
                            theForm.trigger("reset");
                            
                            // $('#img-upload').attr("src", "{{asset('img/no_pic.png')}}");
                            $('#username').val("{{ $user->username }}")
                            table.ajax.reload(null, false);
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

    $('body').on('click', '.pay-in-btn', function() {
        Item_id = $(this).data('id');
        var price = $(this).data('price');
        $("#account_tranfer").val(Item_id);
        $("#amount").val(price);
        $("#tranfer_date").val("{{Carbon\Carbon::now()->toDateString()}}");
        $("#tranfer_time").val("{{Carbon\Carbon::now()->toTimeString()}}");
        $("#images").val(''); 
        $(".text-empty").val(''); 
        $("#image_preview").html(''); 
        tranfer_id = $(this).data('tranfer-id') ?? '';
        if(tranfer_id){
            $('#_method').val('PUT')
            tranfer_id , 
            url = "{{ url('order') }}/"+tranfer_id ;
        }else{
            $('#_method').val('POST');
            url = "{{ url('order') }}" ;
        } 
        
        

        // if (filePond.getFiles().length != 0) {
        //     for (var i = 0; i <= filePond.getFiles().length - 1; i++) {
        //         filePond.removeFile(filePond.getFiles()[0].id)
        //     }
        // }
        $('#theModal').modal('show');
    });

    $('body').on('click', '.detailBtn', function() {
        Item_id = $(this).data('id');
        window.location = "{{ url('order') }}"+"/"+Item_id;
    });

    $('body').on('click', '.deleteBtn', function() {
        Item_id = $(this).data("id");
        Swal.fire({
            title: 'ยืนยันการยกเลิก?',
            text: "คุณต้องการยกเลิกรายการสั่งซื้อ!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('order') }}" + '/' + Item_id,
                    data:{_method: 'DELETE'},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire(
                                'ยกเลิก!',
                                'ยกเลิกเรียบร้อยแล้วค่ะ.',
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

    function datatableFilter() {
        table = $("#example").DataTable({
            lengthChange: true,
            iDisplayLength: 10,
            bFilter: true,
            // destroy: true,
            // searching: false,
            //dom: 'Bfrtip',
            "aaSorting": [],
            pagingType: "full_numbers",
            // buttons: [{
            //         text: 'Add Publisher',
            //         className: 'btn btn-lg btn-success',
            //         action: function(e, dt, node, config) {
            //             // $('.modal-header').removeClass("bg-warning text-black");
            //             // $('.modal-title').html("Add Item");
            //             // $('.modal-header').addClass("bg-success text-white");
            //             // theForm.attr("typeForm", "add");
            //             // theForm.trigger("reset");
            //             // $('#theModal').modal('show');
            //         }
            //     }
            // ],
            language: {
                lengthMenu: "แสดงข้อมูล _MENU_ ข้อมูล",
                zeroRecords: "ไม่มีข้อมูล",
                info: "แสดงข้อมูลตั้งแต่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล",
                infoEmpty: "ไม่มีข้อมูลที่แสดงอยู่",
                infoFiltered: "(filtered from _MAX_ total records)",
                search: "ค้นหา:",
                loadingRecords: "กำลังโหลด...",
                //processing: "กำลังประมวลผล...",
                //processing: '<i class="fas fa-spinner fa-spin fa-3x fa-fw"></i>',
                processing: '<i class=" fa fa-spinner fa-spin fa-3x fa-fw " style="font-size:60px;color:red;"></i>',
                paginate: {
                    first: "หน้าแรก",
                    last: "หน้าสุดท้าย",
                    next: "ต่อไป",
                    previous: "ย้อนกลับ",
                },
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('order') }}",
                type: 'GET',
                
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: (data) => data.id ? data.id : "-",
                    name: 'id'
                },
                {
                    data: (data) => {
                        if(data.order_date || data.order_time)
                       return data.order_date + ' [ '+data.order_time+' ] ';
                       else return '-';
                    },
                    name: 'order_date'
                },
                {
                    data: 'order_status',
                    name: 'order_status',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: (data) => {
                        return (Number(data.net_price)+Number(data.transport_rate)).toFixed(2);
                    },
                    name: 'net_price'
                },
                {
                    data: (data) => data.tracking_number ? data.tracking_number : "-",
                    name: 'tracking_number'
                },
                {
                    data: 'action',
                    name: 'action',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
            ],
            fnDrawCallback: function(oSettings) {
                $('[data-toggle="popover"]').popover();
            },
            // initComplete: function() {
            //     // table.buttons().container()
            //     //     .appendTo($('.col-md-6:eq(0)', table.table()
            //     //         .container())); //show button on datatable
            //     // // table.buttons().container()
            //     // // .appendTo( table.table().container()  ); //show button on datatable
            //     // new $.fn.dataTable.FixedHeader(table);
            // },
        });
    }
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
