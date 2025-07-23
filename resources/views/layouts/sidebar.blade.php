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

                    
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"><i class="fas fa-user-cog"></i></span><span
                                class="pc-mtext">User
                                Management</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('admin_list') }}">Admin Management</a></li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('roles.index') }}">Role & Permission</a></li>


                        </ul>
                    </li>
                    <li class="pc-item">
                        <a href="../other/sample-page.html" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
                            <span class="pc-mtext">Sample page</span>
                        </a>
                    </li>
                </ul>
                
            </div>
        </div>
    </nav>