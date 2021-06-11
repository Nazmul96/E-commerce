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
              <li class="breadcrumb-item active">Password Change</li>
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
                  <h3 class="card-title">Change Your Password</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{route('admin_password_update')}}">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Old Password</label>
                      <input type="password" name="old_password" class="form-control" id="exampleInputEmail1" placeholder="Old password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword2">New Password</label>
                      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password">
                      @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" id="exampleInputPassword3" placeholder="Confirm Password">
                      </div>
                  
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                  </div>
                 
                </form>
              </div>
          </div>
        
        </div>
        
      </div>
    </section>
 
</div>
  
@endsection
