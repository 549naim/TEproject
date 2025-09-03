@extends('layouts.master')

@section('content')
    <div class="pc-content">
        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Teaching Evaluation</h3>
            </div>
        </div>
        @if (!$evaluationOpen)
            <div class="alert alert-warning text-center text-lg font-semibold my-8">
                <h4 class="mb-0">Teaching Evaluation is currently closed.</h4>
                <p>Please check back later.</p>
            </div>
        @else
            <div class="card p-4">


                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="year" class="form-label">Select Year</label>
                        <select id="year" name="year" class="form-select" required>
                            <option value="" disabled selected>-- Select Year --</option>
                            @php $currentYear = date('Y'); @endphp
                            @for ($y = 2025; $y <= 2027; $y++)
                                <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="batch_id" class="form-label">Select Batch</label>
                        <select id="batch_id" name="batch_id" class="form-select" required>
                            <option value="" disabled selected>-- Select Batch --</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->name }} [{{ $batch->year }}]</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Table to Show Courses --}}
            <div class="card p-4 mt-4 d-none" id="courseTableCard">
                <h5 class="mb-3">Available Courses</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light text-start">
                            <tr>

                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-start" id="courseTableBody">
                            <!-- Courses will be injected here -->
                        </tbody>
                    </table>
                </div>
            </div>
    
    @include('evaluation.evaluation_form')
    @endif
</div>


    {{-- CSRF Token for AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        $(document).ready(function() {
            const yearSelect = $('#year');
            const batchSelect = $('#batch_id');
            const courseTableCard = $('#courseTableCard');
            const courseTableBody = $('#courseTableBody');

            function fetchCourses() {
                let year = yearSelect.val();
                let batch_id = batchSelect.val();

                if (!year && !batch_id) return;

                $.ajax({
                    url: "{{ route('evaluation.student.course') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        year: year,
                        batch_id: batch_id
                    },
                    beforeSend: function() {
                        courseTableBody.html('<tr><td colspan="4">Loading...</td></tr>');
                        courseTableCard.removeClass('d-none');
                    },
                    success: function(response) {
                        courseTableBody.empty();

                        if (response.length === 0) {
                            courseTableBody.html('<tr><td colspan="4">No courses found.</td></tr>');
                            return;
                        }

                        $.each(response, function(index, course) {
                            courseTableBody.append(`
                                <tr>
                                    
                                    <td>${course.name}</td>
                                    <td>${course.code}</td>
                                    <td>
                                        ${
                                            course.evaluated
                                            ? `<button class="btn btn-sm btn-success" disabled>Evaluated</button>`
                                            : `<button 
                                                                    class="btn btn-sm btn-primary btn-evaluate"
                                                                    data-course-id="${course.id}"
                                                                    data-course-name="${course.name}"
                                                                    data-department-id="${course.department_id}"
                                                                    data-teacher-id="${course.teacher_id}"
                                                                    data-student-id="${course.student_id}"
                                                                    data-year="${course.year}"
                                                                    data-batch-id="${course.batch_id}"
                                                                >
                                                                    Evaluate
                                                                </button>`
                                        }
                                    </td>
                                </tr>

                            `);

                        });

                    },
                    error: function(xhr) {
                        courseTableBody.html(
                            '<tr><td colspan="4" class="text-danger">Error loading courses.</td></tr>'
                        );
                    }
                });
            }

            yearSelect.on('change', fetchCourses);
            batchSelect.on('change', fetchCourses);


            $(document).on('click', '.btn-evaluate', function() {
                $('#store_evaluation_form').modal('show');

                $('#course_id').val($(this).data('course-id'));
                $('#department_id').val($(this).data('department-id'));
                $('#teacher_id').val($(this).data('teacher-id'));
                $('#student_id').val($(this).data('student-id'));
                $('#year_hidden').val($(this).data('year'));
                $('#batch_id_hidden').val($(this).data('batch-id'));
            });

            $('#store_evaluation_form_form').ajaxForm({
                beforeSubmit: function() {
                    $('#store_evaluation_form_form')[0].reset();
                    $('#store_evaluation_form').modal('hide');
                },
                success: function(res) {
                    showSuccessModal(res.message);
                    fetchCourses();
                    $('.star-rating .star').css('color', 'gray');
                     $('#store_evaluation_form_form')[0].reset();
                     location.reload();
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
                    fetchCourses();
                }
            });

        });
    </script>
    <script>
    $(document).ready(function () {
        $('.star-rating .star').on('click', function () {
            const value = $(this).data('value');
            const parent = $(this).closest('.star-rating');
            const questionId = parent.data('question-id');

            parent.find('.star').css('color', 'gray');

            for (let i = 1; i <= value; i++) {
                parent.find(`#star_${questionId}_${i}`).css('color', 'gold');
            }

            $(`#rating_input_${questionId}`).val(value);
        });
    });
</script>

@endsection
