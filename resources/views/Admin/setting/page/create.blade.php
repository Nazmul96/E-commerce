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
              <li class="breadcrumb-item active">Page Crate</li>
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
          <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Create New Page</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{route('page_store')}}">
                    @csrf
                  <div class="card-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Page Position</label>
                       <select class="form-control" name="page_position">
                            <option value="1">Line One</option>
                            <option value="2">Line Two</option>
                       </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Page Name</label>
                      <input type="text" name="page_name" class="form-control"  placeholder="Page Name">
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleInputEmail1">Page Title</label>
                        <input type="text" name="page_title" class="form-control"  placeholder="Page Title">
                    </div>
                   
                    <div class="form-group">
                        <label for="exampleInputPassword1">Page Description</label>
                        <textarea class="form-control textarea" name="page_description">

                        </textarea>
                        <small>This data will show on your website</small>
                    </div>
                 </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create Page</button>
                  </div>
               
                </form>
              </div>
          </div>
        
        </div>
        
      </div>
    </section>
 
</div>
  
@endsection
