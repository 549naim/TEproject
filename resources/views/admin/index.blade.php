@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">User List</h1>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_admin">
                    <i class="fas fa-plus-circle"></i> Create
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-striped" id="admin_table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Roles</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
    @include('admin.create')
    @include('admin.edit')

    <script>
        $(document).ready(function() {
            $(function() {

                var table = $('#admin_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'department',
                            name: 'department'
                        },
                        {
                            data: 'roles',
                            name: 'roles'
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

            $('#create_admin_form').ajaxForm({
                beforeSubmit: function() {
                    $('#create_admin_form')[0].reset();
                    $('#create_admin').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#admin_table').DataTable().ajax.reload();
                }
            });
            // Show Edit Modal
            $('body').on('click', '#edit_admin', function() {
                const adminId = $(this).data('id');

                $.ajax({
                    url: `/admin_edit/${adminId}`,
                    type: 'GET',
                    success: function(res) {
                        $('#admin_id').val(res.data.id);
                        $('#admin_name').val(res.data.name);
                        $('#admin_email').val(res.data.email);

                        // Populate roles
                        let allRoles = @json($roles); // available from blade
                        let userRoles = res.roles; // ✅ comes from controller now
                        let roleOptions = '';

                        $.each(allRoles, function(key, value) {
                            const selected = userRoles.includes(key) ? 'selected' : '';
                            roleOptions +=
                                `<option value="${key}" ${selected}>${value}</option>`;
                        });

                        $('#admin_roles').html(roleOptions);
                        $('#edit_admin_modal').modal('show');
                    },
                    error: function() {
                        // alert("Failed to load admin data!");
                    }
                });
            });


            // Update Admin
            $('#edit_admin_form').on('submit', function(e) {
                e.preventDefault();

                const formData = {
                    id: $('#admin_id').val(),
                    name: $('#admin_name').val(),
                    email: $('#admin_email').val(),
                    roles: $('#admin_roles').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                $.ajax({
                    url: "{{ route('admin_update') }}",
                    type: 'POST',
                    data: formData,
                    success: function(res) {
                        if (res.success) {
                            $('#edit_admin_modal').modal('hide');
                            showSuccessModal(res.message);
                            $('#admin_table').DataTable().ajax.reload();
                        }
                    },
                    error: function(xhr) {

                    }
                });
            });
            $('body').on('click', '#delete_admin', function() {
                const adminId = $(this).data('id');
                showConfirmDeleteModal("Are you sure you want to delete this admin?", function() {
                    $.ajax({
                        url: `/admin_delete/${adminId}`,
                        type: 'GET',
                        success: function(res) {
                            if (res.success) {
                                showSuccessModal(res.message);
                                $('#admin_table').DataTable().ajax.reload();
                            }
                        },
                        error: function() {
                            // alert('Delete failed!');
                        }
                    });
                });
            });
        });
    </script>
@endsection
