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

        {{-- Display Session Error Message --}}
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0">Upload Course Wise Data</h1>

                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_question">
                    <i class="fas fa-plus-circle"></i> Create
                </button> --}}
            </div>

        </div>
        <div class="row">
            <div class="card p-4">
                <h5 class="mb-3">Course Data Upload</h5>

                <form action="{{ route('courses.import') }}" method="POST" enctype="multipart/form-data"
                    id="course_upload_form">
                    @csrf

                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year</label>
                        <select id="year" name="year" class="form-select" required>
                            <option value="" selected disabled>-- Select Year --</option>
                            @for ($y = 2000; $y <= 2050; $y++)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="department_id" class="form-label">Select Department</label>
                        <select id="department_id" name="department_id" class="form-select" required>
                            <option value="" selected disabled>-- Select Department --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}[{{ $department->code }}]
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="batch_id" class="form-label">Select Batch</label>
                        <select id="batch_id" name="batch_id" class="form-select" required>
                            <option value="" selected disabled>-- Select Batch --</option>
                            @foreach ($batches as $batch)
                                <option value="{{ $batch->id }}">{{ $batch->name }}[{{ $batch->year }}]</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="course_excel" class="form-label">Upload Course Excel</label>
                        <input type="file" id="course_excel" name="course_excel" class="form-control"
                            accept=".xlsx,.xls" />
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="course_name" class="form-label">Course Name</label>
                                <input type="text" id="course_name" name="course_name" class="form-control"
                                    placeholder="Course Name">
                            </div>
                            <div class="mb-3">
                                <label for="course_code" class="form-label">Course Code</label>
                                <input type="text" id="course_code" name="course_code" class="form-control"
                                    placeholder="Course Code">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="teacher_name" class="form-label">Teacher Name</label>
                                <input type="text" id="teacher_name" name="teacher_name" class="form-control"
                                    placeholder="Teacher Name">
                            </div>
                            <div class="mb-3">
                                <label for="teacher_email" class="form-label">Teacher Email</label>
                                <input type="email" id="teacher_email" name="teacher_email" class="form-control"
                                    placeholder="Teacher Email">
                            </div>
                        </div>
                        <div class="col">
                            <div id="student-fields">
                                <div class="student-row mb-3 d-flex gap-2 align-items-end">
                                    <div class="flex-grow-1">
                                        <label for="student_name" class="form-label">Student Name</label>
                                        <input type="text" name="student_name[]" class="form-control"
                                            placeholder="Student Name">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label for="student_email" class="form-label">Student Email</label>
                                        <input type="email" name="student_email[]" class="form-control"
                                            placeholder="Student Email">
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm remove-student"
                                        style="display: none">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-student">
                                <i class="fas fa-plus-circle"></i> Add More
                            </button>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>

        </div>

    </div>


    <script>
        $(document).ready(function() {
            var $form = $('#course_upload_form');
            var $submitBtn = $form.find('button[type="submit"]');
            var spinnerHtml = '<button type="button" class="btn btn-primary" disabled id="spinner-btn"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...</button>';

            $form.ajaxForm({
                beforeSubmit: function() {
                    $submitBtn.hide();
                    $submitBtn.after(spinnerHtml);
                },
                success: function(res) {
                    $('#spinner-btn').remove();
                    $form[0].reset();
                    $submitBtn.show();
                    showSuccessModal(res.message);
                },
                error: function(xhr) {
                    $('#spinner-btn').remove();
                     $form[0].reset();
                    $submitBtn.show();
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
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addBtn = document.getElementById('add-student');
            const studentFields = document.getElementById('student-fields');

            addBtn.addEventListener('click', () => {
                const newRow = document.createElement('div');
                newRow.classList.add('student-row', 'mb-3', 'd-flex', 'gap-2', 'align-items-end');

                newRow.innerHTML = `
                <div class="flex-grow-1">
                    <input type="text" name="student_name[]" class="form-control" placeholder="Student Name" >
                </div>
                <div class="flex-grow-1">
                    <input type="email" name="student_email[]" class="form-control" placeholder="Student Email" >
                </div>
                <button type="button" class="btn btn-danger btn-sm remove-student">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;

                studentFields.appendChild(newRow);
            });

            studentFields.addEventListener('click', function(e) {
                if (e.target.closest('.remove-student')) {
                    const row = e.target.closest('.student-row');
                    row.remove();
                }
            });
        });
    </script>
@endsection
