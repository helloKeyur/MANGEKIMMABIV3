<div class="modal fade show-user-modal edit-layout-modal pr-0" id="editFormModelId" tabindex="-1" role="dialog" aria-labelledby="editFormModelIdLable" aria-hidden="true" data-show="true">
  <div class="modal-dialog" role="document">
    <form method="POST"  class="prevent-resubmit-form" id="edit_user_form" action="#" method="POST">
            @csrf
            @method('PUT')
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editFormModelIdLable">
                Edit New Staff
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

            <div class="loader br-4 overlay">
                <i class="ik ik-refresh-cw loading"></i>
                <span class="loader-text">Staff Updating...</span>
            </div>
            <div >
                <div class="form-group">
                    <input type="hidden" name="editFrom" id="_editFrom" value="edit">
                    <label for="_editNameId">Name</label><small class="text-danger">*</small>
                    <input type="text" name="name" class="form-control" id="_editNameId" placeholder="Name" autocomplete="off">
                    <small class="text-danger err" id="_edit-name-err"></small>
                </div>

                <div class="form-group">
                    <label for="_editGenderId">Gender</label><small class="text-danger">*</small>
                    <select class="form-control" id="_editGenderId" name="gender" required>
                        <option value="Male"> Male</option>
                        <option value="Female"> Female</option>
                    </select>
                    <small class="text-danger err" id="_edit-gender-err"></small>
                </div>

                <div class="form-group">
                    <label for="_editEmailId">Email</label><small class="text-danger">*</small>
                    <input type="text" name="email" class="form-control" id="_editEmailId" placeholder="Email" autocomplete="off">
                    <small class="text-danger err" id="_edit-email-err"></small>
                </div>

                <div class="form-group">
                    <label for="_editPhoneId">Phone</label><small class="text-danger">*</small>
                    <input type="text" name="phone" class="form-control" id="_editPhoneId" placeholder="Phone" autocomplete="off">
                    <small class="text-danger err" id="_edit-phone-err"></small>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>

    </form>
  </div>
</div>