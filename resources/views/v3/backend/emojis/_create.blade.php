<div class="modal fade show-user-modal edit-layout-modal pr-0" id="createFormModelId" tabindex="-1" role="dialog" aria-labelledby="createFormModelIdLable" aria-hidden="true" data-show="true">
  <div class="modal-dialog" role="document">
    <form class="prevent-resubmit-form" method="POST" id="createEmojiFormId" 
        action="{{ route('emojis.store') }}"
    >
             @csrf
            
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createFormModelIdLable">
                Add New Emoji
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <div class="loader br-4 overlay">
                <i class="ik ik-refresh-cw loading"></i>
                <span class="loader-text">New Emoji Creating...</span>
            </div>
            <div >
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Name" autocomplete="off">
                    <small class="text-danger err" id="name-err"></small>
                </div>
                <div class="form-group">
                    <label for="name">Emoji File <span class="text-secondary">(Image Format)</span></label><small class="text-danger">*</small>
                    <input type="file" class="form-control" name="img" required>
                    <small class="text-danger err" id="img-err"></small>
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