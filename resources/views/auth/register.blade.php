<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <link rel="icon" href="{{ asset('assets/img/chef_hat.png') }}">
    <title>Rasanesia - Register</title>
</head>

<body>
    <div class="register-bg">
        <form action="{{ route('registerSave') }}" method="POST" class="register-form" autocomplete="on">
            @csrf
            <img src="{{ asset('assets/img/chef_hat.png') }}" width="75" alt="Logo Chef Hat" style="margin-bottom: 10px;">
            <h2 class="register-title">Daftar Akun Rasanesia</h2>
            <div class="register-container">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name" required autofocus value="{{ old('name') }}">
                @error('name')
                    <div class="alert-error">&#9888; {{ $message }}<span class="close-alert" onclick="this.parentElement.style.display='none';">&times;</span></div>
                @enderror
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email" required autofocus value="{{ old('email') }}">
                @error('email')
                    <div class="alert-error">&#9888; {{ $message }}<span class="close-alert" onclick="this.parentElement.style.display='none';">&times;</span></div>
                @enderror
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="alert-error">&#9888; {{ $message }}<span class="close-alert" onclick="this.parentElement.style.display='none';">&times;</span></div>
                @enderror
                <label for="confirm-password">Konfirmasi Password</label>
                <input type="password" id="confirm-password" name="password_confirmation" placeholder="Konfirmasi Password" required>
                @error('password_confirmation')
                    <div class="alert-error">&#9888; {{ $message }}<span class="close-alert" onclick="this.parentElement.style.display='none';">&times;</span></div>
                @enderror
            </div>
            <div class="register-container">
                <button type="submit" class="register-btn">Daftar</button>
            </div>
            <div class="register-links">
                <a href="{{ route('login') }}">Sudah punya akun? Masuk</a>
            </div>
        </form>
    </div>
</body>

</html>
