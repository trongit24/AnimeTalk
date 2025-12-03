<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Truy cập bị từ chối</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <div class="w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full mx-auto flex items-center justify-center shadow-2xl">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
            403
        </h1>
        
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
            Truy cập bị từ chối
        </h2>
        
        <p class="text-gray-600 mb-8">
            <?php echo e($exception->getMessage() ?: 'Bạn không có quyền truy cập trang này. Chỉ có quản trị viên mới có thể truy cập vào khu vực này.'); ?>

        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo e(route('home')); ?>" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-medium rounded-lg hover:shadow-lg transition transform hover:-translate-y-0.5">
                Về trang chủ
            </a>
            <a href="javascript:history.back()" class="px-6 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                Quay lại
            </a>
        </div>

        <div class="mt-12 p-6 bg-white rounded-lg shadow-sm">
            <p class="text-sm text-gray-600">
                <strong>Lưu ý:</strong> Nếu bạn tin rằng đây là lỗi, vui lòng liên hệ với quản trị viên.
            </p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\AnimeTalk\resources\views/errors/403.blade.php ENDPATH**/ ?>