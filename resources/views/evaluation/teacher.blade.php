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
                <h3 class="mb-0">Evaluated Courses</h3>
            </div>
        </div>

        <div class="card p-4">


            <div class="row g-3">
                <div class="col-md-6">
                    <label for="year" class="form-label">Select Year</label>
                    <select id="year" name="year" class="form-select" required>
                        <option value="" disabled selected>-- Select Year --</option>
                        @php $currentYear = date('Y'); @endphp
                        @for ($y = 2000; $y <= 2050; $y++)
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
    </div>
    <div class="modal fade" id="store_evaluation_form" tabindex="-1" aria-labelledby="store_evaluation_formLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="store_evaluation_formLabel">Evaluation Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body overflow-auto" style="max-height: 90vh;">
                    <div class="p-4">


                        @csrf
                        <input type="hidden" name="course_id" id="course_id">
                        <input type="hidden" name="department_id" id="department_id">
                        <input type="hidden" name="teacher_id" id="teacher_id">

                        <input type="hidden" id="year_hidden" name="year">
                        <input type="hidden" id="batch_id_hidden" name="batch_id">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $key => $question)
                                    <tr>

                                        <td>
                                            <input type="hidden" name="question_ids[]" value="{{ $question->id }}">
                                            <label class="form-label fw-semibold"
                                                data-question-id="{{ $question->id }}">{{ $question->question }}</label>
                                        </td>
                                        <td>
                                            <p class="question-rating" data-question-id="{{ $question->id }}">Loading...
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-right font-semibold">Total: <span id="ratingSum">0</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <p class="mt-4 font-semibold">Total Participants: <span id="totalParticipants">0</span>/<span
                                id="totalStudents">0</span></p>

                    </div>
                </div>

            </div>
        </div>
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
                    url: "{{ route('evaluation.teacher.course') }}",
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
                                            `<button 
                                                                                                            class="btn btn-sm btn-primary btn-evaluate"
                                                                                                            data-course-id="${course.id}"
                                                                                                            data-course-name="${course.name}"
                                                                                                            data-department-id="${course.department_id}"
                                                                                                            data-teacher-id="${course.teacher_id}"
                                                                                                           
                                                                                                            data-year="${course.year}"
                                                                                                            data-batch-id="${course.batch_id}"
                                                                                                        >
                                                                                                            View Evaluation
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
                // Show Modal
                $('#store_evaluation_form').modal('show');

                // Set values into hidden inputs
                $('#course_id').val($(this).data('course-id'));
                $('#department_id').val($(this).data('department-id'));
                $('#teacher_id').val($(this).data('teacher-id'));
                $('#year_hidden').val($(this).data('year'));
                $('#batch_id_hidden').val($(this).data('batch-id'));

                // Prepare data to send
                let course_id = $(this).data('course-id');
                let department_id = $(this).data('department-id');
                let teacher_id = $(this).data('teacher-id');
                let year = $(this).data('year');
                let batch_id = $(this).data('batch-id');

                // Get question_ids[] from table
                let question_ids = [];
                $('input[name="question_ids[]"]').each(function() {
                    question_ids.push($(this).val());
                });

                // Remove old average ratings and comments if exist
                $('.avg-rating-text').remove();
                $('#commentListContainer').remove();

                // Send AJAX POST request
                $.ajax({
                    url: "{{ route('evaluation.data') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        course_id: course_id,
                        department_id: department_id,
                        teacher_id: teacher_id,
                        year: year,
                        batch_id: batch_id,
                        question_ids: question_ids
                    },
                    success: function(response) {
                        // Add Average Rating beside each question
                        response.ratings.forEach(function(rating) {
                            const questionId = rating.question_id;
                            const avg = rating.average_rating;
                            const displayText = avg ? Math.round(avg) : 'No rating yet';
                            $(`p.question-rating[data-question-id="${questionId}"]`)
                                .text(displayText);
                        });

                        $('#ratingSum').text(response.total_average_sum);
                        $('#totalParticipants').text(response.total_students);
                        $('#totalStudents').text(response.total_enrolled_students);
                        // Show Comments as bullet point list
                        if (response.comments && response.comments.length > 0) {
                            let commentBox =
                                '<div id="commentListContainer" class="mt-4"><h6 class="fw-bold">Comments:</h6><ul class="ms-3">';
                            response.comments.forEach(function(comment) {
                                commentBox +=
                                    `<li style="list-style-type: disc;">${comment}</li>`;
                            });
                            commentBox += '</ul></div>';

                            // Append below table
                            $('.modal-body .p-4').append(commentBox);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching evaluation data:', xhr.responseText);
                    }
                });
            });




        });
    </script>

@endsection
