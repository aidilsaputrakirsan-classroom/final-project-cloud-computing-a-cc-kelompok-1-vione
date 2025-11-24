@extends('layouts.frontend')

@section('content')
<section class="hero-section" style="background-color: #fff8e5; background-image:url(assets/img/background.png)">
    <div class="container">
        <div class="row hero-one-slider owl-carousel owl-theme">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="hero-text">
                            <h1>Happy Pets, Happier Owners</h1>
                            <h3>Perawatan dan kasih sayang terbaik untuk hewan kesayangan Anda.</h3>
                            {{-- PERUBAHAN: Mengarah ke halaman login --}}
                            <a href="{{ route('login') }}" class="button">Get Appointment</a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="hero-img">
                            <img src="assets/img/hero-img-1.png" alt="img">
                            <img src="assets/img/hero-shaps.png" alt="hero-shaps" class="img-1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="hero-text">
                            <h1>Healthy Pets, Happy People</h1>
                            <h3>Kami membantu menjaga kesehatan, kebersihan, dan kebahagiaan hewan peliharaan Anda setiap hari</h3>
                            {{-- PERUBAHAN: Mengarah ke halaman login --}}
                            <a href="{{ route('login') }}" class="button">Get Appointment</a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="hero-img">
                            <img src="assets/img/slide-3.png" alt="img">
                            <img src="assets/img/hero-shaps.png" alt="hero-shaps" class="img-1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="hero-text">
                            <h1>Take a Good Care of Pets</h1>
                            <h3>Layanan profesional yang memastikan kesehatan dan kenyamanan hewan Anda</h3>
                            {{-- PERUBAHAN: Mengarah ke halaman login --}}
                            <a href="{{ route('login') }}" class="button">Get Appointment</a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="hero-img">
                            <img src="assets/img/slide-2.png" alt="img">
                            <img src="assets/img/hero-shaps.png" alt="hero-shaps" class="img-1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img src="assets/img/hero-shaps-1.png" alt="hero-shaps" class="img-2">
    <img src="assets/img/dabal-foot-1.png" alt="hero-shaps" class="img-3">
    <img src="assets/img/hero-shaps-1.png" alt="hero-shaps" class="img-4">
</section> 
<section class="gap no-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="we-provide">
                    <div class="we-provide-img">
                        <img src="assets/img/we-provide-1.jpg" alt="we-provide-1">
                        <svg width="326" height="326" viewBox="0 0 673 673" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.82698 416.603C-19.0352 298.701 18.5108 173.372 107.497 90.7633L110.607 96.5197C24.3117 177.199 -12.311 298.935 15.0502 413.781L9.82698 416.603ZM89.893 565.433C172.674 654.828 298.511 692.463 416.766 663.224L414.077 658.245C298.613 686.363 175.954 649.666 94.9055 562.725L89.893 565.433ZM656.842 259.141C685.039 374.21 648.825 496.492 562.625 577.656L565.413 582.817C654.501 499.935 691.9 374.187 662.536 256.065L656.842 259.141ZM581.945 107.518C499.236 18.8371 373.997 -18.4724 256.228 10.5134L259.436 16.4515C373.888 -10.991 495.248 25.1518 576.04 110.708L581.945 107.518Z" fill="#fedc4f"/>
                        </svg>

                    </div>
                    <a href="#"><h5>Di Sini, Hewan Kesayangan Diperlakukan Seperti Keluarga</h5></a>
                    <p>Memberi mereka rasa aman, perhatian, dan kasih yang membuat hari-hari mereka lebih bahagia.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="we-provide">
                    <div class="we-provide-img">
                        <img src="assets/img/we-provide-2.jpg" alt="we-provide-1">
                        <svg width="326" height="326" viewBox="0 0 673 673" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.82698 416.603C-19.0352 298.701 18.5108 173.372 107.497 90.7633L110.607 96.5197C24.3117 177.199 -12.311 298.935 15.0502 413.781L9.82698 416.603ZM89.893 565.433C172.674 654.828 298.511 692.463 416.766 663.224L414.077 658.245C298.613 686.363 175.954 649.666 94.9055 562.725L89.893 565.433ZM656.842 259.141C685.039 374.21 648.825 496.492 562.625 577.656L565.413 582.817C654.501 499.935 691.9 374.187 662.536 256.065L656.842 259.141ZM581.945 107.518C499.236 18.8371 373.997 -18.4724 256.228 10.5134L259.436 16.4515C373.888 -10.991 495.248 25.1518 576.04 110.708L581.945 107.518Z" fill="#fb5e3c"/>
                        </svg>
                    </div>
                    <a href="#"><h5>Kasih Sayang untuk Teman Berbulu Anda</h5></a>
                    <p>Setiap hewan memiliki cerita, dan kami ada untuk memastikan kisah mereka penuh kebahagiaan, kenyamanan, dan cinta.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="we-provide mb-0">
                    <div class="we-provide-img">
                        <img src="assets/img/we-provide-3.jpg" alt="we-provide-1">
                        <svg width="326" height="326" viewBox="0 0 673 673" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.82698 416.603C-19.0352 298.701 18.5108 173.372 107.497 90.7633L110.607 96.5197C24.3117 177.199 -12.311 298.935 15.0502 413.781L9.82698 416.603ZM89.893 565.433C172.674 654.828 298.511 692.463 416.766 663.224L414.077 658.245C298.613 686.363 175.954 649.666 94.9055 562.725L89.893 565.433ZM656.842 259.141C685.039 374.21 648.825 496.492 562.625 577.656L565.413 582.817C654.501 499.935 691.9 374.187 662.536 256.065L656.842 259.141ZM581.945 107.518C499.236 18.8371 373.997 -18.4724 256.228 10.5134L259.436 16.4515C373.888 -10.991 495.248 25.1518 576.04 110.708L581.945 107.518Z" fill="#fedc4f"/>
                        </svg>
                    </div>
                    <a href="#"><h5> Merawat dengan Hati, Menyayangi Sepanjang Hari</h5></a>
                    <p>Kami percaya bahwa hewan bukan sekadar peliharaan, mereka adalah keluarga yang pantas dicintai dan dijaga dengan sepenuh hati.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="gap no-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="welcome-to">
                    <h2>Selamat Datang di Layanan Pawcare</h2>
                    <p>PawCare menyediakan berbagai fitur yang mendukung proses layanan kesehatan hewan, mulai dari sistem booking layanan online, manajemen data hewan peliharaan, pencatatan rekam medis digital, hingga laporan layanan yang dapat diakses kapan saja.</p>
                    <div class="row mt-lg-5">
                        <div class="col-md-6">
                            <div class="pet-grooming">
                            <i><img src="assets/img/welcome-to-1.png" alt="icon"></i>
                            <svg width="138" height="138" viewBox="0 0 673 673" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.82698 416.603C-19.0352 298.701 18.5108 173.372 107.497 90.7633L110.607 96.5197C24.3117 177.199 -12.311 298.935 15.0502 413.781L9.82698 416.603ZM89.893 565.433C172.674 654.828 298.511 692.463 416.766 663.224L414.077 658.245C298.613 686.363 175.954 649.666 94.9055 562.725L89.893 565.433ZM656.842 259.141C685.039 374.21 648.825 496.492 562.625 577.656L565.413 582.817C654.501 499.935 691.9 374.187 662.536 256.065L656.842 259.141ZM581.945 107.518C499.236 18.8371 373.997 -18.4724 256.228 10.5134L259.436 16.4515C373.888 -10.991 495.248 25.1518 576.04 110.708L581.945 107.518Z" fill="#940c69"/>
                            </svg>
                            <a href="#"><h4>Vet Appointment</h4></a>
                            <p>Layanan konsultasi dan pemeriksaan kesehatan hewan oleh dokter profesional untuk memastikan mereka tetap sehat dan terlindungi.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pet-grooming mb-0">
                            <i><img src="assets/img/welcome-to-2.png" alt="icon"></i>
                            <svg width="138" height="138" viewBox="0 0 673 673" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.82698 416.603C-19.0352 298.701 18.5108 173.372 107.497 90.7633L110.607 96.5197C24.3117 177.199 -12.311 298.935 15.0502 413.781L9.82698 416.603ZM89.893 565.433C172.674 654.828 298.511 692.463 416.766 663.224L414.077 658.245C298.613 686.363 175.954 649.666 94.9055 562.725L89.893 565.433ZM656.842 259.141C685.039 374.21 648.825 496.492 562.625 577.656L565.413 582.817C654.501 499.935 691.9 374.187 662.536 256.065L656.842 259.141ZM581.945 107.518C499.236 18.8371 373.997 -18.4724 256.228 10.5134L259.436 16.4515C373.888 -10.991 495.248 25.1518 576.04 110.708L581.945 107.518Z" fill="#940c69"/>
                            </svg>
                            <a href="#"><h4>Pet Adoption</h4></a>
                            <p>Temukan teman berbulu yang membutuhkan rumah baru. Adopsi sekarang dan berikan mereka kehidupan yang penuh cinta.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="dog-walker two d-block">
                    <img src="assets/img/puppies.png" class="puppies" alt="puppies">
                    <img src="assets/img/dog-walker-1.png" class="w-100" alt="dog walker">
                    <img src="assets/img/line.png" class="line" alt="line">
                    <img src="assets/img/dabal-foot.png" class="dabal-foot" alt="dabal-foot">
                    <img src="assets/img/haddi.png" class="haddi" alt="haddi">
                </div>
            </div>
        </div>
    </div>
</section> 

<section class="gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="count-text">
                    <img alt="img" src="assets/img/fun-facts-1.png">
                    <div>
                    <div class="d-flex justify-content-center">
                        <h2 class="count" data-number="100" ></h2>
                        <span>+</span>
                    </div>
                    <h3 class="text">Client Served</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="count-text">
                    <img alt="img" src="assets/img/fun-facts-2.png">
                    <div>
                    <div class="d-flex justify-content-center">
                        <h2 class="count" data-number="99" ></h2>
                        <span>%</span>
                    </div>
                    <h3 class="text">Client Served</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="count-text mb-sm-0">
                    <img alt="img" src="assets/img/fun-facts-3.png">
                    <div>
                    <div class="d-flex justify-content-center">
                        <h2 class="count" data-number="2" ></h2>
                        <span>k</span>
                    </div>
                    <h3 class="text">Client Served</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="count-text mb-0">
                    <img alt="img" src="assets/img/fun-facts-4.png">
                    <div>
                    <div class="d-flex justify-content-center">
                        <h2 class="count" data-number="400" ></h2>
                        <span>+</span>
                    </div>
                    <h3 class="text">Client Served</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 

<section class="section-client gap" style="background-image: url(assets/img/client-b.jpg)">
    <div class="container">
        <div class="heading two">
            <h2>Ini Kata Mereka</h2>
        </div>
        <div class="client-slider owl-carousel owl-theme">
            <div class="item" >
                <div class="client">
                    <img src="assets/img/client.png" alt="client">
                    <div class="client-text">
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                        <p>"Pelayanan di PawCare benar-benar luar biasa. Dokternya ramah, komunikatif, dan sangat peduli dengan kondisi hewan saya. Sekarang saya lebih tenang karena tahu hewan kesayangan saya ditangani oleh profesional."</p>
                        <h4>Maya R.,</h4>
                        <span>Pet Owner</span>
                        <i class="quote">
                            <img src="assets/img/quote.png" alt="quote">
                        </i>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="client">
                    <img src="assets/img/client.png" alt="client">
                    <div class="client-text">
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                        <p>"Saya selalu menggunakan layanan grooming di PawCare. Hasilnya selalu rapi, wangi, dan membuat anjing saya terlihat jauh lebih ceria. Sangat direkomendasikan!"</p>
                        <h4>Dimas.,</h4>
                        <span>Dog Lover</span>
                        <i class="quote">
                            <img src="assets/img/quote.png" alt="quote">
                        </i>
                    </div>
                </div>
            </div>
            <div class="item" >
                <div class="client">
                    <img src="assets/img/client.png" alt="client">
                    <div class="client-text">
                        <ul class="star">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                        </ul>
                        <p>"Proses booking dokter hewannya cepat dan mudah. Ketika datang ke klinik, pelayanan sangat ramah dan informatif. Kucing saya sekarang jauh lebih sehat."</p>
                        <h4>Rani A.,</h4>
                        <span>Cat Lover</span>
                        <i class="quote">
                            <img src="assets/img/quote.png" alt="quote">
                        </i>
                    </div>
                </div>
            </div>
        </div>
        <div class="rated">
            <ul class="star">
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
            </ul>
            <h4>Rated 4.5 Out of 5.0</h4>
        </div>
    </div>
</section> 
<div class="gap">
    <div class="container">
        <div class="insta-img">
            <h3><i class="fa-brands fa-instagram"></i>Follow @pawcare_</h3>
            <a href="#" class="button">Follow Us</a>
        </div>
            <ul class="image-gallery">
                <li>
                    <a href="assets/img/gallery-1.jpg" data-fancybox="gallery"><figure><img alt="girl" src="assets/img/gallery-1.jpg"></figure></a>
                </li>
                <li>
                    <a href="assets/img/gallery-2.jpg" data-fancybox="gallery"><figure><img alt="girl" src="assets/img/gallery-2.jpg"></figure></a>
                </li>
                <li>
                    <a href="assets/img/gallery-3.jpg" data-fancybox="gallery"><figure><img alt="girl" src="assets/img/gallery-3.jpg"></figure></a>
                </li>
                <li>
                    <a href="assets/img/gallery-4.jpg" data-fancybox="gallery"><figure><img alt="girl" src="assets/img/gallery-4.jpg"></figure></a>
                </li>
                <li>
                    <a href="assets/img/gallery-5.jpg" data-fancybox="gallery"><figure><img alt="girl" src="assets/img/gallery-5.jpg"></figure></a>
                </li>
                <li>
                    <a href="assets/img/gallery-6.jpg" data-fancybox="gallery"><figure><img alt="girl" src="assets/img/gallery-6.jpg"></figure></a>
                </li>
                <li>
                    <a href="assets/img/gallery-7.jpg" data-fancybox="gallery"><figure><img alt="girl" src="assets/img/gallery-7.jpg"></figure></a>
                </li>
            </ul>
    </div>
</div>


@endsection