$(function() {
    var theFormEMS = $("#theFormEMS");
    var table, Item_id , Item_val, Item, Item_id_order, Item_fn = null;
    var ACTION ='';
    var status = "{{ $status ?? '' }}" ;

    // $("#viewDataModal").modal('show');
    // Swal.fire({
    //     title: 'ยืนยันการชำระเงินสำเร็จแล้วค่ะ',
    //     icon: 'success',
    //     showConfirmButton: false,
    //     // timer: 2000,
    // })
    // Swal.fire({
    //         title: 'ยืนยันการชำระเงิน?',
    //         text: "คุณตรวจสอบและยืนยันการทำรายการนี้",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#2DC8A8',
    //         cancelButtonColor: 'dark',
    //         confirmButtonText: 'ยืนยัน' ,
    //         cancelButtonText: 'ปิด'
    //     })
    Swal.fire({
                                position: 'center',
                                icon: 'danger',
                                title: 'ทำรายการสำเร็จ',
                                showConfirmButton: false,
                                iconColor: '#ffffffff',
                                // timer: 1500,
                            })

    var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
    if(status){
        if(status ==='sent'){
            ACTION = 'trash';
        }
        $("#example").DataTable().clear().destroy();
        datatableFilter(ACTION ,status);  
    }else{
        $("#example").DataTable().clear().destroy();
        datatableFilter();
    }
    

    if (theFormEMS.length > 0) {
        theFormEMS.validate({
            rules: {
                tracking_number: {
                    required: true,
                },
            },
            messages: {
                tracking_number: {
                    required: "Please enter tracking number",
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
            
            submitHandler: function(form) {
                // var form_data = new FormData(form);
                $.LoadingOverlay("show");
                var url = theFormEMS.attr('action');
                var type = theFormEMS.attr('method');
                var title = "Cannot add new records.";
                if (theFormEMS.attr("typeForm") === "update") {
                    url += '/' + Item_id;
                    type = "POST";
                    // form_data.append('_method': 'PUT');
                    title = "Cannot update records.";
                }
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}" , _method: 'PUT' , 'tracking_number':$('#tracking_number').val() },
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            theFormEMS.trigger("reset");
                            $('#theModal').modal('hide');
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Your work has been saved',
                                showConfirmButton: false,
                                timer: 800,
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
        });
    }
    
    $('body').on('click', '.changeStatusBtn', function() {
        
        Item_id = $(this).data("id");
        Item = $(this).data("val");
        Item_ems = $(this).data("ems");
        Item_fn = $(this).data("fn");
        //alert(Item);
        if(Item === "รอชำระเงิน"){
            Toast.fire({
                icon: 'error',
                title: 'Please Pending Payment.'
            });
           // alert("รอตัง จ้าา");
        }else if(Item === "รอตรวจสอบ"){
            Toast.fire({
                icon: 'error',
                title: 'Please check pay-in-slip.'
            });
           // alert("รอตัง จ้าา");
        }else if(Item === "ชำระเงินแล้ว"){
            showNextStage();
            // if(!Item_ems){
            //     //alert("ems จ้าา");
            //     Toast.fire({
            //         icon: 'error',
            //         title: 'Please enter tracking number.'
            //     });
            // }else{
            //     showNextStage();
            // }
        }else if(Item === "ส่งสินค้าแล้ว") {
            Toast.fire({
                icon: 'error',
                title: 'Order Completed.'
            });
        }

        function showNextStage(){
            Swal.fire({
                title: 'ระบุเลขพัสดุ  <i class="fas fa-truck pl-3 pt-1"></i>',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (res) => {
                    if(res){
                        // alert(res)
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/order') }}" + '/' + Item_id,
                            data: {_token: "{{ csrf_token() }}" , _method: 'PUT' , 'tracking_number':res },
                        });
                    }else{
                        Swal.showValidationMessage(
                        `กรอกเลขพัสดุด้วยค่ะ`
                        )
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            type: "POST",
                            url: "{{ url('admin/order') }}" + '/' + Item_id,
                            data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item , fn:Item_fn},// success: (response) => {
                            success: (response) => {
                                if ($.isEmptyObject(response.error)) {
                                    console.log(response);
                                    console.log(response.success);
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'ยืนยันการจัดส่งเรียบร้อยแล้วค่ะ',
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then((value) => {
                                        // window.history.back();
                                        window.location='{{ url("admin/order") }}'
                                    });
                                    
                                } else {
                                    console.log(response.error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: "Cannot update records.",
                                        text: "ERROR: " + response.error,
                                    });
                                }
                            },
                            error: (response) => {
                                console.log('Error:', response);
                                Swal.fire({
                                    icon: 'error',
                                    title: "<strong>Cannot update records.</strong>",
                                    html: "<strong>Error Code: </strong>" + response
                                        .status + "<p><strong>Message: </strong>" +
                                        JSON.stringify(response.responseJSON
                                            .message) + "</p>",
                                });
                            }
                    });
                    
                }
            })




            // Swal.fire({
            // title: 'ยืนยันการจัดส่ง?',
            // text: "คุณยืนยันการจัดส่งรายการนี้ใช่หรือไม่!",
            // icon: 'info',
            // showCancelButton: true,
            // confirmButtonColor: '#3085d6',
            // cancelButtonColor: 'dark',
            // confirmButtonText: 'Yes, I confirm that!'
            // }).then((result) => {
            //     if (result.value) {
            //         $.ajax({
            //             type: "POST",
            //             url: "{{ url('admin/order') }}" + '/' + Item_id,
            //             data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item , fn:Item_fn},
            //             success: (response) => {
            //                 if ($.isEmptyObject(response.error)) {
            //                     console.log(response);
            //                     console.log(response.success);
            //                     Swal.fire({
            //                         position: 'top-end',
            //                         icon: 'success',
            //                         title: 'Your work has been saved',
            //                         showConfirmButton: false,
            //                         timer: 800,
            //                     }).then((result) => { window.location='{{ url("admin/order") }}' });
            //                 } else {
            //                     console.log(response.error);
            //                     Swal.fire({
            //                         icon: 'error',
            //                         title: "Cannot delete records.",
            //                         text: "ERROR: " + response.error,
            //                     });
            //                 }
            //             },
            //             error: (response) => {
            //                 console.log('Error:', response);
            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: "<strong>Cannot delete records.</strong>",
            //                     html: "<strong>Error Code: </strong>" + response
            //                         .status + "<p><strong>Message: </strong>" +
            //                         JSON.stringify(response.responseJSON
            //                             .message) + "</p>",
            //                 });
            //             }
            //         });
            //     }
            // });
        }

        
    });
    
    
    $('body').on('click', '.viewDataBtn', function() {
        let order_id = $(this).data('id');
        // $("#viewDataModal").modal('show');
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"viewData" , order_id},
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $(".order_status_body").html(response.html);
                    $(".modal_footer_ap").html(response.html_footer ?? '');
                    
                    $("#viewDataModal").modal('show');
                    $('[data-toggle="popover"]').popover();
                    
                    // $("#action_des_order_new").niceScroll();
                }
            }
        });    
    });

    
    $('body').on('click', '.checkSlipBtn', function() {
        let order_id = $(this).data('id');
        
        // $("#viewDataModal").modal('show');
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"checkSlip" , order_id },
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $(".order_check_slip_body").html(response.html);
                    $("#checkSlipModal").modal('show');
                }
            }
        });    
    });
    
    $('body').on('click', '.viewEMSBtn', function() {
        let order_id = $(this).data('id');
        let order_ems = $(this).data('ems');
        
        // $("#viewDataModal").modal('show');
        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"viewEMS" , order_id },
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    $(".order_ems_body").html(response.html);
                    $("#viewEMSModal").modal('show');
                }
            }
        });    
    });

    $('body').on('click', '.btnNext', function() {
        let Item_id = $(this).data("id");
        let Item_id_tran = $(this).data("id-tran");
        let Item = $(this).data("val");
        let Item_fn = $(this).data("fn");

        Swal.fire({
            title: 'ยืนยันการชำระเงิน?',
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
                    type: "POST",
                    url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                    data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response);
                            console.log(response.success);
                            Swal.fire({
                                title: 'ยืนยันการชำระเงินสำเร็จแล้วค่ะ',
                                icon: 'success',
                            }).then((value) => {
                                var av_book = response.av_book ;
                                var av_ebook = response.av_ebook ;
                                if(av_ebook =="false"){ // dont have ebook
                                    window.history.back();
                                }
                                if(av_ebook =="true"){ // have a ebook
                                    Swal.fire({
                                    title: 'อนุมัติการอ่าน?',
                                    text: "คุณยืนยันอนุมัติการอ่าน E-Books ในรายการนี้ทั้งหมด",
                                    icon: 'info',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: 'dark',
                                    confirmButtonText: 'Yes, I confirm that'
                                    }).then((result) => {
                                        if (result.value) {
                                            Item_fn = "approve_read";
                                            $.ajax({
                                                type: "POST",
                                                url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                                                data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn},
                                                success: (response) => {
                                                    if ($.isEmptyObject(response.error)) {
                                                        console.log(response);
                                                        Swal.fire({
                                                            title: 'ยืนยันอนุมัติการอ่าน E-Books สำเร็จแล้วค่ะ',
                                                            icon: 'success',
                                                        }).then((value) => {
                                                            window.history.back();
                                                        });
                                                    } 
                                                },
                                            });
                                        }else{
                                            window.history.back();
                                        }
                                    });
                                }
                                



                            });
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

    $('body').on('click', '.btnRej', function() {
        Item_id = $(this).data("id");
        Item_id_tran = $(this).data("id-tran");
        Item = $(this).data("val");
        Item_fn = $(this).data("fn");

        var myArrayOfThings = [
            { id: 1, name: 'Item 1' },
            { id: 2, name: 'Item 2' },
            { id: 3, name: 'Item 3' }
        ];

        var options = {};
        $.map(myArrayOfThings,function(o) {
            options[o.id] = o.name;
        });
        
        Swal.fire({
            icon: 'danger',
            title: 'ระบุเหตุผล',
            // input: 'text',,
            text: 'คุณตรวจสอบและยืนยันการทำรายการนี้',
            input: 'select',
            inputOptions: options,
            showCancelButton: true,
            animation: 'slide-from-top',
            inputPlaceholder: 'ระบุเหตุผลในการส่งกลับ',
            inputAttributes: {
                autocapitalize: 'off'
            },
            // showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: (res) => {
                if(res){
                    // alert(res)
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/payInSlip') }}" + '/' + Item_id,
                        data:{_token: "{{ csrf_token() }}", _method: 'PUT' , id_tran: Item_id_tran , stagePresent:Item , fn:Item_fn,reason:res},
                        // success: (response) => {
                        //     if ($.isEmptyObject(response.error)) {
                        //         // Swal.fire({
                        //         //     icon: 'success',
                        //         //     title: "ส่งกลับเรียบร้อยแล้วค่ะ",
                        //         //     text: "ERROR: " + response.error,
                        //         // });
                        //         // Swal.fire({
                        //         //     position: 'top-end',
                        //         //     icon: 'success',
                        //         //     title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                        //         //     showConfirmButton: false,
                        //         //     timer: 1500
                        //         // })
                        //         // console.log(response);
                        //         // Swal.fire({
                        //         //     title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                        //         //     icon: 'success',
                        //         // }).then((value) => {
                        //         //     window.history.back();
                        //         // });
                        //     } 
                        // },
                    });
                }else{
                    Swal.showValidationMessage(
                    `กรอบเหตุผลด้วยค่ะ`
                    )
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'ส่งกลับเรียบร้อยแล้วค่ะ',
                    showConfirmButton: false,
                    timer: 1000
                }).then((value) => {
                    window.history.back();
                });
            }
        })
    });
    
    
    $('body').on('click', '.reOrderBtn', function() {
        Item_id = $(this).data('id');
        Item_fn = $(this).data("fn");
        Item_val = $(this).data("val");
        
        $.ajax({
           type:'POST',
           url:"{{ url('admin/order') }}" + "/" + Item_id,
           data:{_token: "{{ csrf_token() }}" , _method: 'PUT' , stagePresent:Item_val, fn:Item_fn},
           success: (response) => {
            
                if ($.isEmptyObject(response.error)) {
                    console.log(response);
                    console.log(response.success);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 800,
                    }).then((result) => {
                        table.ajax.reload(null, false);
                    });
                } else {
                    console.log(response.error);
                }
            }
        });    
    });

    $('body').on('click', '.detailBtn', function() {
        Item_id = $(this).data('id');
        window.location='{{ url("admin/order") }}'+'/'+Item_id;
    });

    $('body').on('click', '.emsBtn', function() {
        Item_id = $(this).data('id');
        var ems = $(this).data('ems');
        $.ajax({
            type: "GET",
            url: "{{ url('admin/order') }}" + '/' + Item_id + '/edit',
            success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    $('.modal-header').removeClass("bg-success text-white");
                    $('.modal-title').html("Edit Item");
                    $('.modal-header').addClass("bg-warning text-black");
                    $(".error").html('');

                    $(".is-invalid").removeClass("is-invalid");

                    $(".error").removeClass("error");
                    theFormEMS.attr("typeForm", "update");
                    // alert(Item_id);
                    //console.log(response.tracking_number);

                    $('#tracking_number').val(ems);
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
        Item_fn = $(this).data("fn");
        var textSw = "คุณยืนยันที่จะยกเลิกรายการนี้ใช่หรือไม่! เมื่อยกเลิกแล้วสินค้าในรายการนี้ทั้งหมดจะถูกคืนเข้าสู้ Stock";
        if(Item_fn){
        
            textSw ="คุณยืนยันที่จะลบรายการนี้แบบถาวร!";
        
        }else{
            Swal.fire({
                title: 'ระบุเหตุผลในการยกเลิก เมื่อยกเลิกแล้วสินค้าในรายการนี้ทั้งหมดจะถูกคืนเข้าสู่ Stock ',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (res) => {
                    if(res){
                        $.ajax({
                            type: "POST",
                            url: "{{ url('admin/order') }}" + '/' + Item_id,
                            data: {_method: 'DELETE' , fn:Item_fn ,'reason':res},
                        });
                    }else{
                        Swal.showValidationMessage(
                        `โปรดระบุเหตุผลในการยกเลิก`
                        )
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'ยืนยันการยกเลิกเรียบร้อยแล้วค่ะ',
                        showConfirmButton: false,
                        timer: 1000
                    }).then((value) => {
                        // window.history.back();
                        window.location='{{ url("admin/order") }}'
                    });
                    
                }
            })
        }
        //alert(Item_fn);
        // Swal.fire({
        //     title: 'ยืนยันการยกเลิก?',
        //     text: textSw,
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, delete it!'
        // }).then((result) => {
        //     if (result.value) {
        //         $.ajax({
        //             type: "POST",
        //             url: "{{ url('admin/order') }}" + '/' + Item_id,
        //             data: {_method: 'DELETE' , fn:Item_fn},
        //             success: (response) => {
        //                 console.log(response);
        //                 if ($.isEmptyObject(response.error)) {
        //                     console.log(response.success);
        //                     Swal.fire(
        //                         'ยกเลิก!',
        //                         'ยกเลิกรายการเรียบร้อยแล้วค่ะ.',
        //                         'success'
        //                     ).then((result) => table.ajax.reload(null, false));
        //                 } else {
        //                     console.log(response.error);
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: "Cannot delete records.",
        //                         text: "ERROR: " + response.error,
        //                     });
        //                 }
        //             },
        //             error: (response) => {
        //                 console.log('Error:', response);
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: "<strong>Cannot delete records.</strong>",
        //                     html: "<strong>Error Code: </strong>" + response
        //                         .status + "<p><strong>Message: </strong>" +
        //                         JSON.stringify(response.responseJSON
        //                             .message) + "</p>",
        //                 });
        //             }
        //         });
        //     }
        // });
    });

    const countNoti = () =>{
        // noti_wait_pay = "0";  //รอตรวจสอบ
        // noti_paid = "0" ; //ชำระเงินแล้ว
        // noti_refund = "0" //ขอคืนเงิน
        // noti_order_all = "0" //order all
        // noti_approve_ebook = "0" //approve e-book

        $.ajax({
           type:'GET',
           url:"{{ url('admin/order') }}",
           data:{_token: "{{ csrf_token() }}" , _method: 'GET' ,fn:"count_noti"},
           success: (response) => {            
                if ($.isEmptyObject(response.error)) {
                    // console.log(response);
                    // console.log(response.success);
                    $(".check_span").html("&nbsp;"+response.noti_wait_pay+"&nbsp;");
                    $(".paid_span").html("&nbsp;"+response.noti_paid+"&nbsp;");
                    $(".refund_span").html("&nbsp;"+response.noti_refund+"&nbsp;");
                    $(".noti-header-order-all").html(response.noti_order_all);
                    $(".noti-header-approve-ebook").html(response.noti_approve_ebook);
                    
                }
            }
        });    

    }

     

});