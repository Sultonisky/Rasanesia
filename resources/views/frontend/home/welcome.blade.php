<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/homepage.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/chef_hat.png') }}" type="image/x-icon">
    <title>Rasanesia - Welcome</title>
</head>

<body>
    <div class="homepage">
        <img src="{{ asset('assets/img/leaf.png') }}" alt="Leaf" class="leaf-bg">
        <!-- <img src="{{ asset('assets/img/leaf.png') }}" alt="Leaf" class="leaf-bg-bottom"> -->
        <nav class="navbar">
            <div class="nav-logo">
                <img src="{{ asset('assets/img/chef_hat.png') }}" alt="Logo" class="logo-img"> Rasanesia
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('login') }}" class="nav-btn nav-login">Masuk</a></li>
                <li><a href="{{ route('register') }}" class="nav-btn nav-register">Daftar</a></li>
            </ul>
        </nav>
        <section class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">WELCOME TO RASANESIA</h1>
                <p class="hero-desc">"Selamat datang di tempat di mana cita rasa nusantara hidup dalam setiap resep."</p>
                <p class="hero-subdesc">Jelajahi kekayaan kuliner Indonesia, dari hidangan rumahan yang sederhana hingga warisan masakan daerah yang legendaris.</p>
                <a href="{{ route('main-home') }}" class="cta-btn">Jelajahi Resep</a>
            </div>
            <div class="hero-images">
                <div class="poster-row">
                    @if(isset($recipes) && count($recipes) >= 2)
                        <div class="poster"><img src="{{ $recipes[0]['image'] }}" alt="{{ $recipes[0]['alt'] }}"></div>
                        <div class="poster"><img src="{{ $recipes[1]['image'] }}" alt="{{ $recipes[1]['alt'] }}"></div>
                    @else
                        <div class="poster"><img src="https://ik.imagekit.io/tvlk/blog/2023/12/batagor-shutterstock.jpg?tr=dpr-1.5" alt="Batagor"></div>
                        <div class="poster"><img src="https://blog.tokowahab.com/wp-content/uploads/2023/07/Resep-Bacem-Tahu-Tempe-Bumbunya-Meresap-Sampai-Ke-Dalam.-Simak-di-blog.tokowahab.com_.png" alt="Bacem Tahu Tempe"></div>
                    @endif
                </div>
                <div class="poster-row">
                    @if(isset($recipes) && count($recipes) >= 4)
                        <div class="poster"><img src="{{ $recipes[2]['image'] }}" alt="{{ $recipes[2]['alt'] }}"></div>
                        <div class="poster"><img src="{{ $recipes[3]['image'] }}" alt="{{ $recipes[3]['alt'] }}"></div>
                    @else
                        <div class="poster"><img src="https://asset.kompas.com/crops/13s3VjlTLJDabBTBmmS08XphFVY=/0x0:1000x667/750x500/data/photo/2020/07/30/5f2242077ea7b.jpg" alt="Masakan 1"></div>
                        <div class="poster"><img src="https://www.tagar.id/Asset/uploads2019/1642129532972-resep-nasi-liwet.jpeg" alt="Nasi Liwet"></div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</body>

</html>
