<div class="modal fade" id="edit_admin_modal" tabindex="-1" aria-labelledby="edit_adminLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit_admin_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_adminLabel">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="admin_id">

                    <div class="mb-3">
                        <label for="admin_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="admin_name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="admin_email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin_roles" class="form-label">Role</label>
                        <select name="roles[]" id="admin_roles" class="form-control" multiple="multiple"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
