@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Department List</h1>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_department">
                    <i class="fas fa-plus-circle"></i> Create
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-striped" id="department_table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Department</th>
                                <th>Department Code</th>
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
    @include('department.create')
    @include('department.edit')

    <script>
        $(document).ready(function() {
            $(function() {

                var table = $('#department_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('departments.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'code',
                            name: 'code'
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

            $('#create_department_form').ajaxForm({
                beforeSubmit: function() {
                    $('#create_department_form')[0].reset();
                    $('#create_department').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#department_table').DataTable().ajax.reload();
                }
            });

            $('#edit_department_form').ajaxForm({
                beforeSubmit: function() {
                    $('#edit_department_form')[0].reset();
                    $('#edit_department').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#department_table').DataTable().ajax.reload();
                }
            });


            $('body').on('click', '#edit_department', function() {
                var departmentId = $(this).data("id");

                $.ajax({
                    type: 'GET',
                    url: '/departments/' + departmentId,
                    success: function(response) {
                        $('#edit_department_input').val(response.data.department);
                        $('#edit_department_id').val(departmentId);
                        $('#edit_department_modal').modal('show');
                        console.log("Set value:", response.data.department);
                    }
                });
            });

            // Update form submit using button click
            $('#edit_department_submit').on('click', function(e) {
                e.preventDefault();

                var departmentId = $('#edit_department_id').val();
                var departmentVal = $('input[name="edit_department"]').val();

                $.ajax({
                    url: '/departments/' + departmentId,
                    type: 'PUT',
                    data: {
                        department: departmentVal,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        showSuccessModal(res.message);
                        $('#edit_department_modal').modal('hide');
                        $('#department_table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Update failed');
                    }
                });
            });

            $('body').on('click', '#delete_department', function() {
                var departmentId = $(this).data("id");
                showConfirmDeleteModal("Are you sure you want to delete this department?", function() {
                    $.ajax({
                        url: '/departments/' + departmentId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            showSuccessModal(res.message);
                            $('#department_table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Delete failed');
                        }
                    });
                });
            });

        });
    </script>
@endsection
