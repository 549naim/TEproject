<div class="modal fade" id="edit_question_modal" tabindex="-1" aria-labelledby="edit_questionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit_question_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_questionLabel">Edit Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_question_id" name="id">
                    <div class="mb-3">
                        <label for="edit_question_input" class="form-label">Question</label>
                        <input type="text" class="form-control" id="edit_question_input" name="edit_question" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="edit_question_submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
