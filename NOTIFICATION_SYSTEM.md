# Hệ thống Thông báo AnimeTalk

## Tổng quan

Hệ thống thông báo đã được xây dựng hoàn chỉnh với các tính năng:

### ✅ Tính năng đã hoàn thành

1. **Icon chuông với số đếm**
   - Hiển thị số thông báo chưa đọc màu đỏ trên icon chuông
   - Tự động cập nhật khi có thông báo mới
   - Vị trí: Navbar trang home

2. **Các loại thông báo tự động**
   - ✅ **Lời mời kết bạn**: Khi có người gửi lời mời kết bạn
   - 🔔 **Nhắc nhở sự kiện**: Sự kiện sắp diễn ra (cần thêm Scheduler)
   - 🎯 **Sự kiện bắt đầu**: Khi sự kiện đến giờ (cần thêm Scheduler)

3. **Thông báo từ Admin**
   - 📢 Thông báo chung
   - ⚠️ Bảo trì hệ thống
   - 🎉 Sự kiện mới
   - ℹ️ Thông tin khác

## Cấu trúc Database

### Bảng `notifications`
```sql
- id (primary key)
- user_id (nullable) - null = gửi cho tất cả
- type (friend_request, event_reminder, event_starting, admin_announcement, system_maintenance, new_event)
- title (tiêu đề)
- message (nội dung)
- data (JSON - dữ liệu bổ sung)
- action_url (link khi click)
- is_read (đã đọc chưa)
- read_at (thời gian đọc)
- created_at, updated_at
```

## Cách sử dụng

### Cho Admin

1. **Truy cập trang quản lý thông báo**
   - Đăng nhập với tài khoản admin
   - Menu Admin → Thông báo
   - URL: `/admin/notifications`

2. **Gửi thông báo mới**
   - Click "Gửi thông báo mới"
   - Chọn loại thông báo
   - Nhập tiêu đề và nội dung
   - (Tùy chọn) Thêm link hành động
   - Click "Gửi thông báo"

3. **Quản lý thông báo đã gửi**
   - Xem danh sách thông báo
   - Xóa thông báo không cần thiết

### Cho User

1. **Xem thông báo**
   - Click icon chuông trên navbar
   - Xem danh sách thông báo
   - Click "Xem chi tiết" nếu có link

2. **Đánh dấu đã đọc**
   - Click vào thông báo
   - Hoặc "Đánh dấu tất cả đã đọc"

## Thêm thông báo tự động

### Ví dụ: Thông báo khi có comment mới

```php
use App\Models\Notification;

// Trong PostController hoặc CommentController
Notification::createNotification(
    'new_comment',
    'Bình luận mới',
    $commenter->name . ' đã bình luận vào bài viết của bạn',
    $post->user_id, // ID người nhận
    ['post_id' => $post->id, 'comment_id' => $comment->id],
    route('posts.show', $post->slug)
);
```

### Ví dụ: Thông báo sự kiện (cần Scheduler)

Thêm vào `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Nhắc nhở sự kiện trước 1 giờ
    $schedule->call(function () {
        $events = Event::where('event_date', '>=', now())
            ->where('event_date', '<=', now()->addHour())
            ->get();
        
        foreach ($events as $event) {
            foreach ($event->attendees as $user) {
                Notification::createNotification(
                    'event_reminder',
                    'Sự kiện sắp diễn ra',
                    'Sự kiện "' . $event->title . '" sẽ bắt đầu trong 1 giờ nữa!',
                    $user->uid,
                    ['event_id' => $event->id],
                    route('events.show', $event)
                );
            }
        }
    })->hourly();
    
    // Thông báo khi sự kiện bắt đầu
    $schedule->call(function () {
        $events = Event::where('event_date', '>=', now()->subMinutes(5))
            ->where('event_date', '<=', now())
            ->get();
        
        foreach ($events as $event) {
            foreach ($event->attendees as $user) {
                Notification::createNotification(
                    'event_starting',
                    'Sự kiện đang diễn ra',
                    'Sự kiện "' . $event->title . '" đã bắt đầu!',
                    $user->uid,
                    ['event_id' => $event->id],
                    route('events.show', $event)
                );
            }
        }
    })->everyFiveMinutes();
}
```

## Routes

### User Routes
- GET `/notifications` - Xem danh sách thông báo
- GET `/notifications/unread-count` - Lấy số thông báo chưa đọc (API)
- POST `/notifications/{id}/read` - Đánh dấu đã đọc
- POST `/notifications/read-all` - Đánh dấu tất cả đã đọc

### Admin Routes
- GET `/admin/notifications` - Quản lý thông báo
- GET `/admin/notifications/create` - Form gửi thông báo
- POST `/admin/notifications` - Gửi thông báo mới
- DELETE `/admin/notifications/{id}` - Xóa thông báo

## Models

### Notification Model

**Scopes:**
- `forUser($userId)` - Lấy thông báo của user (bao gồm thông báo chung)
- `unread()` - Lấy thông báo chưa đọc

**Methods:**
- `markAsRead()` - Đánh dấu đã đọc
- `createNotification($type, $title, $message, $userId, $data, $actionUrl)` - Tạo thông báo mới

## Tính năng sắp tới

- [ ] Real-time notifications với Pusher/WebSocket
- [ ] Email notification
- [ ] Push notification
- [ ] Scheduler cho event reminders
- [ ] Notification preferences (user settings)

## Testing

Để test hệ thống:

1. **Test thông báo kết bạn:**
   - Tạo 2 tài khoản
   - Gửi lời mời kết bạn
   - Kiểm tra icon chuông có số đếm
   - Click vào xem thông báo

2. **Test thông báo admin:**
   - Đăng nhập admin
   - Gửi thông báo
   - Đăng nhập user bất kỳ
   - Kiểm tra nhận được thông báo

## Notes

- Thông báo của admin (`user_id = null`) sẽ hiển thị cho TẤT CẢ user
- Khi user click vào thông báo có `action_url`, sẽ tự động đánh dấu đã đọc
- Badge số đếm chỉ hiển thị khi có thông báo chưa đọc
- Hệ thống hỗ trợ nhiều loại thông báo, dễ dàng mở rộng
