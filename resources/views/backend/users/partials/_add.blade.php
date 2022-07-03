<div class="modal fade" id="userviewcreateallmodal">
    <div class="modal-dialog">
    <div class="box box-primary">
            <div class="box-header with-border">
               <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
         <br>
              <h3 class="box-title" id="form_unique_title"> </h3>
            </div>
            <form class="prevent-resubmit-form add_new" id=""  enctype="multipart/form-data">
             @csrf
             <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Name.."  required >
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Description</label>
                  {{-- <input type="text" name="description" class="form-control" id="description" placeholder="Decsription.."  > --}}
                   <textarea  rows="3" name="description" class="form-control" id="description" placeholder="Decsription.." required></textarea>
                </div>
              </div>
              <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Submit</button>
              </div>
              </form>
          </div>
          <!-- /.box -->
    </div>
</div>