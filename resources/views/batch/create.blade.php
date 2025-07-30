<div class="modal fade" id="create_batch" tabindex="-1" aria-labelledby="create_batchLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_batchLabel">Create Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('batches.store') }}" method="post" id="create_batch_form">
                    @csrf
                    <div class="mb-3">
                        <label for="batch" class="form-label">Batch Name</label>
                        <input type="text" class="form-control" id="batch_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="batch_year" class="form-label">Batch Year</label>
                        <select class="form-control" id="batch_year" name="year" required>
                            @for ($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
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
