<div class="modal fade" id="create_permission" tabindex="-1" aria-labelledby="create_permissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_permissionLabel">Create Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('create-permission') }}" method="post" enctype="multipart/form"
                    id="create_permission_form">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Permission Name : </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name"><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary add_category">Save
                            Permission</button>
                    </div>

                </form>
            </div>



        </div>
    </div>
</div>
