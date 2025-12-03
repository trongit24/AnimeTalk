<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Prevent browser caching for images -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <title>@yield('title', 'AnimeTalk - Anime Community Forum')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts - Noto Sans JP for anime feel -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Particles.js for background effects -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
    <!-- GSAP for smooth animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    
    <!-- Three.js for 3D effects (optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    
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
    
    <!-- Shinkai Style Global CSS -->
    <style>
        :root {
            /* Shinkai Color Palette */
            --shinkai-sky-start: #87CEEB;
            --shinkai-sky-mid: #B4D4FF;
            --shinkai-sky-end: #FFB6C1;
            --shinkai-sunset: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shinkai-twilight: linear-gradient(180deg, #4A00E0 0%, #8E2DE2 50%, #FF6B9D 100%);
            --shinkai-dawn: linear-gradient(180deg, #FFB88C 0%, #DE6262 100%);
            --shinkai-blue: #4A90E2;
            --shinkai-purple: #9B59B6;
            --shinkai-pink: #FF6B9D;
            --shinkai-orange: #FF9A56;
            --shinkai-white: #FAFAFA;
            --shinkai-text: #2C3E50;
            --shinkai-shadow: rgba(0, 0, 0, 0.15);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Noto Sans JP', sans-serif;
            background: linear-gradient(180deg, 
                #87CEEB 0%, 
                #B4D4FF 30%, 
                #FFE4E1 60%, 
                #FFB6C1 100%
            );
            background-attachment: fixed;
            color: var(--shinkai-text);
            overflow-x: hidden;
            position: relative;
        }
        
        /* Animated Background Particles */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            opacity: 0;
            display: none;
        }
        
        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 10;
        }
        
        .glass-card:hover {
            background: rgba(255, 255, 255, 0.98) !important;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
        
        /* Force content visibility */
        .glass-card * {
            position: relative;
            z-index: 11;
        }
        
        /* Light Bloom Effect */
        .light-bloom {
            position: relative;
            overflow: hidden;
        }
        
        .light-bloom::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(
                circle,
                rgba(255, 255, 255, 0.3) 0%,
                transparent 70%
            );
            animation: lightRotate 20s linear infinite;
            pointer-events: none;
        }
        
        @keyframes lightRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Particle Dust Effect */
        .dust-particle {
            position: fixed;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            pointer-events: none;
            animation: float 15s infinite ease-in-out;
            z-index: 0;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(50px);
                opacity: 0;
            }
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Button Shinkai Style */
        .btn-shinkai {
            background: linear-gradient(135deg, var(--shinkai-blue), var(--shinkai-purple));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-shinkai::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-shinkai:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-shinkai:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6);
        }
        
        /* Text Glow Effect */
        .text-glow {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5),
                         0 0 20px rgba(135, 206, 235, 0.3);
        }
        
        /* Loading Animation */
        .shinkai-loader {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-top: 5px solid var(--shinkai-blue);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Navbar Glassmorphism */
        .modern-navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
            position: sticky !important;
            top: 0;
            z-index: 1000;
        }
        
        .nav-logo .logo-text {
            background: linear-gradient(135deg, var(--shinkai-blue), var(--shinkai-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 24px;
            text-shadow: 0 2px 10px rgba(74, 144, 226, 0.3);
        }
        
        .nav-search-bar input {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .nav-search-bar input:focus {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 0 20px rgba(74, 144, 226, 0.3);
            transform: scale(1.02);
        }

        /* Search Suggestions Dropdown */
        .nav-search-bar {
            position: relative;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            margin-top: 8px;
            max-height: 400px;
            overflow-y: auto;
            z-index: 1001;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .suggestion-item {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            gap: 12px;
            align-items: start;
            opacity: 1 !important;
            visibility: visible !important;
            color: #1c1c1c !important;
        }

        .suggestion-item:hover {
            background: rgba(74, 144, 226, 0.08);
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .suggestion-content {
            flex: 1;
            min-width: 0;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .suggestion-text {
            font-size: 14px;
            color: #1c1c1c !important;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .suggestion-meta {
            font-size: 12px;
            color: #666 !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .nav-btn-primary {
            background: linear-gradient(135deg, var(--shinkai-blue), var(--shinkai-purple)) !important;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4) !important;
            transition: all 0.3s ease;
        }
        
        .nav-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.6) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <!-- Floating Dust Particles -->
    <div class="dust-particles-container"></div>
    
    <!-- Modern Navigation -->
    <nav class="modern-navbar">
        <div class="navbar-container">
            <div class="navbar-left">
                <a href="{{ route('home') }}" class="nav-logo">
                    <span class="logo-text">AnimeTalk</span>
                </a>
                
                <div class="nav-search-bar">
                    <form action="{{ route('search') }}" method="GET" id="searchForm">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" 
                               name="q" 
                               id="searchInput"
                               placeholder="Tìm kiếm nội dung bài viết..." 
                               value="{{ request('q') }}"
                               autocomplete="off">
                        <div id="searchSuggestions" class="search-suggestions" style="display: none;"></div>
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
    <main class="app-main" style="position: relative; z-index: 100;">
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
                // Removed opacity change that was making content invisible
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
    
    <!-- Shinkai-style Particles & Animations -->
    <script>
        // Initialize Particles.js
        if (typeof particlesJS !== 'undefined') {
            particlesJS('particles-js', {
                particles: {
                    number: {
                        value: 80,
                        density: {
                            enable: true,
                            value_area: 800
                        }
                    },
                    color: {
                        value: ['#ffffff', '#87CEEB', '#FFB6C1']
                    },
                    shape: {
                        type: 'circle',
                    },
                    opacity: {
                        value: 0.5,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 1,
                            opacity_min: 0.1,
                            sync: false
                        }
                    },
                    size: {
                        value: 3,
                        random: true,
                        anim: {
                            enable: true,
                            speed: 2,
                            size_min: 0.1,
                            sync: false
                        }
                    },
                    line_linked: {
                        enable: false
                    },
                    move: {
                        enable: true,
                        speed: 1,
                        direction: 'top',
                        random: true,
                        straight: false,
                        out_mode: 'out',
                        bounce: false,
                    }
                },
                interactivity: {
                    detect_on: 'canvas',
                    events: {
                        onhover: {
                            enable: true,
                            mode: 'bubble'
                        },
                        onclick: {
                            enable: true,
                            mode: 'repulse'
                        },
                        resize: true
                    },
                    modes: {
                        bubble: {
                            distance: 150,
                            size: 6,
                            duration: 2,
                            opacity: 0.8,
                            speed: 3
                        },
                        repulse: {
                            distance: 100,
                            duration: 0.4
                        }
                    }
                },
                retina_detect: true
            });
        }
        
        // Create floating dust particles
        function createDustParticles() {
            const container = document.querySelector('.dust-particles-container');
            if (!container) return;
            
            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.className = 'dust-particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (10 + Math.random() * 10) + 's';
                container.appendChild(particle);
            }
        }
        
        // Initialize AOS (Animate On Scroll)
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                easing: 'ease-out-cubic',
                once: false,
                mirror: true,
                offset: 100
            });
        }
        
        // GSAP Scroll Animations - DISABLED to fix visibility issues
        if (false && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);
            
            // Animate cards on scroll
            gsap.utils.toArray('.glass-card').forEach((card, i) => {
                gsap.from(card, {
                    scrollTrigger: {
                        trigger: card,
                        start: 'top 80%',
                        end: 'top 20%',
                        toggleActions: 'play none none reverse'
                    },
                    y: 50,
                    opacity: 0,
                    duration: 0.8,
                    delay: i * 0.1
                });
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            createDustParticles();
            
            // Add smooth parallax effect to background
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const particles = document.getElementById('particles-js');
                if (particles) {
                    particles.style.transform = 'translateY(' + (scrolled * 0.5) + 'px)';
                }
            });

            // Search autocomplete functionality
            const searchInput = document.getElementById('searchInput');
            const searchSuggestions = document.getElementById('searchSuggestions');
            let searchTimeout;

            if (searchInput && searchSuggestions) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();

                    if (query.length < 2) {
                        searchSuggestions.style.display = 'none';
                        return;
                    }

                    searchTimeout = setTimeout(function() {
                        fetch(`{{ route('search.autocomplete') }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.length === 0) {
                                    searchSuggestions.style.display = 'none';
                                    return;
                                }

                                let html = '';
                                data.forEach(item => {
                                    const avatar = item.user_photo 
                                        ? `<img src="${item.user_photo}" alt="${item.user_name}" class="suggestion-avatar">`
                                        : `<div class="suggestion-avatar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">${item.user_name.charAt(0).toUpperCase()}</div>`;
                                    
                                    html += `
                                        <div class="suggestion-item" data-slug="${item.slug}">
                                            ${avatar}
                                            <div class="suggestion-content">
                                                <div class="suggestion-text">${item.content}</div>
                                                <div class="suggestion-meta">bởi ${item.user_name}</div>
                                            </div>
                                        </div>
                                    `;
                                });

                                searchSuggestions.innerHTML = html;
                                searchSuggestions.style.display = 'block';

                                // Add click handlers to suggestions
                                document.querySelectorAll('.suggestion-item').forEach(item => {
                                    item.addEventListener('click', function() {
                                        const postSlug = this.getAttribute('data-slug');
                                        window.location.href = `/posts/${postSlug}`;
                                    });
                                });
                            })
                            .catch(error => {
                                console.error('Search error:', error);
                                searchSuggestions.style.display = 'none';
                            });
                    }, 300);
                });

                // Hide suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                        searchSuggestions.style.display = 'none';
                    }
                });

                // Show suggestions again when focusing on input
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length >= 2 && searchSuggestions.innerHTML) {
                        searchSuggestions.style.display = 'block';
                    }
                });
            }
        });
    </script>
    
    <!-- Custom JS -->
    @stack('scripts')
</body>
</html>
