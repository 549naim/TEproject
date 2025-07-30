<div class="modal fade" id="edit_course_modal" tabindex="-1" aria-labelledby="edit_courseLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="edit_course_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_courseLabel">Edit Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_course_id" name="id">
                    <div class="mb-3">
                        <label for="edit_course_input" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="edit_course_input_name" name="name" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_course_input_code" class="form-label mt-3">Course Code</label>
                        <input type="text" class="form-control" id="edit_course_input_code" name="code" value="" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="edit_course_submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
