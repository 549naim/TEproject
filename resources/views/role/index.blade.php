@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <form action="{{ route('roles.update', 10000) }}" method="post" enctype="multipart/form-data"
                id="role_permission_edit_form">
                @csrf
                @method('PUT')
                <div class="d-flex flex-row ">
                    <div class="">
                        <div class="">
                            <div class="card" style="width: 25rem;">
                                <div class="card-body">
                                    <label for="name">user Name : </label>
                                    <select id="roleSelect" class="form-control mb-2 fw-bold" name="role_id">
                                        <option value="" selected>--select role-- </option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>




                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container px-5 mx-5 ">
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-4">
                                    <input id="permission{{ $permission->id }}" class="form-check-input" type="checkbox"
                                        name="permission[]" value="{{ $permission->id }}">
                                    <label class="form-check-label">{{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary add_category">Save
                    Role permissions</button>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_role">
                    Create Roles
                </button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_permission">
                    Create Permission
                </button>
            </div>
        </div>
        <hr>
        @include('role.create_role')
        @include('role.create_permission')
        @include('role.edit_role')
        @include('role.edit_permission')
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Roles</h6>
                    </div>
                    <div class="dt-responsive table-responsive p-3">
                        <table class="table align-items-center table-striped table-bordered nowrap" id="data_table_role">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Permission</h6>
                    </div>
                    <div class="dt-responsive table-responsive p-3">
                        <table class="table align-items-center table-striped table-bordered nowrap"
                            id="data_table_permission">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Position</th>

                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <script>
        $(document).ready(function() {
            $(function() {

                var table = $('#data_table_role').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('role.list') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

            });
            $(function() {

                var table = $('#data_table_permission').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('permission.list') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

            });
            $('#role_permission_edit_form').ajaxForm({
                success: function(res) {
                    showSuccessModal(res.message);
                }
            });
            $('#create_role_form').ajaxForm({
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#create_role').modal('hide');
                    $('#create_role_form')[0].reset();
                    $('#data_table_role').DataTable().ajax.reload();
                }
            });
            $('#create_permission_form').ajaxForm({
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#create_permission').modal('hide');
                    $('#create_permission_form')[0].reset();
                    $('#data_table_permission').DataTable().ajax.reload();
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $('body').on('click', '#edit_role', function(e) {
                $('#edit_role_form')[0].reset();
                var roleId = $(this).data("id");

                $.ajax({
                    type: 'get',
                    url: '/role-edit/' + roleId,
                    success: function(data) {

                        $('#role_edit_form').removeClass('d-none');
                        $('#edit_role_input').val(data.role.name);
                        $('#edit_role_id').val(roleId);

                    },
                    error: function(error) {}
                });

            });
            $('body').on('click', '#update_edit_role', function(e) {
                e.preventDefault();
                var role_name = $('#edit_role_input').val();
                var role_id = $('#edit_role_id').val();

                $.ajax({

                    type: 'post',
                    url: '/role-update',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: role_name,
                        role_id: role_id
                    },
                    success: function(data) {
                        $('#edit_role_name').modal('hide');
                        $('#edit_role_form')[0].reset();
                        $('#data_table_role').DataTable().ajax.reload();
                        showSuccessModal(data.message);

                    },
                });

            });







            $('body').on('click', '#delete_role', function() {
                var roleId = $(this).data("id");
                // window.location.href = '/role-delete/' + userId;
                $.ajax({
                    type: 'get',
                    url: '/role-delete/' + roleId,
                    success: function(data) {
                        $('#data_table_role').DataTable().ajax.reload();
                        showSuccessModal(data.message);

                    },
                });
            });


            $('body').on('click', '#edit_permission_name', function(e) {
                $('#edit_role_form')[0].reset();
                var permissionId = $(this).data("id");

                $.ajax({
                    type: 'get',
                    url: '/permission-edit/' + permissionId,
                    success: function(data) {


                        $('#edit_permission_input').val(data.permission.name);
                        $('#edit_permission_id').val(permissionId);


                    },
                    error: function(error) {}
                });

            });


            $('body').on('click', '#update_edit_permission', function(e) {
                e.preventDefault();
                var permission_name = $('#edit_permission_input').val();
                var permission_id = $('#edit_permission_id').val();


                $.ajax({

                    type: 'post',
                    url: '/permission-update',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: permission_name,
                        permission_id: permission_id
                    },
                    success: function(data) {
                        $('#edit_permission_name').modal('hide');
                        $('#edit_permission_form')[0].reset();
                        $('#data_table_permission').DataTable().ajax.reload();
                        showSuccessModal(data.message);

                    },
                });

            });

            $('body').on('click', '#delete_permission', function() {
                var userId = $(this).data("id");
                // window.location.href = '/role-delete/' + userId;
                $.ajax({
                    type: 'get',
                    url: '/permission-delete/' + userId,
                    success: function(data) {
                        $('#data_table_permission').DataTable().ajax.reload();
                        showSuccessModal(data.message);

                    },
                });
            });



            $('.form-check-input').prop('checked', false);
            $('#roleSelect').change(function() {

                $('.form-check-input').prop('checked', false);

            });
        });



        $('.form-check-input').prop('checked', false);
        $('#roleSelect').change(function() {

        $('.form-check-input').prop('checked', false);

        var role_id = $(this).val();

        $.ajax({
            type: 'get',
            url: '/role_permission',
            data: {
                role_id: role_id
            },
            success: function(data) {


                $(data.rolePermissions).each(function(id, permission) {

                    $('#permission' + permission).prop('checked', true);

                });

            },
            error: function(error) {}
        });
        })

        
    </script>

@endsection
