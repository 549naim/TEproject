@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <form action="{{ route('roles.update', 10000) }}" method="post" enctype="multipart/form-data">
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
                        <table class="table align-items-center table-striped table-bordered nowrap" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($roles as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit_role_name" id="edit_role" data-id="{{ $item->id }}">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" id="delete_role"
                                                data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach


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
                        <table class="table align-items-center table-striped table-bordered nowrap" id="dataTableHover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($permissions as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#edit_permission_name" id="edit_permission_name"
                                                data-id="{{ $item->id }}">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" id="delete_permission"
                                                data-id="{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
    @include('layouts.datatablecdn')
    <script>
        $(document).ready(function() {
            // ID From dataTable 
            $('#dataTableHover').DataTable(); // ID From dataTable with Hover
            $('#dataTable').DataTable(); // ID From dataTable with Hover
        });
    </script>

    <script>
        $(document).ready(function() {

            $('body').on('click', '#edit_role', function(e) {
                $('#edit_role_form')[0].reset();
                var userId = $(this).data("id");

                $.ajax({
                    type: 'get',
                    url: '/role-edit/' + userId,
                    success: function(data) {

                        $('#role_edit_form').removeClass('d-none');
                        $('#edit_role_input').val(data.role.name);
                        $('#edit_role_id').val(userId);

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
                        location.reload();

                    },
                    error: function(error) {
                        location.reload();
                    }
                });

            });







            $('body').on('click', '#delete_role', function() {
                var userId = $(this).data("id");
                // window.location.href = '/role-delete/' + userId;
                $.ajax({
                    type: 'get',
                    url: '/role-delete/' + userId,
                    success: function(data) {
                        location.reload();

                    },
                    error: function(error) {
                        location.reload();
                    }
                });
            });


            $('body').on('click', '#edit_permission_name', function(e) {
                $('#edit_role_form')[0].reset();
                var userId = $(this).data("id");

                $.ajax({
                    type: 'get',
                    url: '/permission-edit/' + userId,
                    success: function(data) {


                        $('#edit_permission_input').val(data.permission.name);
                        $('#edit_permission_id').val(userId);


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
                        location.reload();

                    },
                    error: function(error) {
                        location.reload();
                    }
                });

            });

            $('body').on('click', '#delete_permission', function() {
                var userId = $(this).data("id");
                // window.location.href = '/role-delete/' + userId;
                $.ajax({
                    type: 'get',
                    url: '/permission-delete/' + userId,
                    success: function(data) {
                        location.reload();

                    },
                    error: function(error) {
                        location.reload();
                    }
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

        });
    </script>

    <script>
        $("#permission_cancel").click(function() {
            $('#permission_edit_form').addClass('d-none');
            $('#permission_create_form').removeClass('d-none');
        });

        $('body').on('click', '#delete_permission', function() {
            var userId = $(this).data("id");
            $.ajax({
                type: 'get',
                url: '/permission-delete/' + userId,
                success: function(data) {
                    $('.data_table_permission').DataTable().ajax.reload();
                    successModal(data.message);
                },
                error: function(error) {}
            });
        });
    </script>
@endsection
