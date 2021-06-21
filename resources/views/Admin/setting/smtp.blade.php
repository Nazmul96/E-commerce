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
              <li class="breadcrumb-item"><a href="">Home</a></li>
              <li class="breadcrumb-item active">SMTP Mail</li>
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
                  <h3 class="card-title">SMTP Mail setting</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" action="{{route('smtp_setting_update',$smtp->id)}}" method="Post">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Mail Mailer</label>
                        <input type="text" class="form-control" name="mailer" value="{{$smtp->mailer}}" placeholder="Mail mailer Example:smtp">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Mail Host</label>
                        <input type="text" class="form-control" name="host" value="{{$smtp->host}}" placeholder="Mail Host">
                      </div>
                       
                      <div class="form-group">
                        <label for="exampleInputEmail1">Mail Port</label>
                        <input type="text" class="form-control" name="port" value="{{$smtp->port}}" placeholder="Mail Port Example:2525">                      
                      </div>
                    
                      <div class="form-group">
                        <label for="exampleInputEmail1">Mail Username</label>
                        <input type="text" class="form-control" name="user_name" value="{{$smtp->user_name}}" placeholder="Mail Username">                      
                      </div>

                      <div class="form-group">
                        <label for="exampleInputEmail1">Mail Password</label>
                        <input type="text" class="form-control" name="password" value="{{$smtp->password}}" placeholder="Mail Password">                      
                      </div>                   
                     
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </form>
    
              </div>
          </div>
        
        </div>
        
      </div>
    </section>
 
</div>
  
@endsection
