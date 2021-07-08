@extends('layouts.admin')

@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin_home')}}">Home</a></li>
              <li class="breadcrumb-item active">Pickup Point Update</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Update Pickup Point</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('pickup_point_update',$data->id)}}" method="post" id="add_form">
                  @csrf
              <div class="modal-body">
                  <div class="form-group">
                    <label for="pickup_point_name">Pickup Point Name <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control"  name="pickup_point_name" value="{{$data->pickup_point_name}}" required="">
                  </div>     
                  <div class="form-group">
                    <label for="pickup_point_address">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control"  name="pickup_point_address" value="{{$data->pickup_point_address}}"required="">
                  </div>
                  <div class="form-group">
                    <label for="pickup_point_phone">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control"  name="pickup_point_phone" value="{{$data->pickup_point_phone}}" required="">
                  </div>
                  <div class="form-group">
                    <label for="pickup_point_phone_two">Another Phone </label>
                    <input type="text" class="form-control"  name="pickup_point_phone_two" value="{{$data->pickup_point_phone_two}}">
                  </div>   
              <div class="modal-footer">
                <button type="Submit" class="btn btn-primary"> <span class="loading d-none"> Loading....</span> Submit</button>
              </div>
              </form>
              </div>
          </div>
        
        </div>
        
      </div>
    </section>
 
</div>
  
@endsection
