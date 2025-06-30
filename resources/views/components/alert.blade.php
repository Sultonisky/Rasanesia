@if(session('success'))
    <div class="alert alert-success">
        <div class="alert-content">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        <!-- <button class="alert-close" onclick="this.parentElement.style.display='none'">
            <i class="fas fa-times"></i>
        </button> -->
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        <div class="alert-content">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
        <!-- <button class="alert-close" onclick="this.parentElement.style.display='none'">
            <i class="fas fa-times"></i>
        </button> -->
    </div>
@endif

@if(session('message'))
    <div class="alert alert-info">
        <div class="alert-content">
            <i class="fas fa-info-circle"></i>
            <span>{{ session('message') }}</span>
        </div>
        <!-- <button class="alert-close" onclick="this.parentElement.style.display='none'">
            <i class="fas fa-times"></i>
        </button> -->
    </div>
@endif
