
<form action="{{route('warehouse_update',$data->id)}}" method="POST" id="add-form">
    @csrf
    <div class="modal-body">      
        <div class="form-group">
          <label for="warehouse_name">Warehouse Name</label>
          <input type="text" class="form-control" name="warehouse_name" value="{{$data->warehouse_name}}" required>
        </div> 
         <div class="form-group">
          <label for="warehouse_address">Warehouse Address</label>
          <input type="text" class="form-control" name="warehouse_address" value="{{$data->warehouse_address}}" required>
        </div> 
          <div class="form-group">
          <label for="warehouse_phone">Warehouse Phone</label>
          <input type="text" class="form-control" name="warehouse_phone" value="{{$data->warehouse_phone}}"required>
        </div>          
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      <button type="Submit" class="btn btn-primary"> <span class="d-none loader"><i class="fas fa-spinner"></i> Loading..</span> <span class="submit_btn"> Update </span> </button>
    </div>
  </form>
