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
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <label for="department_id" class="form-label">Select Department</label>
                    <select id="department_id" name="department_id" class="form-select" required>
                        <option value="" selected disabled>-- Select Department --</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }} [{{ $department->code }}]
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
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
                            <th>Course Teacher</th>
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



                <div class="modal-body overflow-auto" id="evaluation_data" style="max-height: 90vh;">
                    <div class="p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Course Code:</strong> <span id="modalCourseCode"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Course Name:</strong> <span id="modalCourseName"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Department:</strong> <span id="modalDepartment"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Teacher:</strong> <span id="modalTeacher"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Year:</strong> <span id="modalYear"></span>
                            </div>
                        </div>



                        <input type="hidden" name="course_id" id="course_id">
                        <input type="hidden" name="department_id" id="department_id">
                        <input type="hidden" name="teacher_id" id="teacher_id">

                        <input type="hidden" id="year_hidden" name="year">
                        <input type="hidden" id="batch_id_hidden" name="batch_id">
                        <table class="table table-bordered table-striped">
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="evaluatePrint">Print</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            const departmentSelect = $('#department_id');
            const courseTableCard = $('#courseTableCard');
            const courseTableBody = $('#courseTableBody');

            function fetchCourses() {
                let year = yearSelect.val();
                let batch_id = batchSelect.val();
                let department_id = departmentSelect.val();

                if (!year && !batch_id && !department_id) return;

                $.ajax({
                    url: "{{ route('evaluation.teacher.report') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        year: year,
                        batch_id: batch_id,
                        department_id: department_id
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
                                    <td>${course.teacher_name}</td>
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
                        $('#modalCourseCode').text(response.course_code);
                        $('#modalCourseName').text(response.course_name);
                        $('#modalDepartment').text(response.department_name);
                        $('#modalTeacher').text(response.teacher_name);
                        $('#modalYear').text(response.year);
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

            $(document).on('click', '#evaluatePrint', function() {
                var printContents = document.getElementById('evaluation_data').innerHTML;
                var printWindow = window.open('', '', 'height=800,width=1000');
                printWindow.document.write('<html><head><title>Evaluation Data</title>');
                // Inline Bootstrap and custom styles for modal body look
                printWindow.document.write(
                    `<link rel="stylesheet" href="{{ asset('css/app.css') }}">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body {
                            background: #f8fafc;
                            margin: 0;
                            padding: 0;
                        }
                        .modal-content {
                            border-radius: 0.5rem;
                            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
                            background: #fff;
                            margin: 40px auto;
                            max-width: 900px;
                            padding: 0;
                        }
                        .modal-header, .modal-footer {
                            display: none;
                        }
                        .modal-body {
                            border-radius: 0.5rem;
                            background: #fff;
                            padding: 1.5rem !important;
                        }
                        .p-4 { padding: 1.5rem !important; }
                        .table { width: 100%; border-collapse: collapse; }
                        .table-bordered th, .table-bordered td { border: 1px solid #dee2e6 !important; }
                        .table thead th { background: #f1f1f1; }
                        .fw-semibold, .font-semibold { font-weight: 600; }
                        h6.fw-bold { margin-top: 1rem; }
                        ul.ms-3 { margin-left: 1rem; }
                        .row { display: flex; flex-wrap: wrap; margin-right: -12px; margin-left: -12px; }
                        .col-md-6 { flex: 0 0 auto; width: 50%; padding-right: 12px; padding-left: 12px; }
                        .mb-3 { margin-bottom: 1rem !important; }
                        .mt-4 { margin-top: 1.5rem !important; }
                        .text-right { text-align: right !important; }
                    </style>`
                );
                printWindow.document.write('</head><body>');
                printWindow.document.write(
                    '<div class="modal-content"><div class="modal-body overflow-auto" style="max-height: 90vh;">'
                    );
                printWindow.document.write(printContents);
                printWindow.document.write('</div></div>');
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                setTimeout(function() {
                    printWindow.print();
                    printWindow.close();
                }, 500);
            });




        });
    </script>

@endsection
