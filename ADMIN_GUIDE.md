# 🛡️ Hướng Dẫn Sử Dụng Admin Panel - AnimeTalk

## 📋 Mục lục
1. [Tổng quan](#tổng-quan)
2. [Truy cập Admin Panel](#truy-cập-admin-panel)
3. [Dashboard](#dashboard)
4. [Quản lý người dùng](#quản-lý-người-dùng)
5. [Quản lý bài viết](#quản-lý-bài-viết)
6. [Quản lý cộng đồng](#quản-lý-cộng-đồng)

## 🎯 Tổng quan

Admin Panel là khu vực quản trị dành riêng cho quản trị viên (Administrator) của AnimeTalk. Tại đây, admin có thể:

- 📊 Xem thống kê tổng quan về website
- 👥 Quản lý người dùng
- 📝 Quản lý bài viết
- 🏘️ Quản lý cộng đồng
- 🔐 Phân quyền admin/user

## 🚀 Truy cập Admin Panel

### Điều kiện:
- Tài khoản phải có role = `admin`
- Đã đăng nhập vào hệ thống

### Cách truy cập:
1. **Qua Menu Dropdown:**
   - Click vào avatar/tên của bạn ở góc phải navigation bar
   - Chọn "Quản trị Admin" (màu tím)

2. **Qua URL trực tiếp:**
   - Truy cập: `http://your-domain/admin`

### Tạo Admin User:
```bash
# Cách 1: Qua Tinker
php artisan tinker
DB::table('users')->where('email', 'your@email.com')->update(['role' => 'admin']);

# Cách 2: Qua SQL
UPDATE users SET role = 'admin' WHERE email = 'your@email.com';
```

## 📊 Dashboard

Dashboard hiển thị tổng quan về hoạt động của website:

### Thống kê chính:
- **Tổng người dùng**: Số lượng user đã đăng ký
- **Tổng bài viết**: Số bài viết trên hệ thống
- **Tổng cộng đồng**: Số cộng đồng đã tạo
- **Tổng bình luận**: Số lượng comment

### Thống kê hôm nay:
- Người dùng mới đăng ký
- Bài viết mới
- Bình luận mới

### Biểu đồ & Danh sách:
- Top 5 bài viết hot nhất (theo lượt like)
- Top 5 cộng đồng lớn nhất (theo số thành viên)
- 10 người dùng mới nhất
- 10 bài viết mới nhất

## 👥 Quản lý người dùng

### Xem danh sách người dùng
**Route:** `/admin/users`

**Tính năng:**
- Hiển thị danh sách tất cả người dùng
- Tìm kiếm theo: tên, email, UID
- Lọc theo vai trò: Admin, User
- Phân trang (20 users/trang)

**Thông tin hiển thị:**
- Avatar & tên người dùng
- Email
- Vai trò (Admin/User)
- Thống kê: số bài viết, số comment
- Ngày đăng ký

### Xem chi tiết người dùng
**Route:** `/admin/users/{user}`

**Thông tin:**
- Profile đầy đủ (avatar, cover, bio)
- Thống kê: posts, comments, communities
- 10 bài viết gần nhất
- 10 comment gần nhất

**Hành động:**
- Chỉnh sửa thông tin
- Nâng/hạ cấp quyền admin
- Xóa người dùng

### Chỉnh sửa người dùng
**Route:** `/admin/users/{user}/edit`

**Có thể chỉnh sửa:**
- Tên
- Email
- Vai trò (Admin/User)
- Bio
- Đổi mật khẩu

**Lưu ý:**
- ⚠️ Không thể xóa hoặc thay đổi quyền của chính mình
- ⚠️ Email phải unique

### Nâng/hạ cấp Admin
- **Nâng lên Admin:** User → Admin
- **Hạ xuống User:** Admin → User
- Action: Click nút tương ứng ở trang chi tiết user

## 📝 Quản lý bài viết

### Xem danh sách bài viết
**Route:** `/admin/posts`

**Tính năng:**
- Tìm kiếm theo tiêu đề, nội dung
- Lọc theo category
- Lọc theo khoảng thời gian (từ ngày - đến ngày)
- Phân trang (20 posts/trang)

**Thông tin hiển thị:**
- Thumbnail (nếu có)
- Tiêu đề & excerpt
- Tác giả
- Category
- Số comment & likes
- Ngày tạo

**Hành động:**
- Xem chi tiết
- Xem trên trang chính (new tab)
- Xóa bài viết

### Xem chi tiết bài viết
**Route:** `/admin/posts/{post}`

**Hiển thị:**
- Toàn bộ nội dung bài viết
- Thông tin tác giả
- Tags (nếu có)
- Thống kê: likes, comments
- Danh sách tất cả comments

**Hành động:**
- Xem trên trang chính
- Xóa bài viết

### Xóa bài viết
- Xóa trực tiếp từ danh sách hoặc trang chi tiết
- ⚠️ Xác nhận trước khi xóa
- Xóa cascade: bao gồm comments, likes liên quan

## 🏘️ Quản lý cộng đồng

### Xem danh sách cộng đồng
**Route:** `/admin/communities`

**Tính năng:**
- Tìm kiếm theo tên, mô tả
- Hiển thị dạng grid cards
- Phân trang (20 communities/trang)

**Thông tin hiển thị:**
- Cover image/avatar
- Tên cộng đồng
- Mô tả
- Số thành viên
- Số bài viết

**Hành động:**
- Xem chi tiết
- Xem trên trang chính
- Xóa cộng đồng

### Xem chi tiết cộng đồng
**Route:** `/admin/communities/{community}`

**Hiển thị:**
- Thông tin đầy đủ về cộng đồng
- Người tạo
- Thống kê: members, posts
- Danh sách tất cả thành viên
- 10 bài viết gần nhất

**Hành động:**
- Xem trên trang chính
- Xóa cộng đồng

### Xóa cộng đồng
- ⚠️ Xác nhận trước khi xóa
- Xóa cascade: bao gồm members, activities

## 🔒 Bảo mật & Quyền hạn

### Middleware bảo vệ:
- `auth`: Yêu cầu đăng nhập
- `admin`: Kiểm tra role = admin

### Quy tắc:
1. Chỉ admin mới truy cập được `/admin/*`
2. User thường sẽ nhận lỗi 403 Forbidden
3. Admin không thể:
   - Xóa chính mình
   - Thay đổi role của chính mình

## 🎨 Giao diện Admin Panel

### Màu sắc:
- Sidebar: Purple gradient (#6366f1 → #4f46e5)
- Primary buttons: Purple (#9333ea)
- Secondary buttons: Gray
- Danger buttons: Red (#ef4444)

### Layout:
- **Sidebar (trái):** Navigation menu
- **Main content (phải):** Nội dung chính
- **Header:** Tiêu đề trang + nút đăng xuất

### Icons:
Sử dụng Font Awesome 6.4.0:
- Dashboard: `fa-chart-line`
- Users: `fa-users`
- Posts: `fa-newspaper`
- Communities: `fa-users-rectangle`

## 📱 Responsive

Admin Panel responsive hoàn toàn với:
- Desktop: Full sidebar
- Tablet: Collapsible sidebar
- Mobile: Bottom navigation (planned)

## 🔧 Troubleshooting

### Không truy cập được admin panel?
1. Kiểm tra đã đăng nhập chưa
2. Kiểm tra role trong database: `SELECT role FROM users WHERE email = 'your@email.com'`
3. Clear cache: `php artisan cache:clear`

### Lỗi 403 Forbidden?
- User của bạn chưa có role admin
- Chạy: `DB::table('users')->where('email', 'your@email.com')->update(['role' => 'admin']);`

### Migration lỗi?
```bash
php artisan migrate:fresh  # Cẩn thận: xóa toàn bộ data
# Hoặc
php artisan migrate:rollback --step=1
php artisan migrate
```

## 📞 Hỗ trợ

Nếu cần hỗ trợ, vui lòng:
1. Kiểm tra log: `storage/logs/laravel.log`
2. Kiểm tra database connection
3. Đảm bảo đã chạy migration đầy đủ

---

**Phiên bản:** 1.0  
**Ngày cập nhật:** {{ date('d/m/Y') }}  
**Developer:** AnimeTalk Team
