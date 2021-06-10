<form action="{{route('coupon_update',$data->id)}}" method="POST">
    @csrf
    <div class="modal-body">
      
        <div class="form-group">
          <label for="subcategory_name">Coupon Code</label>
          <input type="text" class="form-control" name="coupon_code" value="{{$data->coupon}}" required>
        </div>
        <div class="form-group">
          <label for="subcategory_name">Coupon Discount (%)</label>
          <input type="text" class="form-control" name="coupon_discount" value="{{$data->discount}}"required>
        </div>           
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary"><span class="d-none">loading......</span>Submit</button>
    </div>
  </form>