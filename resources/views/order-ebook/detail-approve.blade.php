@extends('../layouts.app')

@section('menu_order' , 'active')

@section('css')
<style>
.double {
  text-decoration-line: underline;
  text-decoration-style: double;    
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
          <div class="col-sm-6">
            <h1>Approve E-Books Detail</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('approve.index') }}">Approve E-Books</a></li>
              <li class="breadcrumb-item active">Approve E-Books Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section>
        <div class="row justify-content-center pl-3 pr-3">
        
            <div class="col-md-12">
                <div class="card card-primary">
                    <!-- form -->
                        <div class="card-header">
                                <h3 class="card-title"><i class="nav-icon fas fa-box-open"></i> E-Books Detail</h3>
                                <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            </div>
                        </div>
                        
                        <div class="card-body ">
                            <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered table-fixed text-center"  style="width:100%"> <!--class nowrap-->
                                <thead>
                                    <tr>
                                        <th colspan="3">เลขที่ใบสั่งซื้อ : </th>
                                    <th colspan="3" class="text-left">{{ $orders[0]->order_id }}</th>
                                    </tr>
                                    <tr>
                                        <th>ลำดับที่</th>
                                        <th colspan="2" width="15%">รูปภาพ</th>
                                        <th colspan="2" class="text-left">รายการ</th>
                                        <th>สถานะการอ่าน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td width="5%">{{ ++$i }}</td>
                                        <td colspan="2">@if(!empty($order->picture))
                                                <img src="{{ asset('storage/book-images/'.$order->picture) }}" width="100">
                                            @else
                                                <img src="{{ asset('images/noimage.png') }}" width="100">
                                            @endif  
                                        </td>
                                        <td colspan="2" class="text-left">{{ $order->book_name }}</td>
                                        <td width="15%">
                                            @if($order->approve_status == "y")
                                                <a href="javascript:void(0)" class="isCheckApprove" data-id="{{ $order->id }}" data-order-id="{{ $order->order_id }}" data-tran-id="{{ $order->tran_id }}" data-value="approve"><h5><span class="badge badge-success btn btn-success">อนุมัติอ่านแล้ว</span></h5></a>
                                            @else
                                                <a href="javascript:void(0)" class="isCheckApprove" data-id="{{ $order->id }}" data-order-id="{{ $order->order_id }}" data-tran-id="{{ $order->tran_id }}" data-value="reject"><h5><span class="badge badge-danger btn btn-danger">ไม่อนุมัติ</span></h5></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    <!-- form -->
                </div>
    
                
            </div>
        </div>
    </section>
    
  
    

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')

<script>
$(function() {
    $('body').on('click', '.isCheckApprove', function() {
        var Item_id = $(this).data("id");
        var Value = $(this).data("value");
        var order_id = $(this).data("order-id");
        var tran_id = $(this).data("tran-id");
        
        $.ajax({
           type:'POST',
           url:"{{ url('admin/approve') }}"+"/"+Item_id,
           data:{_token: "{{ csrf_token() }}", _method: 'PUT' , status:Value , fn: "approve" , order_id:order_id,tran_id:tran_id },
           success: (response) => {
                if ($.isEmptyObject(response.error)) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 800,
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    console.log(response.error);
                }
            }
        });
    });
});  
</script>

@endsection