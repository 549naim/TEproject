@extends('layouts.master')

@section('content')
    <div class="pc-content">

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Evaluation Setting</h3>
                <a href="" id="sendEmailBtn" class="btn btn-success btn-sm">
                    <i class="fa fa-envelope"></i> Send Email
                </a>
            </div>
            @if (isset($evaluationSetting->start_date) && isset($evaluationSetting->end_date))
                <div class="alert alert-success d-flex justify-content-between align-items-center p-3 rounded mb-3">
                    <h4 class="mb-0">
                        Teaching Evaluation Date From <span
                            id="evaluation_start">{{ $evaluationSetting->start_date }}</span> To
                        <span id="evaluation_end">{{ $evaluationSetting->end_date }}</span>
                    </h4>
                </div>
            @endif
        </div>

        <div class="card p-4">
            <form action="{{ route('evaluation.settings.store') }}" method="POST" id="evaluation_settings_form">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required
                            value="">
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required value="">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Save Setting
                    </button>
                </div>
            </form>
        </div>
        <div class="card p-4">
            <form action="{{ route('send.filtered.email') }}" method="POST" id="sendFilteredEmail">
                @csrf

                <div class="row g-3 align-items-end">
                    <!-- Batch Year -->
                    <div class="col-md-3">
                        <label for="batch_year" class="form-label">Batch Year</label>
                        <select class="form-control" id="batch_year" name="year" required>
                            @for ($year = 2025; $year <= 2027; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Department -->
                    <div class="col-md-3">
                        <label for="department_id" class="form-label">Select Department</label>
                        <select id="department_id" name="department_id" class="form-select" required>
                            <option value="" selected disabled>-- Select Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }} [{{ $department->code }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Batch -->
                    <div class="col-md-3">
                        <label for="batch_id" class="form-label">Select Batch</label>
                        <select id="batch_id" name="batch_id" class="form-select">
                            <option value="" selected disabled>-- Select Batch --</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-3 d-flex justify-content-end align-items-end">
                        <button id="sendFilterEmail" type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-envelope"></i> Send Email
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card p-4 mb-5">
            <h3 class="mb-3">Email Sending Records</h3>
            <div class="col-md-12">

                <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-striped" id="email_record_table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Year</th>
                                <th>Department</th>
                                <th>Batch</th>
                                <th>Email Subject</th>
                                <th>Sending Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


    </div>

    <script>
        $(document).ready(function() {

            $(function() {

                var table = $('#email_record_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('email.record') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        {
                            data: 'year',
                            name: 'year'
                        },
                        {
                            data: 'department',
                            name: 'department'
                        },
                        {
                            data: 'batch',
                            name: 'batch'
                        },
                        {
                            data: 'email_subject',
                            name: 'email_subject'
                        },
                        {
                            data: 'sending_date',
                            name: 'sending_date'
                          
                        },

                    ]
                });

            });

            $('#evaluation_settings_form').ajaxForm({
                beforeSubmit: function() {
                    $('#evaluation_settings_form')[0].reset();
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    if (res.data) {
                        $('#evaluation_start').text(res.data.start_date);
                        $('#evaluation_end').text(res.data.end_date);
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON?.errors;
                    var errorMessage = '';
                    if (errors) {
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n';
                        });
                    } else {
                        errorMessage = 'An error occurred. Please try again.';
                    }
                    showErrorModal(errorMessage);
                }
            });

            $('body').on('click', '#sendEmailBtn', function(e) {
                e.preventDefault();

                // Show loading icon on button
                var $btn = $('#sendEmailBtn');
                var originalHtml = $btn.html();
                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                );

                $.ajax({
                    url: '/send-email',
                    type: 'GET',
                    success: function(res) {
                        showSuccessModal(res.message);
                        $('#email_record_table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON?.errors;
                        var errorMessage = '';
                        if (errors) {
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });
                        } else {
                            errorMessage = 'An error occurred. Please try again.';
                        }
                        showErrorModal(errorMessage);
                    },
                    complete: function() {
                        // Restore button state
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });

            });

            $('#sendFilteredEmail').ajaxForm({
                beforeSubmit: function() {
                    // Show loading on submit button
                    var $btn = $('#sendFilterEmail');
                    $btn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...'
                    );
                    $('#sendFilteredEmail')[0].reset();
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    $('#email_record_table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON?.errors;
                    var errorMessage = '';
                    if (errors) {
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n';
                        });
                    } else {
                        errorMessage = 'An error occurred. Please try again.';
                    }
                    showErrorModal(errorMessage);
                },
                complete: function() {
                    // Restore button state
                    var $btn = $('#sendFilterEmail');
                    $btn.prop('disabled', false).html('<i class="fa fa-envelope"></i> Send Email');
                }
            });


        });
    </script>
@endsection
