<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AnimeTalk - Anime Community Forum')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS (sẽ override Bootstrap khi cần) -->
    <link rel="stylesheet" href="{{ asset('css/anime-forum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modern-navbar.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Modern Navigation -->
    <nav class="modern-navbar">
        <div class="navbar-container">
            <div class="navbar-left">
                <a href="{{ route('home') }}" class="nav-logo">
                    <span class="logo-text">AnimeTalk</span>
                </a>
                
                <div class="nav-search-bar">
                    <form action="{{ route('search') }}" method="GET">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="q" placeholder="Search your favorite anime..." value="{{ request('q') }}">
                    </form>
                </div>
            </div>
            
            <div class="navbar-right">
                @guest
                <a href="{{ route('login') }}" class="nav-btn-outline">Log in</a>
                <a href="{{ route('register') }}" class="nav-btn-primary">Sign up</a>
                @else
                <a href="{{ route('posts.create') }}" class="nav-icon-btn" title="Create Post">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="{{ route('friends.index') }}" class="nav-icon-btn" title="Friends">
                    <i class="bi bi-people"></i>
                </a>
                <a href="{{ route('messages.index') }}" class="nav-icon-btn" title="Messages" style="position: relative;">
                    <i class="bi bi-chat-dots"></i>
                    @if($unreadMessagesCount > 0)
                        <span style="position: absolute; top: -2px; right: -2px; background: #dc2626; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                            {{ $unreadMessagesCount > 9 ? '9+' : $unreadMessagesCount }}
                        </span>
                    @endif
                </a>
                <a href="#" class="nav-icon-btn" title="Notifications">
                    <i class="bi bi-bell"></i>
                </a>
                
                <div class="nav-profile-dropdown">
                    <button class="profile-btn">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="profile-avatar-img">
                        @else
                            <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        @endif
                        <span class="profile-name">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.show') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-bottom: 1px solid #e4e6eb;">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #5BA3D0, #9B7EDE); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight: 600; color: #1c1c1c;">{{ auth()->user()->name }}</div>
                                <div style="font-size: 0.875rem; color: #666;">Xem trang cá nhân của bạn</div>
                            </div>
                        </a>
                        <a href="{{ route('profile.edit') }}">
                            <i class="bi bi-gear"></i> Cài đặt và quyền riêng tư
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-logout">
                                <i class="bi bi-box-arrow-right"></i> Log out
                            </button>
                        </form>
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="app-main">
        @if(session('success'))
            <div class="modern-alert success">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="modern-alert error">
                <i class="bi bi-x-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>AnimeTalk</h3>
                    <p>Your ultimate anime community forum</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('communities.index') }}">Communities</a>
                </div>
                <div class="footer-section">
                    <h4>Connect</h4>
                    <p>Follow us on social media</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 AnimeTalk. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Profile Dropdown Toggle -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileDropdown = document.querySelector('.nav-profile-dropdown');
        const profileBtn = document.querySelector('.profile-btn');
        
        if (profileBtn) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target)) {
                    profileDropdown.classList.remove('active');
                }
            });
        }
    });
    </script>
    
    <!-- Custom JS -->
    @stack('scripts')
</body>
</html>
