<div class="modal fade show-user-modal edit-layout-modal pr-0" id="createFormModelId" tabindex="-1" role="dialog" aria-labelledby="createFormModelIdLable" aria-hidden="true" data-show="true">
  <div class="modal-dialog" role="document">
    <form class="prevent-resubmit-form" method="POST" id="create_user_form" 
        action="{{ route("admins.create") }}"
    >
             @csrf
            
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createFormModelIdLable">
                Add New Staff
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="loader br-4 overlay">
                <i class="ik ik-refresh-cw loading"></i>
                <span class="loader-text">New Staff Creating...</span>
            </div>
            <div >
                <div class="form-group">
                    <label for="name">Name</label><small class="text-danger">*</small>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" autocomplete="off">
                    <small class="text-danger err" id="name-err"></small>
                </div>

                <div class="form-group">
                    <label for="genderId">Gender</label><small class="text-danger">*</small>
                    <select class="form-control"  name="gender" required>
                        <option value="Male"> Male</option>
                        <option value="Female"> Female</option>
                    </select>
                    <small class="text-danger err" id="gender-err"></small>
                </div>

                <div class="form-group">
                    <label for="emailId">Email</label><small class="text-danger">*</small>
                    <input type="text" name="email" class="form-control" id="emailId" placeholder="Email" autocomplete="off">
                    <small class="text-danger err" id="email-err"></small>
                </div>

                <div class="form-group">
                    <label for="phoneId">Phone</label><small class="text-danger">*</small>
                    <input type="text" name="phone" class="form-control" id="phoneId" placeholder="Phone" autocomplete="off">
                    <small class="text-danger err" id="phone-err"></small>
                </div>

                <div class="form-group">
                    <label for="passwordId">Password</label><small class="text-danger">*</small>
                    <input type="password" name="password" class="form-control" id="passwordId" placeholder="Password" autocomplete="off">
                    <small class="text-danger err" id="password-err"></small>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>

    </form>
  </div>
</div>