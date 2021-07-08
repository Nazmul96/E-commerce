<form action="{{route('coupon_update',$data->id)}}" method="POST">
  @csrf
  <div class="modal-body">
    
      <div class="form-group">
        <label for="coupon code">Coupon Code</label>
        <input type="text" class="form-control" name="coupon_code" value="{{$data->coupon_code}}" required>
      </div>
      <div class="form-group">
        <label for="coupon type">Coupon Type</label>
        <select class="form-control" name="type" id="">
              <option value="{{1}}" {{ ($data->type == '1') ? 'selected': '' }}>Fixed</option>
              <option value="{{2}}" {{ ($data->type == '2') ? 'selected': '' }}>Percentage</option>
        </select>
      </div>
      <div class="form-group">
        <label for="coupon_amount">Coupon Amount </label>
        <input type="text" class="form-control"  name="coupon_amount" required="" value="{{$data->coupon_amount}}">
      </div>   
      <div class="form-group">
        <label for="valid_date">Coupon Date</label>
        <input type="date" class="form-control"  name="valid_date" value="{{$data->valid_date}}" required="">
      </div>

      <div class="form-group">
        <label for="coupon_code">Coupon Status </label>
        <select class="form-control" name="status" required>
          <option value="Active" {{ ($data->type == 'Active') ? 'selected': '' }}>Active</option>
          <option value="Inactive" {{ ($data->type == 'Inactive') ? 'selected': '' }}>Inactive</option>
        </select>
      </div>  
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <button type="Submit" class="btn btn-primary"> <span class="d-none loader"><i class="fas fa-spinner"></i> Loading..</span> <span class="submit_btn">Update </span> </button>
  </div>
</form>