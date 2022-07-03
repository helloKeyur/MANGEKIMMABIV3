<div class="box box-primary" id="edit_emijis_modal">
            <div class="box-header with-border">
        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
         <br>
              <h3 class="box-title">Edit Emoji</h3>
            </div>
            <form  class="prevent-resubmit-form" id="edit_emoji_form" action="/management/emojis/{{ $row->id }}" enctype="multipart/form-data">

                             {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                <div class="box-body ">
                <div class="row">

             
                <input type="hidden" value="{{ $row->id }}" id="id_edit">
                  <div class="form-group col-md-6">
                  <label>Emoji Title</label>
                  <input class="form-control" type="text" value="{{ $row->name }}" name="name">
                </div>




                <div class="form-group col-md-6">
                <label>Emoji Image</label>
                    <img alt="..." width="150px" height="100px" src="{{ $row->img_url }}" onerror="this.src='http://placehold.it/150x100';">
                <br>
               
                  <input type="file" class="form-control" name="img" @if(!$row->img_url ) required @endif>
              </div>

              </div>
              <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Update</button>
              </div>
              </form>
          </div>
      
