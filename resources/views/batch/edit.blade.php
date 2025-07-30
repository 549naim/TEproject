<div class="modal fade" id="edit_batch_modal" tabindex="-1" aria-labelledby="edit_batchLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit_batch_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_batchLabel">Edit Batch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_batch_id" name="id">
                    <div class="mb-3">
                        <label for="edit_batch_input" class="form-label">Batch Name</label>
                        <input type="text" class="form-control" id="edit_batch_input_name" name="name" value="" required>
                    </div>
                    <div class="mb-3">
                        
                        <label for="edit_batch_input_year" class="form-label mt-3">Year</label>
                        <input type="number" class="form-control" id="edit_batch_input_year" name="year" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="edit_batch_submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
