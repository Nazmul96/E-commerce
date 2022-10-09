@extends('layouts.admin')
@section('admin_content')
  <!--dorpify link-->
  <script src="{{asset('public/frontend/dist/css/dropify.css')}}"></script>
  <!-- dorpify cdn link-->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">  
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Product</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <a href="{{route('product_create')}}" class="btn btn-primary">+ Add New</a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">All product List here</h3>
                </div>
                <div class="row p-2">
                   <div class="form-group col-3">
                      <label for="">Category</label>
                      <select name="category_id" id="category_id" class="form-control submitable">
                        <option value="">All</option>
                        @foreach($category as $categories)
                         <option value="{{$categories->id}}">{{$categories->category_name}}</option> 
                        @endforeach
                      </select>
                   </div>
                   <div class="form-group col-3">
                    <label for="">Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control submitable">
                      <option value="">All</option>
                      @foreach($brand as $brands)
                       <option value="{{$brands->id}}">{{$brands->brand_name}}</option> 
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-3">
                    <label for="">Warehouse</label>
                    <select name="warehouse_id" id="warehouse_id" class="form-control submitable">
                      <option value="">All</option>
                      @foreach($warehouse as $warehouses)
                       <option value="{{$warehouses->warehouse_name }}">{{$warehouses->warehouse_name}}</option> 
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-3">
                    <label for="">Status</label>
                    <select name="status" id="status" class="form-control submitable">
                      <option value="">All</option>
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped table-sm ytable">
                      <thead>
                      <tr>
                        <th>SI</th>
                        <th>Thumbnail</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Brand</th>
                        <th>Featured</th>
                        <th>Today Deal</th>
                        <th>Status</th>
                        <th>Action</th>                        
                      </tr>
                      </thead>
                      <tbody>
                    
                      </tbody>                     
                    </table>
                  </div>
            </div>
        </div>
    </div>
   </div>     
 </section>
</div>

<!-- dorpify cdn javscript link-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script type="text/javascript">
	$(function products(){
		  table=$('.ytable').DataTable({
      "processing":true,
      "serverSide":true,
      "searching":true,
      "ajax":{
        "url": "{{ route('product_index') }}", 
        "data":function(e) {
          e.category_id =$("#category_id").val();
          e.brand_id =$("#brand_id").val();
          e.status=$("#status").val();
          e.warehouse =$("#warehouse_id").val();
        }
      },
			columns:[
				        {data:'DT_RowIndex',name:'DT_RowIndex'},
                {data:'thumbnail'  ,name:'thumbnail'},
				        {data:'name'  ,name:'name'},
				        {data:'code',name:'code'},
                {data:'category_name',name:'category_name'},
                {data:'subcat_name',name:'subcat_name'},
                {data:'brand_name',name:'brand_name'},
                {data:'featured',name:'featured'},
                {data:'today_deal',name:'today_deal'},
                {data:'status',name:'status'},
				        {data:'action',name:'action',orderable:true, searchable:true},

			]
		});
	});

   //deactive featured.......
   $('body').on('click','.deactive_featured',function(){
      var id=$(this).data('id');
      var url="{{url('product/featured-deactive')}}/"+id;
      $.ajax({
           url:url,
           type:'get',
           success:function(data){  
              toastr.success(data);
              table.ajax.reload();
            }
        });
    });

    //active featured.......
   $('body').on('click','.active_featured',function(){
      var id=$(this).data('id');
      var url="{{url('product/featured-active')}}/"+id;
      $.ajax({
           url:url,
           type:'get',
           success:function(data){  
              toastr.success(data);
              table.ajax.reload();
            }
        });
    });

  //Deactive Today_deal.......
   $('body').on('click','.deactive_todaydeal',function(){
      var id=$(this).data('id');
      var url="{{url('product/todaydeal-deactive')}}/"+id;
      $.ajax({
           url:url,
           type:'get',
           success:function(data){  
              toastr.success(data);
              table.ajax.reload();
            }
        });
    });

  //active Today_deal.......
   $('body').on('click','.active_todaydeal',function(){
      var id=$(this).data('id');
      var url="{{url('product/todaydeal-active')}}/"+id;
      $.ajax({
           url:url,
           type:'get',
           success:function(data){  
              toastr.success(data);
              table.ajax.reload();
            }
        });
    });

     //Deactive Today_deal.......
   $('body').on('click','.deactive_status',function(){
      var id=$(this).data('id');
      var url="{{url('product/status-deactive')}}/"+id;
      $.ajax({
           url:url,
           type:'get',
           success:function(data){  
              toastr.success(data);
              table.ajax.reload();
            }
        });
    });

  //active Today_deal.......
   $('body').on('click','.active_status',function(){
      var id=$(this).data('id');
      var url="{{url('product/status-active')}}/"+id;
      $.ajax({
           url:url,
           type:'get',
           success:function(data){  
              toastr.success(data);
              table.ajax.reload();
            }
        });
    });

    $(document).on('change', '.submitable', function() {
          $('.ytable').DataTable().ajax.reload();
    });
</script>

@endsection