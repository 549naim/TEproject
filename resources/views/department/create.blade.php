<div class="modal fade" id="create_department" tabindex="-1" aria-labelledby="create_departmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_departmentLabel">Create Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departments.store') }}" method="post" id="create_department_form">
                    @csrf
                    <div class="mb-3">
                        <label for="department" class="form-label">department</label>
                        <input type="text" class="form-control" id="department_name" name="department_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">department</label>
                        <input type="text" class="form-control" id="department_code" name="department_code" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
