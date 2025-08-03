@extends('layouts.master')

@section('content')
    <div class="pc-content">

        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Evaluation Setting</h3>
                <a href="" id="sendEmailBtn" class="btn btn-success">
                    <i class="fa fa-envelope"></i> Send Email
                </a>
            </div>
            @if (isset($evaluationSetting->start_date) && isset($evaluationSetting->end_date))
                <div class="alert alert-success d-flex justify-content-between align-items-center p-3 rounded mb-3">
                    <h4 class="mb-0">
                        Teaching Evaluation Date From {{ $evaluationSetting->start_date }} To
                        {{ $evaluationSetting->end_date }}
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

    </div>

    <script>
        $(document).ready(function() {

            $('#evaluation_settings_form').ajaxForm({
                beforeSubmit: function() {
                    $('#evaluation_settings_form')[0].reset();
                },
                success: function(res) {
                    showSuccessModal(res.message);
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


        });
    </script>
@endsection
