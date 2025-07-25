<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="edit_role_name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('role-update') }}" method="post" enctype="multipart/form" id="edit_role_form">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Role Name : </label>
                            <input id="edit_role_input" type="text" class="form-control" name="name"
                                placeholder="Enter Name"><br>
                            <input name="role_id" type="hidden" id="edit_role_id" value="">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="update_edit_role">Update
                            Role</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
