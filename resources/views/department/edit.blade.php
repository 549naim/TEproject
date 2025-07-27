<div class="modal fade" id="edit_department_modal" tabindex="-1" aria-labelledby="edit_departmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit_department_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_departmentLabel">Edit department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_department_id" name="id">
                    <div class="mb-3">
                        <label for="edit_department_input" class="form-label">department</label>
                        <input type="text" class="form-control" id="edit_department_input_name" name="edit_department_name" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_department_input" class="form-label">department</label>
                        <input type="text" class="form-control" id="edit_department_input_code" name="edit_department_code" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="edit_department_submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
