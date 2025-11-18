# 🛡️ Admin Panel - AnimeTalk

## ✨ Tổng quan

Admin Panel là hệ thống quản trị hoàn chỉnh cho AnimeTalk, cho phép quản trị viên quản lý toàn bộ nội dung và người dùng của website.

## 🚀 Tính năng đã triển khai

### 1. Dashboard
- ✅ Thống kê tổng quan (users, posts, communities, comments)
- ✅ Thống kê theo thời gian (hôm nay, 7 ngày)
- ✅ Biểu đồ người dùng mới
- ✅ Biểu đồ bài viết mới
- ✅ Top 5 bài viết hot nhất
- ✅ Top 5 cộng đồng lớn nhất
- ✅ Danh sách người dùng & bài viết mới nhất

### 2. Quản lý người dùng
- ✅ Danh sách người dùng với phân trang
- ✅ Tìm kiếm theo tên, email, UID
- ✅ Lọc theo role (admin/user)
- ✅ Xem chi tiết profile người dùng
- ✅ Chỉnh sửa thông tin người dùng
- ✅ Đổi mật khẩu người dùng
- ✅ Nâng/hạ cấp admin
- ✅ Xóa người dùng
- ✅ Thống kê posts, comments của từng user

### 3. Quản lý bài viết
- ✅ Danh sách bài viết với phân trang
- ✅ Tìm kiếm theo tiêu đề, nội dung
- ✅ Lọc theo category
- ✅ Lọc theo khoảng thời gian
- ✅ Xem chi tiết bài viết
- ✅ Xem tất cả comments
- ✅ Xóa bài viết
- ✅ Xóa nhiều bài viết cùng lúc
- ✅ Link xem trực tiếp trên trang

### 4. Quản lý cộng đồng
- ✅ Danh sách cộng đồng dạng grid
- ✅ Tìm kiếm theo tên, mô tả
- ✅ Xem chi tiết cộng đồng
- ✅ Danh sách thành viên
- ✅ Danh sách bài viết trong cộng đồng
- ✅ Xóa cộng đồng
- ✅ Thống kê members, posts

### 5. Bảo mật & Phân quyền
- ✅ Middleware `IsAdmin` để bảo vệ routes
- ✅ Kiểm tra role trong database
- ✅ Trang 403 Forbidden tùy chỉnh
- ✅ Ngăn admin xóa/sửa chính mình
- ✅ Session-based authentication

## 📁 Cấu trúc Files

### Controllers
```
app/Http/Controllers/Admin/
├── DashboardController.php   # Trang dashboard
├── UserController.php         # Quản lý users
├── PostController.php         # Quản lý posts
└── CommunityController.php    # Quản lý communities
```

### Views
```
resources/views/admin/
├── layout.blade.php           # Layout chính
├── dashboard.blade.php        # Dashboard
├── users/
│   ├── index.blade.php       # Danh sách users
│   ├── show.blade.php        # Chi tiết user
│   └── edit.blade.php        # Chỉnh sửa user
├── posts/
│   ├── index.blade.php       # Danh sách posts
│   └── show.blade.php        # Chi tiết post
└── communities/
    ├── index.blade.php       # Danh sách communities
    └── show.blade.php        # Chi tiết community
```

### Middleware
```
app/Http/Middleware/
└── IsAdmin.php               # Middleware bảo vệ admin routes
```

### Migrations
```
database/migrations/
└── 2025_11_18_095653_add_role_to_users_table.php
```

## 🔐 Truy cập Admin Panel

### Yêu cầu:
1. Tài khoản phải có `role = 'admin'` trong database
2. Đã đăng nhập vào hệ thống

### URL:
```
http://your-domain/admin
```

### Menu:
- Trong user dropdown (góc phải navigation bar)
- Mục "Quản trị Admin" (màu tím)

## 🛠️ Setup & Configuration

### 1. Chạy Migration
```bash
php artisan migrate
```

### 2. Tạo Admin User
```bash
# Cách 1: Qua Tinker
php artisan tinker
DB::table('users')->where('email', 'your@email.com')->update(['role' => 'admin']);

# Cách 2: Qua SQL trực tiếp
UPDATE users SET role = 'admin' WHERE email = 'your@email.com';
```

### 3. Đăng nhập và truy cập
- Đăng nhập với tài khoản admin
- Click vào dropdown menu
- Chọn "Quản trị Admin"

## 🎨 Giao diện

### Màu sắc chủ đạo:
- **Primary**: Purple (#6366f1, #9333ea)
- **Secondary**: Pink (#F4A8C0)
- **Accent**: Blue (#A8D5E8)
- **Success**: Green (#10b981)
- **Danger**: Red (#ef4444)

### Layout:
- **Sidebar**: Navigation menu cố định bên trái
- **Header**: Tiêu đề trang + nút logout
- **Content**: Nội dung chính
- **Footer**: Thông tin admin user

### Icons:
Font Awesome 6.4.0 cho tất cả icons

## 📊 Routes

```php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])->name('users.toggleRole');
    
    // Posts
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    
    // Communities
    Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
    Route::get('/communities/{community}', [CommunityController::class, 'show'])->name('communities.show');
    Route::delete('/communities/{community}', [CommunityController::class, 'destroy'])->name('communities.destroy');
});
```

## 🔒 Security Features

### Middleware Protection
- `auth`: Yêu cầu đăng nhập
- `admin`: Kiểm tra role = admin

### Rules
1. ❌ Admin không thể xóa chính mình
2. ❌ Admin không thể thay đổi role của chính mình
3. ✅ Email phải unique khi update user
4. ✅ Password confirmation khi đổi mật khẩu
5. ✅ Confirm trước khi xóa bất kỳ dữ liệu nào

## 📱 Responsive Design

Admin Panel được thiết kế responsive cho:
- ✅ Desktop (1920px+)
- ✅ Laptop (1366px - 1920px)
- ✅ Tablet (768px - 1366px)
- ⚠️ Mobile (< 768px) - Planned

## 🐛 Troubleshooting

### Không truy cập được admin panel?
```bash
# Check role
php artisan tinker
DB::table('users')->where('email', 'your@email.com')->first()->role;

# Set admin
DB::table('users')->where('email', 'your@email.com')->update(['role' => 'admin']);
```

### Lỗi 403 Forbidden?
- User chưa có role admin
- Middleware chưa được đăng ký
- Cache chưa được clear

### Migration failed?
```bash
# Rollback
php artisan migrate:rollback --step=1

# Migrate again
php artisan migrate
```

## 📈 Future Enhancements

### Planned Features:
- [ ] Quản lý Tags
- [ ] Quản lý Comments standalone
- [ ] Quản lý Messages
- [ ] Analytics nâng cao
- [ ] Export data (CSV, PDF)
- [ ] Bulk actions
- [ ] Activity logs
- [ ] Email notifications
- [ ] System settings
- [ ] Backup & restore

### UI Improvements:
- [ ] Dark mode
- [ ] Mobile-first sidebar
- [ ] Charts với Chart.js
- [ ] Real-time updates
- [ ] Better filtering UI

## 📝 Changelog

### Version 1.0.0 (18/11/2025)
- ✅ Initial release
- ✅ Dashboard with stats
- ✅ User management
- ✅ Post management
- ✅ Community management
- ✅ Role-based access control
- ✅ Responsive design

## 🤝 Contributing

Admin panel is part of AnimeTalk project. Follow the main project's contributing guidelines.

## 📄 License

Same as AnimeTalk main project.

---

**Developed by:** AnimeTalk Team  
**Version:** 1.0.0  
**Last Updated:** November 18, 2025
