<!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>document.write(new Date().getFullYear())</script> © PawCare
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end footer-links d-none d-md-block">
                            <a href="{{ url('/about') }}">About</a>
                            <a href="javascript: void(0);">Support</a>
                            <a href="javascript: void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div> <!-- container-fluid -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar (Settings Panel) - Biasanya menggunakan script admin/js/app.min.js -->
    <div class="end-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="end-bar-toggle float-end">
                <i class="dripicons-cross noti-icon"></i>
            </a>
            <h5 class="m-0">Settings</h5>
        </div>

        <div class="rightbar-content h-100" data-simplebar>

            <div class="p-3">
                <div class="alert alert-warning" role="alert">
                    <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                </div>

                <!-- Settings content here... -->
                <h5 class="mt-3">Color Scheme</h5>
                <hr class="mt-1" />
                <!-- ... settings checkboxes ... -->
                <h5 class="mt-4">Width</h5>
                <hr class="mt-1" />
                <!-- ... width checkboxes ... -->
                <h5 class="mt-4">Left Sidebar</h5>
                <hr class="mt-1" />
                <!-- ... sidebar settings ... -->
                
                <div class="d-grid mt-4">
                    <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                    <a href="javascript:void(0);"
                        class="btn btn-danger mt-3" target="_blank"><i class="mdi mdi-basket me-1"></i> Buy Theme</a>
                </div>
            </div>
        </div>
    </div>
    <div class="rightbar-overlay"></div>
    <!-- /End-bar -->

    {{-- ==================================================== --}}
    {{-- PERBAIKAN URUTAN SCRIPT: JQUERY WAJIB PERTAMA --}}
    {{-- ==================================================== --}}

    {{-- 1. JQUERY WAJIB PALING ATAS UNTUK MENGHILANGKAN ERROR "$ is not defined" --}}
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    
    {{-- 2. DEPENDENSI TEMA KUSTOM PET CARE --}}
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>

    {{-- 3. SCRIPT KUSTOM (YANG MENGGUNAKAN JQUERY $) --}}
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/wrapper.js') }}"></script>
    
    {{-- 4. SCRIPT TEMA ADMIN (Hyper) yang mengendalikan sidebar settings --}}
    <script src="{{asset('admin/js/app.min.js')}}"></script>

    {{-- 5. SCRIPT INLINE --}}
    <script>
        // Inline script menggunakan jQuery (sekarang sudah aman karena jQuery sudah dimuat)
        setTimeout(function(){
            $("#msg").fadeOut("slow")
        },3000)
    </script>
    
</body>

</html>