@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Question List</h1>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_question">
                    <i class="fas fa-plus-circle"></i> Create
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-striped" id="question_table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Question</th>
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
    @include('question.create')
    @include('question.edit')

    <script>
        $(document).ready(function() {
            $(function() {

                var table = $('#question_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('questions.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'question',
                            name: 'question'
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

            $('#create_question_form').ajaxForm({
                beforeSubmit: function() {
                    $('#create_question_form')[0].reset();
                    $('#create_question').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#question_table').DataTable().ajax.reload();
                }
            });

            $('#edit_question_form').ajaxForm({
                beforeSubmit: function() {
                    $('#edit_question_form')[0].reset();
                    $('#edit_question').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#question_table').DataTable().ajax.reload();
                }
            });


            $('body').on('click', '#edit_question', function() {
                var questionId = $(this).data("id");

                $.ajax({
                    type: 'GET',
                    url: '/questions/' + questionId,
                    success: function(response) {
                        $('#edit_question_input').val(response.data.question);
                        $('#edit_question_id').val(questionId);
                        $('#edit_question_modal').modal('show');
                        console.log("Set value:", response.data.question);
                    }
                });
            });

            // Update form submit using button click
            $('#edit_question_submit').on('click', function(e) {
                e.preventDefault();

                var questionId = $('#edit_question_id').val();
                var questionVal = $('input[name="edit_question"]').val();

                $.ajax({
                    url: '/questions/' + questionId,
                    type: 'PUT',
                    data: {
                        question: questionVal,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        showSuccessModal(res.message);
                        $('#edit_question_modal').modal('hide');
                        $('#question_table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Update failed');
                    }
                });
            });

            $('body').on('click', '#delete_question', function() {
                var questionId = $(this).data("id");
                showConfirmDeleteModal("Are you sure you want to delete this question?", function() {
                    $.ajax({
                        url: '/questions/' + questionId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            showSuccessModal(res.message);
                            $('#question_table').DataTable().ajax.reload();
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
