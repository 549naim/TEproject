@extends('layouts.master')

@section('content')
    <div class="pc-content">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Batch List</h1>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_batch">
                    <i class="fas fa-plus-circle"></i> Create
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-striped" id="batch_table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Batch Name</th>
                                <th>Year</th>
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
    {{-- @include('batch.create')
    @include('batch.edit') --}}

    <script>
        $(document).ready(function() {
            $(function() {

                var table = $('#batch_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('batches.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'year',
                            name: 'year'
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

            $('#create_batch_form').ajaxForm({
                beforeSubmit: function() {
                    $('#create_batch_form')[0].reset();
                    $('#create_batch').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#batch_table').DataTable().ajax.reload();
                }
            });

            $('#edit_batch_form').ajaxForm({
                beforeSubmit: function() {
                    $('#edit_batch_form')[0].reset();
                    $('#edit_batch').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#batch_table').DataTable().ajax.reload();
                }
            });


            $('body').on('click', '#edit_batch', function() {
                var batchId = $(this).data("id");

                $.ajax({
                    type: 'GET',
                    url: '/batchs/' + batchId,
                    success: function(response) {
                        $('#edit_batch_input').val(response.data.batch);
                        $('#edit_batch_id').val(batchId);
                        $('#edit_batch_modal').modal('show');
                        console.log("Set value:", response.data.batch);
                    }
                });
            });

            // Update form submit using button click
            $('#edit_batch_submit').on('click', function(e) {
                e.preventDefault();

                var batchId = $('#edit_batch_id').val();
                var batchVal = $('input[name="edit_batch"]').val();

                $.ajax({
                    url: '/batchs/' + batchId,
                    type: 'PUT',
                    data: {
                        batch: batchVal,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        showSuccessModal(res.message);
                        $('#edit_batch_modal').modal('hide');
                        $('#batch_table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Update failed');
                    }
                });
            });

            $('body').on('click', '#delete_batch', function() {
                var batchId = $(this).data("id");
                showConfirmDeleteModal("Are you sure you want to delete this batch?", function() {
                    $.ajax({
                        url: '/batchs/' + batchId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            showSuccessModal(res.message);
                            $('#batch_table').DataTable().ajax.reload();
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
