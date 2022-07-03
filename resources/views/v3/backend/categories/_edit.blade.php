<div class="loader br-4 hidden">
    <i class="ik ik-refresh-cw loading"></i>
</div>
<form method="POST"  class="prevent-resubmit-form" action="{{ route('categories.update',$row->id) }}" enctype="multipart/form-data">

  @csrf
  @method("PUT")
  <div class="box-body">
    <div class="form-group">
      <label> Name</label>
      <input class="form-control" type="text" id="name_tag_edit" value="{{ $row->name }}" name="name" required >
    </div>

    <div class="box-footer">
      <button type="submit" class="btn btn-primary prevent-resubmit-button"><i class="ik ik-save"></i>Update</button>
    </div>
  </div>
</form>