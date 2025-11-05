<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from winsfolio.net/html/patte/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Sep 2025 20:21:26 GMT -->

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PawCare</title>
  <link rel="icon" href="assets/img/heading-img.png">
  <!-- CSS only -->
   <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
   <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
   <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
   <link rel="stylesheet" href="assets/css/slick.css">
   <link rel="stylesheet" href="assets/css/slick-theme.css">
   <!-- fancybox -->
   <link rel="stylesheet" href="assets/css/jquery.fancybox.min.css">
   <link rel="stylesheet" href="assets/css/fontawesome.min.css">
   <!-- style -->
   <link rel="stylesheet" href="assets/css/style.css">
   <!-- responsive -->
   <link rel="stylesheet" href="assets/css/responsive.css">
   <!-- color -->
   <link rel="stylesheet" href="assets/css/color.css">
   <!-- jQuery -->
   <script src="assets/js/jquery-3.6.0.min.js"></script>
   <script src="assets/js/preloader.js"></script>
   <style>
.login {
  position: relative;
  display: inline-block;
  margin-left: 20px; /* thoda gap left side se */
}

.login > a, 
.login > span {
  display: inline-block;
  padding: 10px 15px;
  color: #333;
  text-decoration: none;
  font-size: 14px;
  cursor: pointer;
}

.dropdown {
  display: none;
  position: absolute;
  top: 100%; /* parent ke bilkul niche */
  right: 0; /* right side align */
  background: #fff;
  border: 1px solid #ddd;
  min-width: 160px;
  z-index: 1000;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.dropdown a {
  display: block;
  padding: 10px 15px;
  color: #333;
  text-decoration: none;
  font-size: 14px;
}

.dropdown a:hover {
  background: #f5f5f5;
}

.login:hover .dropdown {
  display: block;
}
</style>
 </head>
<body>
<!-- loader -->
<div class="preloader"> 
    <div class="container">
      <div class="dot dot-1"></div>
      <div class="dot dot-2"></div>
      <div class="dot dot-3"></div>
    </div>
</div>
<!-- loader end -->
<header>
  <div class="top-bar">
    <div class="container">
      <div class="top-bar-slid">
        <div>
          <div class="phone-data">
            <div class="phone">
              <i>
            </div>
            <div class="phone d-flax align-items-center">
            </div>
          </div>
        </div>
        <div>
<div class="login">
  @auth
    <span style="color: rgb(204, 59, 6); font-weight: bold;">
      <i class="fa-solid fa-user"></i> {{ Auth::user()->name }}
    </span>
    <div class="dropdown">
      <a href="{{ url('/' . Auth::user()->role . '-dashboard') }}">My Dashboard</a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
      </form>  </div>
  @else
    <i class="fa-solid fa-user"></i>
    <a href="{{route('login')}}">Login</a>
     <a href="{{ route('register') }}">Register </a>
      
    {{-- <div class="dropdown">
     <a href="{{url('/ownerregister')}}">Pet Owner</a>
      <a href="{{url('/shelter')}}">Shelter</a>
      <a href="{{url('/vetregister')}}">Vet</a>
    </div> --}}
  @endauth
</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="bottom-bar">
      <a href="index-2.html"><img src="assets/img/logo.png" alt="logo"></a>
        <nav class="navbar">
        <ul class="navbar-links">
                    {{-- <li class="navbar-dropdown"> --}}
                      <li class="navbar-dropdown">
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                      {{-- <div class="dropdown">
                        <a href="index-2.html">home 1</a>
                        <a href="index-3.html">home 2</a>
                        <a href="index-4.html">home 3</a>
                      </div> --}}
                    </li>
                    <li class="navbar-dropdown">
                      <a href="{{ url('/about') }}">About</a>
                    </li>
                     <li class="navbar-dropdown">
                      <a href="{{ url('/services') }}">services</a>
                       
                    </li>
                    {{-- <li class="navbar-dropdown menu-item-children">
                      <a href="javascript:void(0)"><i>
                      </i>services</a>
                      <div class="dropdown">
                        <a href="{{ url('/services') }}">services</a>
                        <a href="service-details.html">service details</a>
                      </div>
                    </li> --}}
                    {{-- <li class="navbar-dropdown menu-item-children">
                      <a href="javascript:void(0)">pages</a>
                      <div class="dropdown">
                        <a href="team-details.html">team details</a>
                        <a href="how-we-works.html">how we works</a>
                        <a href="history.html">history</a>
                        <a href="pricing-packages.html">pricing packages</a>
                        <a href="photo-gallery.html">photo gallery</a>
                        <a href="login.html">login</a>
                      </div>
                    </li>
                    <li class="navbar-dropdown menu-item-children">
                    <li class="navbar-dropdown menu-item-children">
                      <a href="javascript:void(0)">News</a>
                      <div class="dropdown">
                        <a href="our-blog.html">our blog</a>
                        <a href="blog-details.html">blog details</a>
                      </div>
                    </li>
                    <li class="navbar-dropdown">
                      <a href="contact.html">Contact</a>
                    </li> --}}
        </ul>
      </nav>
      <div class="menu-end">
            <div class="bar-menu">
              <i class="fa-solid fa-bars"></i>
            </div>>

  </a>
</span>

              </div>
            </div>
      </div>
    </div>
  </div>
  <div class="mobile-nav hmburger-menu" id="mobile-nav" style="display:block;">
      <div class="res-log">
        <a href="index-2.html">
          <img src="assets/img/logo-w.png" alt="Responsive Logo">
        </a>
      </div>
        <ul>

          <li class="menu-item-has-children"><a href="JavaScript:void(0)">Home</a>
            <ul class="sub-menu">

              <li><a href="index-2.html">home 1</a></li>
              <li><a href="index-3.html">home 2</a></li>
              <li><a href="index-4.html">home 3</a></li>
            </ul>
          </li>
          <li><a href="about.html">about</a></li>

          
          <li class="menu-item-has-children"><a href="JavaScript:void(0)">Services</a>

          <ul class="sub-menu">

            <li><a href="services.html">services</a></li>
            <li><a href="service-details.html">service details</a></li>

          </ul>

          </li>
          <li class="menu-item-has-children"><a href="JavaScript:void(0)">pages</a>
              <ul class="sub-menu">
                <li><a href="team-details.html">team details</a></li>
                <li><a href="how-we-works.html">how we works</a></li>
                <li><a href="history.html">history</a></li>
                <li><a href="pricing-packages.html">pricing packages</a></li>
                <li><a href="photo-gallery.html">photo gallery</a></li>
                <li><a href="login.html">login</a></li>
              </ul>

          </li>
          <li class="menu-item-has-children"><a href="JavaScript:void(0)">News</a>

              <ul class="sub-menu">
                <li><a href="our-blog.html">our blog</a></li>
               <li><a href="blog-details.html">blog details</a></li>
              
              </ul>

          </li>

          <li><a href="contact.html">contacts</a></li>

          </ul>

            <ul class="social-icon">
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
            </ul>

          <a href="JavaScript:void(0)" id="res-cross"></a>
  </div>
</header>