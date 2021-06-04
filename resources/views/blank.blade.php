@extends('../layouts.app')

@section('menu_product_menu_open' , 'menu-open')
@section('menu_product_menu_open_active' , 'active')
@section('menu_add_product' , 'active')

@section('css')
<style>

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
            <h1>page home</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item"><a href="">home 1</a></li>
              <li class="breadcrumb-item active">home 2</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <br>

    <div class="row justify-content-center p-3">
        <div class="col-md-12">
            <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">TABLE</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                        </div>
                    </div>
                    <div class="card-footer">
                    
                    </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')

@endsection