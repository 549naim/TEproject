<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <img src="../assets/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="../dashboard/index.html" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>



                {{-- <li class="pc-item">
                        <a href="../pages/login.html" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-lock"></i></span>
                            <span class="pc-mtext">Login</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="../pages/register.html" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
                            <span class="pc-mtext">Register</span>
                        </a>
                    </li> --}}

                @canany(['admin_create'])
                    <li class="pc-item pc-hasmenu">
                        <a class="pc-link"><span class="pc-micon"><i class="fas fa-user-cog"></i></span><span
                                class="pc-mtext">User
                                Management</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin.index') }}">User Management</a>
                            </li>
                             @canany(['role_list', 'role_create', 'role_edit', 'role_delete', 'role_permission_edit'])
                            <li class="pc-item"><a class="pc-link" href="{{ route('roles.index') }}">Role & Permission</a>
                            </li>
                            @endcanany


                        </ul>
                    </li>
                @endcanany
                @canany(['department_management', 'batch_management', 'course_management'])
                    <li class="pc-item pc-hasmenu">
                        <a class="pc-link"><span class="pc-micon"><i class="fas fa-user-cog"></i></span><span
                                class="pc-mtext">Portal
                                Management</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('departments.index') }}">Department</a>
                            </li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('batches.index') }}">Batch</a></li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('courses.index') }}">Course</a></li>
                           
                            {{-- <li class="pc-item"><a class="pc-link" href="{{ route('roles.index') }}">Role & Permission</a></li> --}}


                        </ul>
                    </li>
                @endcanany
                @canany(['question_management'])
                    <li class="pc-item">
                        <a href="{{ route('questions.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="fas fa-question-circle"></i></span>
                            <span class="pc-mtext">Question Upload</span>
                        </a>
                    </li>
                @endcanany
                @canany(['course_upload'])
                    <li class="pc-item">
                        <a href="{{ route('courses.upload') }}" class="pc-link">
                            <span class="pc-micon"><i class="fas fa-book"></i></span>
                            <span class="pc-mtext">Course Upload</span>
                        </a>
                    </li>
                @endcanany
                @canany(['teacher_evaluation'])
                    <li class="pc-item">
                        <a href="{{ route('evaluation.teacher') }}" class="pc-link">
                            <span class="pc-micon"><i class="fas fa-book"></i></span>
                            <span class="pc-mtext">Course Evaluated</span>
                        </a>
                    </li>
                @endcanany
                @canany(['student_evaluation'])
                    <li class="pc-item">
                        <a href="{{ route('evaluation.student') }}" class="pc-link">
                            <span class="pc-micon"><i class="fas fa-book"></i></span>
                            <span class="pc-mtext">Teaching Evaluation</span>
                        </a>
                    </li>
                @endcanany
            </ul>

        </div>
    </div>
</nav>
