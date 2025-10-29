<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') | PawCare</title>

    <!-- Custom fonts and styles -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard-hewan') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-paw"></i>
                </div>
                <div class="sidebar-brand-text mx-3">PawCare Portal</div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item {{ request()->routeIs('dashboard-hewan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard-hewan') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Layanan Hewan</div>

            <!-- Buat Janji Pemeriksaan -->
            <li class="nav-item {{ request()->routeIs('Pendaftaran.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('Pendaftaran.index') }}">
                    <i class="fas fa-fw fa-calendar-plus"></i>
                    <span>Buat Janji Pemeriksaan</span>
                    <span class="badge badge-success badge-pill ml-2">Baru</span>
                </a>
            </li>

            <!-- Jadwal Pemeriksaan -->
            <li class="nav-item {{ request()->routeIs('hewan.jadwal-periksa') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('hewan.jadwal-periksa') }}">
                    <i class="fas fa-fw fa-calendar-alt"></i>
                    <span>Jadwal Pemeriksaan</span>
                    @php
                        $upcomingCount = Auth::user()->datahewan ?
                            App\Models\Antrian::where('user_id', Auth::user()->datahewan->id)
                                ->whereDate('tanggal_berobat', '>=', now())
                                ->count() : 0;
                    @endphp
                    @if($upcomingCount > 0)
                        <span class="badge badge-info badge-pill ml-2">{{ $upcomingCount }}</span>
                    @endif
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Riwayat & Data Hewan</div>

            <!-- Riwayat Booking -->
            <li class="nav-item {{ request()->routeIs('antrian.index2') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('antrian.index2') }}">
                    <i class="fas fa-fw fa-history"></i>
                    <span>Riwayat Booking</span>
                </a>
            </li>

            <!-- Rekam Kesehatan -->
            <li class="nav-item {{ request()->routeIs('hewan.riwayat-periksa') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('hewan.riwayat-periksa') }}">
                    <i class="fas fa-fw fa-file-medical"></i>
                    <span>Rekam Kesehatan Hewan</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">Akun & Profil</div>

            <!-- Data Pemilik -->
            <li class="nav-item {{ request()->routeIs('hewan.show') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('hewan.show', Auth::user()->datahewan ? Auth::user()->datahewan->id : 'create') }}">
                    <i class="fas fa-fw fa-id-card"></i>
                    <span>Data Pemilik Hewan</span>
                    @if(!Auth::user()->datahewan)
                        <span class="badge badge-danger badge-pill ml-2">Belum Lengkap</span>
                    @endif
                </a>
            </li>

            <!-- Pengaturan Profil -->
            <li class="nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <i class="fas fa-fw fa-user-cog"></i>
                    <span>Pengaturan Profil</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link" href="#" id="logout-sidebar-item">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <div class="sidebar-card d-none d-lg-flex bg-gradient-info text-white mt-4">
                <p class="text-center mb-2"><strong>Jam Layanan Klinik</strong><br>
                <i class="fas fa-clock mr-1"></i> 08:00 - 16:00 WIB</p>
            </div>
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0">
                        <span class="badge badge-primary p-2">
                            <i class="fas fa-calendar-day mr-1"></i> {{ now()->format('l, d F Y') }}
                        </span>
                    </div>

                    <ul class="navbar-nav ml-auto">
                        <!-- Notifikasi -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                @if($upcomingCount > 0)
                                <span class="badge badge-danger badge-counter">{{ $upcomingCount }}</span>
                                @endif
                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Notifikasi</h6>
                                @if($upcomingCount > 0)
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('hewan.jadwal-periksa') }}">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-calendar-check text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ now()->format('d M Y') }}</div>
                                        <span class="font-weight-bold">Anda memiliki {{ $upcomingCount }} jadwal pemeriksaan hewan mendatang</span>
                                    </div>
                                </a>
                                @else
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('Pendaftaran.index') }}">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-calendar-plus text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ now()->format('d M Y') }}</div>
                                        Belum ada jadwal pemeriksaan untuk hewanmu
                                    </div>
                                </a>
                                @endif
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('hewan.jadwal-periksa') }}">Lihat Semua Jadwal</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Profil User -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->nama_user }}</span>
                                @if(Auth::user()->foto_user)
                                    <img class="img-profile rounded-circle" src="{{ asset('storage/foto_user/' . Auth::user()->foto_user) }}" alt="{{ Auth::user()->nama_user }}">
                                @else
                                    <img class="img-profile rounded-circle" src="{{ asset('img/default.jpg') }}" alt="Default Profile">
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profil
                                </a>
                                <a class="dropdown-item" href="{{ route('hewan.show', Auth::user()->datahewan ? Auth::user()->datahewan->id : 'create') }}">
                                    <i class="fas fa-id-card fa-sm fa-fw mr-2 text-gray-400"></i> Data Pemilik Hewan
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="logout-menu-item">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    <input type="hidden" id="success-message" value="{{ session('success') }}">
                    <input type="hidden" id="error-message" value="{{ session('error') }}">

                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PawCare 2025</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

    <!-- Core Scripts -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Pilih "Logout" jika kamu ingin keluar dari PawCare.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('logout-form').submit();
            });
        }

        document.getElementById('logout-menu-item').addEventListener('click', confirmLogout);
        document.getElementById('logout-sidebar-item').addEventListener('click', confirmLogout);

        document.addEventListener('DOMContentLoaded', function() {
            const success = document.getElementById('success-message')?.value;
            const error = document.getElementById('error-message')?.value;

            if (success) Swal.fire({ icon: 'success', title: 'Berhasil!', text: success, timer: 3000 });
            if (error) Swal.fire({ icon: 'error', title: 'Gagal!', text: error, timer: 3000 });
        });
    </script>

    @stack('scripts')
</body>
</html>
