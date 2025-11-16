# 🚀 Quick Setup Guide - AnimeTalk Forum

## Step 1: Database Setup

Open your MySQL client (phpMyAdmin or command line) and run:

```sql
CREATE DATABASE anime_forum CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then import the SQL file:

```bash
mysql -u root -p anime_forum < database/anime_forum.sql
```

Or use Laravel migrations:

```bash
php artisan migrate
php artisan db:seed --class=ForumSeeder
```

## Step 2: Environment Configuration

1. Copy the example environment file:
```bash
copy .env.example .env
```

2. Edit `.env` and update these lines:
```env
DB_DATABASE=anime_forum
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

3. Generate application key:
```bash
php artisan key:generate
```

## Step 3: Storage Setup

Create the symbolic link for file uploads:

```bash
php artisan storage:link
```

## Step 4: Install Dependencies

```bash
composer install
```

## Step 5: Run the Application

```bash
php artisan serve
```

Visit: http://localhost:8000

## 🎯 Default Pages to Visit

1. **Home**: http://localhost:8000/
2. **Community**: http://localhost:8000/community
3. **Events**: http://localhost:8000/events
4. **Search**: http://localhost:8000/search

## 📝 Create Your First Post

1. Register a new account (you'll need to set up authentication first)
2. Go to "Create Post" button in navigation
3. Fill in the form and publish!

## 🔐 Setting Up Authentication (Laravel Breeze)

If you want user authentication:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run dev
php artisan migrate
```

## 🎨 Customization

- **Colors**: Edit `public/css/anime-forum.css` (`:root` section)
- **Database**: Modify migrations in `database/migrations/`
- **Views**: Update Blade files in `resources/views/`
- **Logic**: Edit controllers in `app/Http/Controllers/`

## ✅ Verification Checklist

- [ ] Database created and imported
- [ ] .env file configured
- [ ] Storage link created
- [ ] Application key generated
- [ ] Dependencies installed
- [ ] Server running successfully
- [ ] Can access home page
- [ ] CSS styles loading properly

## 🆘 Common Issues

### CSS Not Loading
✅ Solution: Check that `public/css/anime-forum.css` exists

### Database Connection Failed
✅ Solution: Verify DB credentials in `.env` file

### 404 Not Found
✅ Solution: Make sure you're accessing via `php artisan serve` URL

### Storage Folder Permissions
✅ Solution: On Linux/Mac run: `chmod -R 775 storage bootstrap/cache`

---

Need help? Check the full README_ANIME_FORUM.md file!
