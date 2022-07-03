<div class="modal fade" id="Edit_user_class_modal">
    <div class="modal-dialog">
    <div class="box box-primary">

            <div class="box-header with-border">
        <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
         <br>
              <h3 class="box-title">Edit Staff</h3>
            </div>
            <form method="POST"  class="prevent-resubmit-form" id="edit_user_form" action="/management/users" enctype="multipart/form-data">

                             {{ csrf_field() }}
                            {{ method_field('PATCH') }}
               <div class="box-body">
              <div class="form-group">
                  <label for="exampleInputEmail1">Name:</label>
                  <input type="text" name="name" class="form-control"  placeholder="Full Name.."  required >
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">Gender:</label>
                   <select class="form-control" name="gender" required>
                    <option value="Male"> Male</option>
                    <option value="Female"> Female</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Email:</label>
                  <input type="text" name="email" class="form-control" placeholder="Email.."  required >
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Phone:</label>
                  <input type="text" name="phone" class="form-control"  placeholder="Phone.."  required >
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
               <button type="submit" class="btn btn-primary prevent-resubmit-button">Save</button>
              </div>
            </div>
              </form>
          </div>
          <!-- /.box -->
    </div>
</div>
