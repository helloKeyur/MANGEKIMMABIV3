

  <select class="form-control subject_list" id="{{ $row['id'] }} " name="{{ $row['id'] }}" >
                  <option value = "NULL" >{{ $row['nonvalue'] }} </option>
                   @foreach ($row['query'] as $var)
                       <option  value="{{ $var->id }}" >{{ $var->name }}</option>
                   @endforeach
  </select>