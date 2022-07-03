<div class="box box-primary" id="edit_tags_modal">
            <div class="box-header with-border">
        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
         <br>
              <h3 class="box-title">Edit Category</h3>
            </div>
            <form method="POST"  class="prevent-resubmit-form" action="/management/categories/{{ $row->id }}" enctype="multipart/form-data">

                             {{ csrf_field() }}
                            {{ method_field('PATCH') }}
               <div class="box-body">
               <div class="form-group">
                  <label> Name</label>
                  <input class="form-control" type="text" id="name_tag_edit" value="{{ $row->name }}" name="name" required >
                </div>

              {{--    <div class="form-group">
                  <label>Slug</label>  
                  <input class="form-control" id="slug_tag_edit" name="slug" value="{{ $row->slug }}" readonly>
                </div>
 --}}
                {{--  <div class="form-group">
                        <label for="">Description</label>
                        <textarea  rows="3" name="description" class="form-control"  placeholder="Decsription.." >{{ $row->description }}</textarea>
                    </div> --}}
              <!-- /.box-body -->
              <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Update</button>
              </div>
            </div>
              </form>
          </div>
      
