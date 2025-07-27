@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Course List</h1>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_course">
                    <i class="fas fa-plus-circle"></i> Create
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-striped" id="course_table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>course Name</th>
                                <th>course Code</th>
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
    {{-- @include('course.create')
    @include('course.edit') --}}

    <script>
        $(document).ready(function() {
            $(function() {

                var table = $('#course_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('courses.index') }}",
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

            $('#create_course_form').ajaxForm({
                beforeSubmit: function() {
                    $('#create_course_form')[0].reset();
                    $('#create_course').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#course_table').DataTable().ajax.reload();
                }
            });

            $('#edit_course_form').ajaxForm({
                beforeSubmit: function() {
                    $('#edit_course_form')[0].reset();
                    $('#edit_course').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#course_table').DataTable().ajax.reload();
                }
            });


            $('body').on('click', '#edit_course', function() {
                var courseId = $(this).data("id");

                $.ajax({
                    type: 'GET',
                    url: '/courses/' + courseId,
                    success: function(response) {
                        $('#edit_course_input').val(response.data.course);
                        $('#edit_course_id').val(courseId);
                        $('#edit_course_modal').modal('show');
                        console.log("Set value:", response.data.course);
                    }
                });
            });

            // Update form submit using button click
            $('#edit_course_submit').on('click', function(e) {
                e.preventDefault();

                var courseId = $('#edit_course_id').val();
                var courseVal = $('input[name="edit_course"]').val();

                $.ajax({
                    url: '/courses/' + courseId,
                    type: 'PUT',
                    data: {
                        course: courseVal,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        showSuccessModal(res.message);
                        $('#edit_course_modal').modal('hide');
                        $('#course_table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Update failed');
                    }
                });
            });

            $('body').on('click', '#delete_course', function() {
                var courseId = $(this).data("id");
                showConfirmDeleteModal("Are you sure you want to delete this course?", function() {
                    $.ajax({
                        url: '/courses/' + courseId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            showSuccessModal(res.message);
                            $('#course_table').DataTable().ajax.reload();
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
