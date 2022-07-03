<div class="modal fade show-user-modal edit-layout-modal pr-0" id="editFormModelId" tabindex="-1" role="dialog" aria-labelledby="editFormModelIdLable" aria-hidden="true" data-show="true">
  <div class="modal-dialog" role="document">
    <form class="prevent-resubmit-form" method="POST" id="editEmojiFormId" 
        action="#"
    >
             @csrf
        @method("PUT")
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editFormModelIdLable">
                Edit Emoji
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="loader br-4 overlay">
                <i class="ik ik-refresh-cw loading"></i>
                <span class="loader-text">Emoji Updating...</span>
            </div>
            <div >
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" autocomplete="off">
                    <small class="text-danger err" id="name-err"></small>
                </div>
                <div class="form-group">
                    <label for="editEmojiFileId">Emoji File <span class="text-secondary">(Image Format)</span></label><small class="text-danger">*</small>
                    <input type="file" class="form-control" name="img" id="editEmojiFileId">
                    <small class="text-danger err" id="name-err"></small>
                </div>
                <div class="form-group">
                    <img alt="..." width="150px" height="100px" 
                    id="editEmojiImgId"
                    src="">
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