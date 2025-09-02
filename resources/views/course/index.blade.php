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
                <h3 class="mb-0">Course Management</h3>
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
            <h5 class="mb-3">Courses</h5>
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

    @include('course.create')
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
                    url: "{{ route('courses.store') }}",
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
                                                                                                                                                        class="btn btn-sm btn-primary showStudentList"
                                                                                                                                                        data-course-id="${course.id}"
                                                                                                                                                        
                                                                                                                                                       data-course-name="${course.name}"
                                                                                                                                            data-department-id="${course.department_id}"
                                                                                                                                            data-teacher-id="${course.teacher_id}"
                                                                                                                                                       
                                                                                                                                                       
                                                                                                                                                        data-year="${course.year}"
                                                                                                                                                        data-batch-id="${course.batch_id}"
                                                                                                                                                    >
                                                                                                                                                        Student List
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


            $(document).on('click', '.showStudentList', function() {

                let course_id = $(this).data('course-id');
                let department_id = $(this).data('department-id');
                let year = $(this).data('year');
                let batch_id = $(this).data('batch-id');
                let course_name = $(this).data('course-name');
                let teacher_id = $(this).data('teacher-id');

                $.ajax({
                    url: "{{ route('student.list') }}",
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        course_id: course_id,
                        department_id: department_id,
                        year: year,
                        course_name: course_name,
                        teacher_id: teacher_id,
                        batch_id: batch_id,
                    },
                    success: function(response) {
                        // Table বানানোর জন্য HTML
                        let html = `
                <h6><strong>Course Name: </strong>${response.course_name}</h6>
                <h6><strong>Course Code: </strong>${response.course_code}</h6>
                <h6><strong>Teacher Name: </strong>${response.teacher_name}</h6>
                <h6><strong>Total Students: </strong>${response.total_students}</h6>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Roll</th>
                            <th>Student Name</th>
                            <th>Student Email</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

                        if (response.student_data && response.student_data.length > 0) {
                            response.student_data.forEach((student, index) => {
                                html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${student.roll ? student.roll : 'N/A'}</td>
                            <td>${student.name}</td>
                            <td>${student.email}</td>
                        </tr>
                    `;
                            });
                        } else {
                            html +=
                                `<tr><td colspan="3" class="text-center">No students found</td></tr>`;
                        }

                        html += `
                    </tbody>
                </table>
            `;

                        // Modal body তে বসানো হবে
                        $('#show_course .modal-body').html(html);
                        $('#show_course').modal('show');
                    },
                    error: function(xhr) {
                        console.error('Error fetching student list:', xhr.responseText);
                    }
                });
            });






        });
    </script>

@endsection
