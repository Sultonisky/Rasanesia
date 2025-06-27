<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="icon" href="{{ asset('assets/img/chef_hat.png') }}">
    <title>Verifikasi Email</title>
</head>
<body>
    <div class="login-bg">
        <form class="login-form" style="max-width:420px;">
            <img src="{{ asset('assets/img/chef_hat.png') }}" width="75" alt="Logo Chef Hat" style="margin-bottom: 10px;">
            <h2 class="login-title">Verifikasi Email</h2>
            @if (session('message'))
                <div class="alert-success" style="margin: 0 auto 18px auto; font-weight:600; font-size:1.05rem; display:flex; align-items:center; gap:8px; background:#eafaf1; color:#2e3a32; border:1.5px solid #a3b48b; border-radius:7px; padding:10px 16px; justify-content:center; max-width:400px; text-align:center;">
                    <span style="font-size:1.3em;">&#10003;</span> {{ session('message') }}
                </div>
            @endif
            <div class="container" style="text-align:center;">
                <p>Silakan cek email kamu dan klik link verifikasi yang telah dikirim.</p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="login-btn" style="margin-top:16px;">Kirim Ulang Email Verifikasi</button>
                </form>
            </div>
        </form>
    </div>
</body>
</html> 