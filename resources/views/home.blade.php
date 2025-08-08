@extends('layouts.master')

@section('content')
    <style>
        .gradient-card {
            border: 2px solid transparent;
            border-radius: 12px;
            background-image: linear-gradient(#fff, #fff),
                              linear-gradient(45deg, #3d71e2c4, #536c97bd);
            background-origin: border-box;
            background-clip: content-box, border-box;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
        }
        .gradient-card:hover {
            transform: translateY(-4px);
        }
        .gradient-card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px;
            background: linear-gradient(135deg, #fdfbfb, #ebedee);
            border-radius: 10px;
        }
        .gradient-card-body h6 {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 4px;
        }
        .gradient-card-body h4 {
            font-weight: bold;
            margin: 0;
        }
        .gradient-icon {
            font-size: 32px;
            color: #2575fc;
            opacity: 0.85;
        }
    </style>

    <div class="pc-content">
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Total Department</h6>
                            <h4>{{ $departments }}</h4>
                        </div>
                        <i class="fas fa-building gradient-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Total Courses</h6>
                            <h4>{{ $courses }}</h4>
                        </div>
                        <i class="fas fa-book-open gradient-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Total Teacher</h6>
                            <h4>{{ $teacher }}</h4>
                        </div>
                        <i class="fas fa-chalkboard-teacher gradient-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Total Student</h6>
                            <h4>{{ $student }}</h4>
                        </div>
                        <i class="fas fa-user-graduate gradient-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Total Evaluation Questions</h6>
                            <h4>{{ $question }}</h4>
                        </div>
                        <i class="fas fa-question-circle gradient-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Total User</h6>
                            <h4>{{ $users }}</h4>
                        </div>
                        <i class="fas fa-users gradient-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Total Course Evaluated</h6>
                            <h4>{{ $evaluatedCourses }}</h4>
                        </div>
                        <i class="fas fa-clipboard-check gradient-icon"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="gradient-card">
                    <div class="gradient-card-body">
                        <div>
                            <h6>Last Evaluation Date</h6>
                            <h5>{{ $evaluationDate->start_date }} To {{ $evaluationDate->end_date }}</h5>
                        </div>
                        <i class="fas fa-calendar-alt gradient-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
