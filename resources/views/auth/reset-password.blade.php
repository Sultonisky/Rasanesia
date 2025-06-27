<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="icon" href="{{ asset('assets/img/chef_hat.png') }}">
    <title>Rasanesia - Reset Password</title>
</head>

<body>
    <div class="login-bg">
        @if (session('message'))
            <div class="alert-success" style="
                margin: 0 auto 18px auto;
                font-weight: 600;
                font-size: 1.05rem;
                display: flex;
                align-items: center;
                gap: 8px;
                background: #eafaf1;
                color: #2e3a32;
                border: 1.5px solid #a3b48b;
                border-radius: 7px;
                padding: 10px 16px;
                justify-content: center;
                max-width: 400px;
                text-align: center;
            ">
                <span style="font-size:1.3em;">&#10003;</span> {{ session('message') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error" style="
                margin: 0 auto 18px auto;
                font-weight: 600;
                font-size: 1.05rem;
                display: flex;
                align-items: center;
                gap: 8px;
                background: #fef2f2;
                color: #dc2626;
                border: 1.5px solid #fca5a5;
                border-radius: 7px;
                padding: 10px 16px;
                justify-content: center;
                max-width: 400px;
                text-align: center;
            ">
                <span style="font-size:1.3em;">&#9888;</span> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" class="login-form" autocomplete="on">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <img src="{{ asset('assets/img/chef_hat.png') }}" width="75" alt="Logo Chef Hat" style="margin-bottom: 10px;">
            <h2 class="login-title">Reset Password</h2>
            <p style="text-align: center; color: #666; margin-bottom: 20px; font-size: 0.95rem;">
                Masukkan password baru untuk akun Anda.
            </p>
            
            <div class="container">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" placeholder="Password baru" required autofocus>
                @error('password')
                    <div class="alert-error">&#9888; {{ $message }}<span class="close-alert" onclick="this.parentElement.style.display='none';">&times;</span></div>
                @enderror
                
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
                @error('password_confirmation')
                    <div class="alert-error">&#9888; {{ $message }}<span class="close-alert" onclick="this.parentElement.style.display='none';">&times;</span></div>
                @enderror
            </div>
            
            <div class="container">
                <button type="submit" class="login-btn">Reset Password</button>
            </div>
            
            <div class="login-links">
                <a href="{{ route('login') }}" class="forgot-link">Kembali ke Login</a>
            </div>
        </form>
    </div>
</body>

</html> 