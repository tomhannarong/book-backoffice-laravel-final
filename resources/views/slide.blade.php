@extends('../layouts.app')

@section('menu_slide' , 'active')

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

/* #img-upload{
    width: 100%;
} */
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
                <li class="breadcrumb-item active">Slide</ol>
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
                                Slide 
                            </strong>  
                            
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body text-middle">
                <div class="text-middle">
                    <table id="example" class="table text-left table-fixed" cellspacing="0" style="width:100% ">
                    <thead class="" style="background-color:#ebeef3;color:#7F92A3">
                        <tr>
                            <th width="5%" class="border_conner_left text-left">Position</th>
                            <th>??????????????????</th>
                            <th>?????????????????????????????????????????????</th>
                            <th width="10%">??????????????????????</th>
                            <th width="20%" class="border_conner_right">Action</th>
                        </tr>
                    </thead>

                    
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="theModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-container">
                <div class="modal-header mb-4">
                    <h5 class="modal-title"><font class="pl-2 " id="exampleModalLabel"></font></h5>
                    <a href="javascript:void(0)" class="close" data-dismiss="modal"><img src="{{ url('img/icon_pages/close_popup.png') }}"></a>
                </div>
                <form id="theForm" action="{{ url('admin/slide') }}" method="POST" typeForm="">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">????????????????????????</label>
                            <input type="number" class="form-control btn_rounded" min="0" step="1" id="position" name="position" aria-describedby="position"
                                placeholder="????????????????????????">
                                

                        </div>
                        <div class="form-group">
                            <label for="name">?????????????????????????????????????????????</label>
                            <input type="text" class="form-control btn_rounded" id="slide_name" name="slide_name" aria-describedby="slide_name"
                                placeholder="?????????????????????????????????????????????">
                                

                        </div>
                        <div   div class="form-group mt-2">
                            <label>???????????????????????????????????????</label>
                            <div class="input-group">
                                <input id="image_silde_text" type="text" class="form-control btn_rounded" readonly >
                                <span class="input-group-btn">
                                    <span class="btn btn-outline-success btn-file">
                                        Browse??? <input type="file" id="imgInp" name="imgInp">
                                    </span>
                                </span>
                                
                            </div>

                        </div>
                        <img src="{{ asset('img/no_pic.png') }}" width="250" height="300" id='img-upload' alt="img" class="img-thumbnail"/>
                        <input name="_method" id="_method" type="hidden" value="POST">
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-light btn-default-custom" data-dismiss="modal">??????????????????</button>
                        <button type="submit" class="btn btn-success-custom">??????????????????</button>
                    </div>
                </form>
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
$(function() {
    var theForm = $("#theForm");
    var table, Item_id = null;

    datatableFilter();

    if (theForm.length > 0) {
        theForm.validate({
            rules: {
                slide_name: {
                    required: true,
                },
                
                // imgInp: {
                //     required: true,
                // },
            },
            messages: {
                name: {
                    required: "Please enter name image",
                },
                // imgInp: {
                //     required: "Please enter image slide",
                // },
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
    

    $("#theForm").on('submit',(function(e) {
        e.preventDefault();
        
                var url = theForm.attr('action');
                var type = theForm.attr('method');
                var title = "Cannot add new records.";
                $('#_method').val('POST');
                if (theForm.attr("typeForm") === "update") {
                    $('#_method').val('PUT');
                    url += '/' + Item_id;
                    type = "POST";
                    title = "Cannot update records.";
                }
    
        if ($("#theForm").valid()) {
            $.LoadingOverlay("show");
            //alert("123");
            $.ajax({
                url: url,
                type: type,
                data:  new FormData(this),
                cache:false,
                processData: false,
                contentType: false,
                success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            $.LoadingOverlay("hide");
                            theForm.trigger("reset");
                            $('#theModal').modal('hide');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: '??????????????????????????????????????????',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                timer: 1500,
                            }).then((result) => table.ajax.reload(null, false));
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
                    }
            });
        }
    }));
    $('body').on('click', '.isCheckPublic', function() {
        Item_id = $(this).data("id");
        Value = $(this).data("value");
        //alert(Value);
        if(Value === "on"){
            Value = "n";
            // $("h1").addClass("page-header highlight");
            // $("h1").removeClass("page-header");
            // $(selector).html()
        }else if (Value === "off"){
            Value = "y";
        }

        $.ajax({
           type:'POST',
           url:"{{ url('admin/slide') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , status:Value , fn: "public" },
           success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '??????????????????????????????????????????',
                        showConfirmButton: false,
                        iconColor: '#ffffffff',
                        timer: 1500,
                    }).then((result) => {
                        //table.ajax.reload(null, false);
                        table.clear().destroy();
                        
                        datatableFilter();
                    });
                } else {
                    console.log(response.error);
                }
            }
        });
    });

    $('body').on('click', '.editBtn', function() {
        Item_id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: theForm.attr('action') + '/' + Item_id + '/edit',
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    // $('.modal-header').removeClass("bg-success text-white");
                    $('.modal-title').html("????????????????????????????????????????????????");
                    // $('.modal-header').addClass("bg-warning text-black");
                    $(".error").html('');

                    $(".is-invalid").removeClass("is-invalid");

                    $(".error").removeClass("error");
                    theForm.attr("typeForm", "update");
                    $('#slide_name').val(response.slide_name);
                    // $('#imgInp').val(response.slide_images);
                    $('#position').val(response.position);
                    $('#image_silde_text').val(response.slide_images);
                    
                            var path = "{{ asset('storage/slide-images') }}/"+response.slide_images ;
                           var html = '<img src="'+path+'" width="70">';
                    $('#img-upload').attr('src',path);
                    $('#theModal').modal('show');
                } else {
                    console.log(response.error);
                    Swal.fire({
                        icon: 'error',
                        title: "Error edit record.",
                        text: "ERROR: " + response.error,
                    });
                }
            },
            error: (response) => {
                console.log('Error:', response);
                Swal.fire({
                    icon: 'error',
                    title: "<strong>Error edit record.</strong>",
                    html: "<strong>Error Code: </strong>" + response.status +
                        "<p><strong>Message: </strong>" + JSON.stringify(response
                            .responseJSON.message) + "</p>",
                });
            }
        });
    });

    $('body').on('click', '.deleteBtn', function() {
        Item_id = $(this).data("id");
        Swal.fire({
            title: '???????',
                text: "???????????????????????????????????????????????????????????????????????????????????????????????????",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2DC8A8',
                cancelButtonColor: 'dark',
                confirmButtonText: '??????????????????' ,
                cancelButtonText: '?????????'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: theForm.attr('action') + '/' + Item_id,
                    data:{_method: 'DELETE'},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: '??????????????????????????????????????????',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                timer: 1500,
                            }).then((result) => table.ajax.reload(null, false));
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
            // lengthChange: true,
            // iDisplayLength: 10,
            // bFilter: true,
            // destroy: true,
            // searching: false,
            //dom: 'Bfrtip',
            "aaSorting": [],
            buttons: [{
                    text: '????????????????????????????????????????????????',
                    className: 'btn btn-lg btn-success-custom',
                    action: function(e, dt, node, config) {
                        // $('.modal-header').removeClass("bg-warning text-black");
                        $('.modal-title').html("????????????????????????????????????????????????");
                        // $('.modal-header').addClass("bg-success text-white");
                        theForm.attr("typeForm", "add");
                        theForm.trigger("reset");

                           var path = "{{ asset('img/no_pic.png') }}" ;
                           var html = '<img src="'+path+'" width="70">';
                        $('#img-upload').attr('src',path);
                        $('#theModal').modal('show');
                    }
                }
            ],

            processing: true,
            serverSide: true,
            ajax: {
                url: theForm.attr('action'),
                type: 'GET',
                
            }, //deferRender: true,select: true,

            responsive: true,
            columns: [{
                    data: ({position}) => position ? `<span class="p-1 pl-2 pr-2" style="background-color: #EBEEF3 ;border-radius:10px;color:#092C4C;font-weight:600;"> ${position} </span>` : "-",
                    name: 'position'
                }, 
                {
                    data: (data) => {
                        if(data.slide_images){
                            var path = "{{ asset('storage/slide-images') }}/"+data.slide_images ;
                           var html = '<img src="'+path+'" width="250px">';
                            return(html);
                        }else{
                            return("-");
                        } 
                    },
                    name: 'slide_images'
                },
                {
                    data: ({slide_name}) => slide_name ? `<strong class="text-color_main">${slide_name}</strong>` : "-",
                    name: 'slide_name'
                },   
                {
                    data: 'public',
                    name: 'public',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },   

                {
                    data: 'action',
                    name: 'action',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo($('.col-md-12:eq(0)', table.table()
                        .container())); //show button on datatable
                // table.buttons().container()
                // .appendTo( table.table().container()  ); //show button on datatable
                new $.fn.dataTable.FixedHeader(table);
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

    $("#imgInp").change(function(){
        readURL(this , $("#img-upload"));
    });
</script>
@endsection
