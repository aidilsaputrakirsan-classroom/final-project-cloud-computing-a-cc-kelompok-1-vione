<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'PawCare') }} - Owner Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}">

    <!-- Third party css -->
    <link href="{{ asset('admin/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="{{ route('owner.dashboard') }}" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="16">
                </span>
            </a>

            <!-- LOGO Dark -->
            <a href="{{ route('owner.dashboard') }}" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="16">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('assets/images/logo_sm_dark.png') }}" alt="" height="16">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navigation</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span class="badge bg-success float-end">4</span>
                            <span> Dashboards </span>
                        </a>
                        <div class="collapse show" id="sidebarDashboards">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ url('/Mypets') }}">My Pets</a>
                                </li>
                                <li>
                                    <a href="{{url('/available-vets')}}">Book Appointment</a>
                                </li>
                                <li>
                                    <a href="{{ route('owner.appointments') }}">My Appointments</a>
                                </li>                                
                                <li>
                                    <a href="{{ route('owner.myadoptions') }}">My adoption <span class="badge rounded bg-danger font-10 float-end">New</span></a>
                                </li>
                                <li><a href="{{ route('owner.shelter.pets') }}">🐾 Adopt a Pet</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        
                        <li class="dropdown notification-list">
                            <!-- FIX: Menggunakan ID dan Onclick Manual untuk mengatasi konflik Script di Footer -->
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" 
                               id="user-dropdown-toggle"
                               onclick="toggleOwnerDropdown(event)"
                               href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar"> 
                                    <img src="{{asset('admin/images/users/avatar-1.jpg')}}" alt="user-image" class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">
                                        @if(session('Adminid'))
                                            {{session('Adminname')}}
                                        @else
                                            {{ Auth::user()->name ?? 'Admin' }}
                                        @endif
                                    </span>
                                </span>
                            </a>
                            <!-- ID Menu Dropdown ditambahkan -->
                            <div id="user-dropdown-menu" class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item: Welcome Header -->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- Form Logout Tersembunyi -->
                                <form method="POST" action="{{ route('logout') }}" id="logout-form-owner" style="display: none;">
                                    @csrf
                                </form>

                                <!-- Tombol Logout dengan Icon -->
                                <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form-owner').submit();" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>
                <!-- end Topbar -->

                <!-- SCRIPT MANUAL: Memaksa dropdown terbuka tanpa bergantung pada Bootstrap Footer -->
                <script>
                    function toggleOwnerDropdown(e) {
                        e.preventDefault();
                        e.stopPropagation(); // Mencegah event bubbling yang mungkin ditutup oleh script lain
                        
                        var menu = document.getElementById('user-dropdown-menu');
                        var toggle = document.getElementById('user-dropdown-toggle');
                        
                        if (menu.classList.contains('show')) {
                            menu.classList.remove('show');
                            toggle.classList.remove('show');
                            toggle.setAttribute('aria-expanded', 'false');
                        } else {
                            menu.classList.add('show');
                            toggle.classList.add('show');
                            toggle.setAttribute('aria-expanded', 'true');
                        }
                    }

                    // Tutup dropdown jika klik di luar area
                    window.addEventListener('click', function(e) {
                        var menu = document.getElementById('user-dropdown-menu');
                        var toggle = document.getElementById('user-dropdown-toggle');
                        
                        if (menu && toggle) {
                            if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                                menu.classList.remove('show');
                                toggle.classList.remove('show');
                                toggle.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                </script>