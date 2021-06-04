@extends('../layouts.front')

@section('menu_cart' , 'active')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />

  <!-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->

  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
  


<style>
a.disabled {
  pointer-events: none;
  cursor: default;
}
.linear-2 {
  background-image: linear-gradient(to left, #23074d , #cc5333);
}
.linear-5 {
    background: rgb(102,25,185);
    background: radial-gradient(circle, rgba(102,25,185,1) 0%, rgba(25,182,223,1) 50%, rgba(42,124,222,1) 100%);
}
</style>
@endsection



@section('content')
<section>
    <div class="container py-4">
        <div class="row justify-content-center ">
            <div class="col-md-12">
                <div class="card" >
                    <div class="card-header " >
                            <h3 class="card-title"><font color="black" >หนังสือเล่มโปรด</font></h3>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-fixed " style="width:100% ; text-align:center; ">
                            <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>รูปภาพ</th>
                                    <th>ชื่อหนังสือ</th>
                                    <th>ราคา</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                        </table>
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

    //show()
    datatableFilter()
    var table , Item_id = null ;
    
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
                    url: "{{ url('/favorBook') }}" + '/' + Item_id,
                    data:{_method: 'DELETE'},
                    success: (response) => {
                        if ($.isEmptyObject(response.error)) {
                            console.log(response.success);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then((result) => {
                                mini_heart();  
                                table.ajax.reload(null, false);
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

    function datatableFilter() {
        table = $("#example").DataTable({
            lengthChange: true,
            iDisplayLength: 10,
            bFilter: true,
            "aaSorting": [],
            pagingType: "full_numbers",
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
                url: "{{ url('/favorBook') }}",
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
                    data: (data) => {
                        if(data.picture){
                            // $html ='<img style="background-color: HoneyDew;" width="90" height="90" class="img-thumbnail " src="'+"{{ asset('storage/book-images/thumbnail') }}/"+data.picture+'" >';                                                       
                            //  pic_test 
                            $html ='<img style="background-color: HoneyDew;" width="90" height="90" class="img-thumbnail " src="'+"{{ asset('img/books_test.jpg') }}"+'" >';                                                       
                              
                        }else{
                            $html ='<img style="background-color: HoneyDew;" class="img-thumbnail " src="'+"{{ asset('img/no_pic.png') }}"+'" >';                                                                 
                        }
                        return $html ;
                    },
                    name: 'picture'
                },
                {
                    data: (data) => {
                        if(data.blame_product == 'y'){
                            $html ='<a href="products/blame/detail/'+data.book_id+'" class="select_hover" style="text-shadow: 0 0 0.2em DeepSkyBlue"><h6>'+data.book_name+'</h6></a>';
                            
                        }else{
                            $html ='<a href="products/detail/'+data.book_id+'" class="select_hover" style="text-shadow: 0 0 0.2em DeepSkyBlue"><h6>'+data.book_name+'</h6></a>';
                        }
                        return $html ;
                    },
                    name: 'book_name'
                },
                {
                    data: (data) => data.price ?? '-',
                    name: 'price'
                },
                {
                    data: 'action',
                    name: 'action',
                    sortable: false,
                    orderable: false,
                    searchable: false
                },
            ],
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
 
</script>
@endsection
