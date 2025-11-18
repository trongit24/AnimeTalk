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
    
    <!-- Responsive CSS by Pages -->
    <link rel="stylesheet" href="{{ asset('css/global-base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/friends.css') }}">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/communities.css') }}">
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/post-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
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
                <!-- Mobile Hamburger Menu -->
                <button class="mobile-hamburger-btn" id="mobileMenuBtn" type="button" aria-label="Toggle menu">
                    <i class="bi bi-list"></i>
                </button>
                
                <!-- Mobile Search Icon -->
                <button class="mobile-search-btn" id="mobileSearchBtn" type="button" aria-label="Toggle search">
                    <i class="bi bi-search"></i>
                </button>
                
                <a href="{{ route('posts.create') }}" class="nav-icon-btn" title="Create Post">
                    <i class="bi bi-plus-circle"></i>
                </a>
                <a href="{{ route('events.index') }}" class="nav-icon-btn" title="Events">
                    <i class="bi bi-calendar-event"></i>
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
                <a href="{{ route('notifications.index') }}" class="nav-icon-btn" title="Notifications" style="position: relative;">
                    <i class="bi bi-bell"></i>
                    @if($unreadNotificationsCount > 0)
                        <span style="position: absolute; top: -2px; right: -2px; background: #dc2626; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; font-weight: bold; display: flex; align-items: center; justify-content: center;">
                            {{ $unreadNotificationsCount > 9 ? '9+' : $unreadNotificationsCount }}
                        </span>
                    @endif
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
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" style="color: #9B7EDE; font-weight: 600;">
                                <i class="bi bi-shield-check"></i> Quản trị Admin
                            </a>
                        @endif
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

    <!-- Mobile Search Overlay -->
    <div class="mobile-search-overlay" id="mobileSearchOverlay">
        <div class="search-overlay-header">
            <button class="search-close-btn" id="searchCloseBtn">
                <i class="bi bi-arrow-left"></i>
            </button>
            <form action="{{ route('search') }}" method="GET" style="flex: 1;">
                <div class="search-overlay-input">
                    <i class="bi bi-search"></i>
                    <input type="text" name="q" placeholder="Tìm kiếm trên AnimeTalk" id="mobileSearchInput" autocomplete="off">
                </div>
            </form>
        </div>
    </div>

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

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Profile Dropdown Toggle -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileDropdown = document.querySelector('.nav-profile-dropdown');
        const profileBtn = document.querySelector('.profile-btn');
        
        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                profileDropdown.classList.toggle('active');
                console.log('Dropdown toggled, active:', profileDropdown.classList.contains('active'));
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target)) {
                    profileDropdown.classList.remove('active');
                }
            });
        } else {
            console.log('Profile button or dropdown not found');
        }
        
        // Mobile Menu Toggle (if added)
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileSearch = document.querySelector('.mobile-search');
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                this.classList.toggle('active');
                if (mobileSearch) {
                    mobileSearch.classList.toggle('active');
                }
            });
        }
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '#!') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
        
        // Add loading animation on page transitions
        document.querySelectorAll('a:not([target="_blank"])').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                // Only for internal links that aren't anchors
                if (href && !href.startsWith('#') && !href.startsWith('javascript:') && href.startsWith('/')) {
                    // Add a subtle loading indicator (optional)
                    document.body.style.opacity = '0.9';
                }
            });
        });
        
        // Lazy load images
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.dataset.src || img.src;
            });
        } else {
            // Fallback for browsers that don't support lazy loading
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
            document.body.appendChild(script);
        }

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const leftSidebar = document.getElementById('leftSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (mobileMenuBtn && leftSidebar) {
            mobileMenuBtn.addEventListener('click', function() {
                leftSidebar.classList.toggle('mobile-open');
            });

            // Close sidebar when clicking menu links
            const menuLinks = leftSidebar.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    leftSidebar.classList.remove('mobile-open');
                });
            });
        }

        // Mobile Search Toggle
        const mobileSearchBtn = document.getElementById('mobileSearchBtn');
        const mobileSearchOverlay = document.getElementById('mobileSearchOverlay');
        const searchCloseBtn = document.getElementById('searchCloseBtn');
        const mobileSearchInput = document.getElementById('mobileSearchInput');

        if (mobileSearchBtn && mobileSearchOverlay) {
            mobileSearchBtn.addEventListener('click', function() {
                mobileSearchOverlay.classList.add('active');
                setTimeout(() => {
                    if (mobileSearchInput) {
                        mobileSearchInput.focus();
                    }
                }, 300);
            });

            if (searchCloseBtn) {
                searchCloseBtn.addEventListener('click', function() {
                    mobileSearchOverlay.classList.remove('active');
                });
            }
        }
    });
    </script>
    
    <!-- Custom JS -->
    @stack('scripts')
</body>
</html>
