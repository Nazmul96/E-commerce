  <!--dorpify link-->
  <script src="{{asset('public/frontend/dist/css/dropify.css')}}"></script>
  <!-- dorpify cdn link-->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"> 

<form action="{{route('brand_update',$data->id)}}" method="POST" enctype="multipart/form-data" id="add-form">
    @csrf
    <div class="modal-body">
         
      <div class="form-group">
        <label for="brand-name">Brand Name</label>
        <input type="text" class="form-control" value="{{$data->brand_name}}" name="brand_name" required="">
        <small id="emailHelp" class="form-text text-muted">This is your Brand </small>
      </div>
      
       <div class="form-group">
        <label for="brand-name">Brand Logo</label>
        <input type="file" class="dropify1" data-height="140" id="input-file-now" name="brand_logo">
        <input type="hidden"  data-height="140" value="{{$data->brand_logo}}" name="old_logo" >
        <small id="emailHelp" class="form-text text-muted">This is your Brand Logo </small>
      </div>  
    </div>

    <div class="modal-footer"> 
      <button type="submit" class="btn btn-primary"><span class="d-none">loading......</span>Update</button>
    </div>
 </form>

<!-- dorpify cdn javscript link-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('public/frontend/dist/js/dropify.js')}}"></script>
<script type="text/javascript">//dropify 
	$('.dropify1').dropify();
 
</script>