<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Autentikasi</title>

    <!-- Memuat CSS Tema Admin -->
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style"/>
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        /* Paksa layout sederhana untuk halaman auth */
        body {
            background-color: #f3f7f9 !important; /* Latar belakang abu-abu dari tema */
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">

                <!-- Logo Perusahaan -->
                <div class="text-center mb-4">
                    <a href="/" class="logo logo-dark text-center">
                        <span class="logo-lg">
                            <!-- Ganti ini jika logo Anda berbeda -->
                            <img src="{{ asset('admin/images/logo-dark.png') }}" alt="Logo" height="24">
                        </span>
                    </a>
                </div>
                
                <!-- Konten (Login atau Register) akan dimuat di sini -->
                @yield('content')
                
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- end container -->
    
    <!-- Memuat JS Vendor (termasuk Bootstrap JS) -->
    <!-- Kita TIDAK memuat app.min.js karena bisa error di luar dashboard -->
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script>
    
</body>
</html>

