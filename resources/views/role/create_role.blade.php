<div class="modal fade" id="create_role" tabindex="-1" aria-labelledby="create_roleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_roleLabel">Create Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('create-role') }}" method="post" enctype="multipart/form" id="create_role_form">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Role Name : </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name"><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
            </div>



        </div>
    </div>
</div>
