<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rasanesia')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main-home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/saved.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/created.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('styles')
</head>
<body>
<div class="container">
    <!-- Sidebar - sama untuk user dan tamu -->
    @include('frontend.partials.sidebar')
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Alert Messages -->
        @include('components.alert')
        
        @yield('content')
        
        @include('frontend.partials.footer')
    </div>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('expanded');
    }
</script>
@yield('scripts')
</body>
</html> 