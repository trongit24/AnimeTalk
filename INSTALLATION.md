# AnimeTalk - Hướng Dẫn Cài Đặt

## Yêu Cầu Hệ Thống

- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js & NPM (tùy chọn, cho frontend assets)
- XAMPP hoặc môi trường PHP tương tự

## Các Bước Cài Đặt

### 1. Clone Repository

```bash
git clone https://github.com/trongit24/AnimeTalk.git
cd AnimeTalk
```

### 2. Cài Đặt Dependencies

Cài đặt PHP dependencies qua Composer:

```bash
composer install
```

Nếu sử dụng NPM (tùy chọn):

```bash
npm install
```

### 3. Tạo File Cấu Hình

Copy file `.env.example` thành `.env`:

**Trên Windows:**
```bash
copy .env.example .env
```

**Trên Mac/Linux:**
```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Cấu Hình Database

Mở file `.env` và cấu hình thông tin database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anime_forum
DB_USERNAME=root
DB_PASSWORD=
```

**Lưu ý:** Tạo database `anime_forum` trong phpMyAdmin hoặc MySQL trước khi chạy migrations.

### 6. Tạo Database

Trong phpMyAdmin hoặc MySQL CLI:

```sql
CREATE DATABASE anime_forum CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Chạy Migrations

```bash
php artisan migrate
```

Lệnh này sẽ tạo tất cả các bảng cần thiết:
- users
- posts
- comments
- communities
- events
- event_participants
- event_notifications
- messages
- friendships
- và các bảng khác

### 8. Tạo Symbolic Link cho Storage

```bash
php artisan storage:link
```

Lệnh này tạo link từ `public/storage` đến `storage/app/public` để truy cập uploaded files.

### 9. Tạo Admin Account (Tùy chọn)

Để truy cập admin panel, bạn cần tạo user với role admin:

1. Đăng ký tài khoản thông thường qua giao diện web
2. Vào database và update role:

```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

### 10. Chạy Development Server

```bash
php artisan serve
```

Hoặc nếu dùng XAMPP, truy cập: `http://localhost/AnimeTalk/public`

Ứng dụng sẽ chạy tại: `http://127.0.0.1:8000`

## Tính Năng Chính

- ✅ Đăng bài viết (văn bản, hình ảnh, video)
- ✅ Bình luận và thích bài viết
- ✅ Cộng đồng (Communities)
- ✅ Kết bạn và nhắn tin
- ✅ Sự kiện (Events) với thông báo
- ✅ Admin panel quản lý
- ✅ Responsive design

## Cấu Trúc Thư Mục Quan Trọng

```
AnimeTalk/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/               # Eloquent Models
│   └── Console/Commands/     # Artisan Commands
├── database/
│   └── migrations/           # Database migrations
├── resources/
│   └── views/                # Blade templates
├── routes/
│   ├── web.php              # Web routes
│   └── console.php          # Console routes
├── public/
│   ├── css/                 # CSS files
│   └── storage/             # Uploaded files (symbolic link)
└── storage/
    └── app/public/          # File storage
```

## Scheduled Tasks (Tùy chọn)

Để chạy event reminders tự động, thiết lập cron job:

**Trên Windows (Task Scheduler):**
```
Program: C:\xampp\php\php.exe
Arguments: C:\xampp\htdocs\AnimeTalk\artisan schedule:run
Trigger: Every hour
```

**Trên Mac/Linux (Crontab):**
```bash
* * * * * cd /path/to/AnimeTalk && php artisan schedule:run >> /dev/null 2>&1
```

## Troubleshooting

### Lỗi: "Permission denied" trên storage

```bash
chmod -R 775 storage bootstrap/cache
```

### Lỗi: "Class not found"

```bash
composer dump-autoload
```

### Lỗi: "SQLSTATE connection refused"

- Kiểm tra MySQL đã chạy chưa
- Kiểm tra thông tin DB_HOST, DB_PORT trong .env
- Đảm bảo database đã được tạo

### Lỗi: "The stream or file could not be opened"

```bash
php artisan cache:clear
php artisan config:clear
```

## Admin Panel

Truy cập admin panel tại: `http://localhost/AnimeTalk/public/admin`

**Yêu cầu:** User phải có `role = 'admin'` trong database.

**Tính năng admin:**
- Quản lý người dùng
- Quản lý bài viết
- Quản lý cộng đồng
- Quản lý sự kiện
- Thống kê dashboard

## Testing Account

Sau khi cài đặt, bạn có thể tạo account test để sử dụng.

## Liên Hệ & Hỗ Trợ

- Repository: https://github.com/trongit24/AnimeTalk
- Issues: https://github.com/trongit24/AnimeTalk/issues

## License

This project is open-sourced software.
