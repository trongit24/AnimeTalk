# 🚀 Hướng Dẫn Build Theme Anime

## Vấn Đề PowerShell Execution Policy

Nếu gặp lỗi "running scripts is disabled", làm theo các bước sau:

### Cách 1: Chạy trong CMD (Khuyến nghị)
```cmd
cd c:\xampp\htdocs\AnimeTalk
npm run build
```

### Cách 2: Cho phép PowerShell chạy scripts (Chỉ cần làm 1 lần)
```powershell
# Chạy PowerShell as Administrator
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser

# Sau đó chạy:
cd c:\xampp\htdocs\AnimeTalk
npm run build
```

### Cách 3: Bypass execution policy tạm thời
```powershell
powershell -ExecutionPolicy Bypass -Command "npm run build"
```

## Build Commands

### Development Mode (Tự động rebuild khi thay đổi file)
```bash
npm run dev
```

### Production Build (Tối ưu cho production)
```bash
npm run build
```

## Kiểm Tra Sau Khi Build

1. ✅ Kiểm tra folder `public/build/` có chứa file CSS và JS
2. ✅ Truy cập `http://localhost/anime-demo` để xem theme mới
3. ✅ Xóa cache browser (Ctrl + Shift + R hoặc Ctrl + F5)

## Nếu Assets Không Load

### 1. Clear Laravel Cache
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### 2. Rebuild Assets
```bash
npm run build
```

### 3. Check Vite Config
Đảm bảo `vite.config.js` có cấu hình đúng:
```javascript
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

## Development Workflow

1. **Start Dev Server**
   ```bash
   npm run dev
   ```

2. **Mở Browser**
   - Trang chủ: `http://localhost/`
   - Demo: `http://localhost/anime-demo`

3. **Edit Files**
   - CSS: `resources/css/app.css`
   - Views: `resources/views/`
   - Components: `resources/views/components/`

4. **Tự động reload** khi file thay đổi (nhờ Vite HMR)

## Production Deployment

```bash
# 1. Build production assets
npm run build

# 2. Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Deploy to server
```

## Troubleshooting

### Assets 404 Not Found
- Kiểm tra `APP_URL` trong `.env`
- Chạy `npm run build` lại
- Clear browser cache

### Styles không áp dụng
- Kiểm tra `data-theme="anime-day"` trong `<html>` tag
- Đảm bảo DaisyUI đã cài: `npm install`
- Rebuild: `npm run build`

### Font không load
- Fonts được load từ Google Fonts CDN
- Kiểm tra kết nối internet
- Xem console browser có lỗi không

---

**Lưu ý**: Luôn chạy `npm run build` trước khi deploy production!
