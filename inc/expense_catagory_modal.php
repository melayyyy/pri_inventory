<div class="modal fade expenseCatModal" id="expenseCatModal">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title">Add New Purpose</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="alert alert-primary alert-dismissible fade show catWarning-area" role="alert" style="display:none;">
                    <span id="catWarning"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="addexpenseCat">
                    <div class="form-group">
                        <label for="expense_catName">Purpose Name</label>
                        <input type="text" class="form-control" id="expense_catName" name="expense_catName" placeholder="e.g. Official Office Use" required>
                    </div>

                    <div class="form-group">
                        <label for="expesecatDescrip">Description / Usage</label>
                        <textarea rows="3" class="form-control" id="expesecatDescrip" name="expesecatDescrip" placeholder="Enter details here..."></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block mt-4 rounded-0">Save Purpose</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>