<!DOCTYPE html>
<html lang="en" data-theme="anime-day">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <title>@yield('title', 'AnimeTalk - Anime Community')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Nunito:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    
    <style>
        /* Cloud Background Animation */
        .cloud-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        
        .cloud {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 100px;
            animation: float-cloud 60s infinite ease-in-out;
        }
        
        .cloud::before,
        .cloud::after {
            content: '';
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 100px;
        }
        
        .cloud-1 {
            width: 120px;
            height: 40px;
            top: 10%;
            left: -120px;
            animation-delay: 0s;
        }
        
        .cloud-2 {
            width: 150px;
            height: 50px;
            top: 30%;
            left: -150px;
            animation-delay: 15s;
        }
        
        .cloud-3 {
            width: 100px;
            height: 35px;
            top: 50%;
            left: -100px;
            animation-delay: 30s;
        }
        
        .cloud-4 {
            width: 130px;
            height: 45px;
            top: 70%;
            left: -130px;
            animation-delay: 45s;
        }
        
        @keyframes float-cloud {
            0%, 100% {
                transform: translateX(0) translateY(0);
            }
            50% {
                transform: translateX(calc(100vw + 200px)) translateY(-20px);
            }
        }
        
        /* Smooth Page Transitions */
        .page-content {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <!-- Animated Cloud Background -->
    <div class="cloud-bg">
        <div class="cloud cloud-1"></div>
        <div class="cloud cloud-2"></div>
        <div class="cloud cloud-3"></div>
        <div class="cloud cloud-4"></div>
    </div>

    <!-- Navigation -->
    <nav class="nav-anime">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                    <div class="w-10 h-10 bg-anime-blue rounded-full flex items-center justify-center shadow-anime">
                        <i class="bi bi-cloud-sun text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-semibold text-gray-700">AnimeTalk</span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>
                    
                    @auth
                    <a href="{{ route('communities.index') }}" class="nav-link {{ request()->routeIs('communities.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Communities</span>
                    </a>
                    
                    <a href="{{ route('messages.index') }}" class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots-fill"></i>
                        <span>Messages</span>
                        @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    
                    <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="bi bi-bell-fill"></i>
                        <span>Notifications</span>
                    </a>
                    @endauth
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                    <!-- Create Post Button -->
                    <a href="{{ route('posts.create') }}" class="btn btn-anime btn-primary hidden md:inline-flex items-center space-x-2">
                        <i class="bi bi-plus-circle"></i>
                        <span>Create</span>
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="cursor-pointer">
                            <div class="avatar-anime w-10 h-10">
                                @if(auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover rounded-full">
                                @else
                                <div class="w-full h-full bg-anime-mint rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                @endif
                            </div>
                        </label>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow-anime bg-white rounded-anime w-52 mt-2">
                            <li><a href="{{ route('profile.show', auth()->user()->username) }}"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a href="{{ route('profile.edit') }}"><i class="bi bi-gear"></i> Settings</a></li>
                            <li><hr class="my-2"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-anime btn-ghost">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-anime btn-primary">Sign Up</a>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button class="md:hidden btn btn-ghost btn-square" onclick="toggleMobileMenu()">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/20 backdrop-blur-sm" onclick="toggleMobileMenu()"></div>
        <div class="absolute right-0 top-0 h-full w-64 bg-white shadow-2xl slide-in-right p-6">
            <button class="absolute top-4 right-4 btn btn-ghost btn-square btn-sm" onclick="toggleMobileMenu()">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
            
            <div class="mt-12 space-y-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 p-3 rounded-anime hover:bg-anime-sky/10">
                    <i class="bi bi-house-door-fill text-anime-blue"></i>
                    <span>Home</span>
                </a>
                
                @auth
                <a href="{{ route('communities.index') }}" class="flex items-center space-x-3 p-3 rounded-anime hover:bg-anime-sky/10">
                    <i class="bi bi-people-fill text-anime-blue"></i>
                    <span>Communities</span>
                </a>
                
                <a href="{{ route('messages.index') }}" class="flex items-center space-x-3 p-3 rounded-anime hover:bg-anime-sky/10">
                    <i class="bi bi-chat-dots-fill text-anime-blue"></i>
                    <span>Messages</span>
                </a>
                
                <a href="{{ route('notifications.index') }}" class="flex items-center space-x-3 p-3 rounded-anime hover:bg-anime-sky/10">
                    <i class="bi bi-bell-fill text-anime-blue"></i>
                    <span>Notifications</span>
                </a>
                
                <a href="{{ route('posts.create') }}" class="flex items-center space-x-3 p-3 rounded-anime hover:bg-anime-sky/10">
                    <i class="bi bi-plus-circle text-anime-blue"></i>
                    <span>Create Post</span>
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="page-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t-2 border-anime-sky/20 mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-4">About AnimeTalk</h3>
                    <p class="text-gray-600 text-sm">A friendly anime community where fans can connect, share, and discuss their favorite anime.</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-700 mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-anime-blue">Home</a></li>
                        <li><a href="{{ route('communities.index') }}" class="text-gray-600 hover:text-anime-blue">Communities</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-anime-blue">About</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-700 mb-4">Support</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-600 hover:text-anime-blue">Help Center</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-anime-blue">Terms of Service</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-anime-blue">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-700 mb-4">Connect</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-anime-blue rounded-full flex items-center justify-center text-white hover:shadow-anime transition-all">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-anime-blue rounded-full flex items-center justify-center text-white hover:shadow-anime transition-all">
                            <i class="bi bi-discord"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-anime-blue rounded-full flex items-center justify-center text-white hover:shadow-anime transition-all">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-anime-sky/20 mt-8 pt-8 text-center text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} AnimeTalk. Made with ❤️ for anime fans.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobileMenu').classList.add('hidden');
            });
        });
    </script>
</body>
</html>
