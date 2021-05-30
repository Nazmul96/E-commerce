<form action="{{route('subcategory_update',$data->id)}}" method="POST">
    @csrf
    <div class="modal-body">
         
      <div class="form-group">
        <label for="category_name">Category Name</label>
        <select class="form-control" name="category_id" required>
          @foreach ($category as $row)
             <option value="{{$row->id}}"@if($row->id==$data->category_id) selected @endif>{{$row->category_name}}</option>
          @endforeach             
        </select>
        <!-- <input type="hidden" name="id" value="{{$data->id}}">-->

      </div> 
      
        <div class="form-group">
          <label for="subcategory_name">sub-category Name</label>
          <input type="text" class="form-control" name="subcategory_name" value="{{$data->subcat_name}}" required>
          <small id="emailHelp" class="form-text text-muted">This is your main subcategory</small>
        </div>         
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>