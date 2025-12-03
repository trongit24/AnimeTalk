<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Panel'); ?> - AnimeTalk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#A8B3E8',
                        secondary: '#F4A8C0',
                        accent: '#A8D5E8',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-purple-600 to-indigo-700 text-white shadow-xl">
            <div class="p-6">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-shield-halved"></i>
                    AnimeTalk
                </h1>
                <p class="text-purple-200 text-sm mt-1">Admin</p>
            </div>

            <nav class="mt-6">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/20 border-r-4 border-white' : ''); ?>">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition <?php echo e(request()->routeIs('admin.users.*') ? 'bg-white/20 border-r-4 border-white' : ''); ?>">
                    <i class="fas fa-users w-5"></i>
                    <span>Người dùng</span>
                </a>
                <a href="<?php echo e(route('admin.posts.index')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition <?php echo e(request()->routeIs('admin.posts.index') || request()->routeIs('admin.posts.detail') ? 'bg-white/20 border-r-4 border-white' : ''); ?>">
                    <i class="fas fa-newspaper w-5"></i>
                    <span>Bài viết</span>
                </a>
                <a href="<?php echo e(route('admin.posts.reported')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition <?php echo e(request()->routeIs('admin.posts.reported') ? 'bg-white/20 border-r-4 border-white' : ''); ?>">
                    <i class="fas fa-flag w-5"></i>
                    <span>Bài viết bị báo cáo</span>
                    <?php
                        $reportedCount = \App\Models\Post::has('reports')->count();
                    ?>
                    <?php if($reportedCount > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full"><?php echo e($reportedCount); ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.communities.index')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition <?php echo e(request()->routeIs('admin.communities.*') ? 'bg-white/20 border-r-4 border-white' : ''); ?>">
                    <i class="fas fa-users-rectangle w-5"></i>
                    <span>Cộng đồng</span>
                </a>
                <a href="<?php echo e(route('admin.events.index')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition <?php echo e(request()->routeIs('admin.events.*') ? 'bg-white/20 border-r-4 border-white' : ''); ?>">
                    <i class="fas fa-calendar-alt w-5"></i>
                    <span>Sự kiện</span>
                </a>
                <a href="<?php echo e(route('admin.notifications.index')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition <?php echo e(request()->routeIs('admin.notifications.*') ? 'bg-white/20 border-r-4 border-white' : ''); ?>">
                    <i class="fas fa-bell w-5"></i>
                    <span>Thông báo</span>
                </a>
                
                <div class="border-t border-white/20 my-4"></div>
                
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3 px-6 py-3 hover:bg-white/10 transition">
                    <i class="fas fa-home w-5"></i>
                    <span>Về trang chủ</span>
                </a>
            </nav>

            <div class="absolute bottom-0 w-64 p-6 border-t border-white/20">
                <div class="flex items-center gap-3">
                    <img src="<?php echo e(auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name)); ?>" 
                         alt="<?php echo e(auth()->user()->name); ?>" 
                         class="w-10 h-10 rounded-full">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-purple-200">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-8 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                    
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-8">
                <?php if(session('success')): ?>
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo e(session('success')); ?></span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?php echo e(session('error')); ?></span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/admin/layout.blade.php ENDPATH**/ ?>