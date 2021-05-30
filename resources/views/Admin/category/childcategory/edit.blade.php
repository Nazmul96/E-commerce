<form action="{{route('childcategory_update',$data->id)}}" method="POST">
    @csrf
    <div class="modal-body">
         
      <div class="form-group">
        <label for="category_name">Category/Subcategory Name</label>
        <select class="form-control" name="subcategory_id" required>
          @foreach ($category as $row)
          <option>{{$row->category_name}}</option>
          @php
              $subcategory=DB::table('subcategories')->where('category_id',$row->id)->get();
          @endphp           
          @foreach ($subcategory as $sub)
          <option value="{{$sub->id}}"@if ($sub->id == $data->subcategory_id) selected @endif>---- {{$sub->subcat_name}}</option>
          @endforeach
         @endforeach 
        </select>
      </div> 
      
        <div class="form-group">
          <label for="subcategory_name">Child-category Name</label>
          <input type="text" class="form-control" name="childcategory_name" value="{{$data->childcategory_name}}"required>
          <small id="emailHelp" class="form-text text-muted">This is your main Childcategory</small>
        </div>         
    </div>
    <div class="modal-footer">
      
      <button type="submit" class="btn btn-primary"><span class="d-none">loading......</span>Update</button>
    </div>
  </form>