# 🔧 Developer Quick Reference - AnimeTalk Forum

## 🚀 Quick Start Commands

```bash
# Setup
php artisan migrate
php artisan db:seed --class=ForumSeeder
php artisan storage:link
php artisan key:generate

# Run Application
php artisan serve

# Clear Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📂 File Locations

### Need to modify...

**Database Schema?**
→ `database/migrations/*.php`
→ `database/anime_forum.sql`

**Business Logic?**
→ `app/Http/Controllers/*.php`

**Data Models?**
→ `app/Models/*.php`

**Page Layout?**
→ `resources/views/*.blade.php`

**Styling?**
→ `public/css/anime-forum.css`

**Routes?**
→ `routes/web.php`

**Sample Data?**
→ `database/seeders/ForumSeeder.php`

## 🎨 Quick Style Reference

```css
/* Primary Colors */
--primary-purple: #A8B3E8  /* Main brand */
--primary-pink: #F4A8C0    /* Accents */
--primary-blue: #A8D5E8    /* Info */

/* Gradients */
linear-gradient(135deg, #A8B3E8 0%, #F4A8C0 100%)  /* Primary */
linear-gradient(135deg, #F4A8C0 0%, #F8D8C8 100%)  /* Accent */

/* Shadows */
var(--shadow-sm)   /* Subtle */
var(--shadow-md)   /* Medium */
var(--shadow-lg)   /* Strong */

/* Radius */
var(--border-radius-sm)  /* 12px - buttons */
var(--border-radius)     /* 16px - cards */
var(--border-radius-lg)  /* 24px - hero */
```

## 🗄️ Database Tables Quick Ref

```sql
users          - User accounts (id, name, email, avatar, bio)
forums         - Sub-forums (id, name, slug, description, icon)
posts          - User posts (id, user_id, forum_id, title, content, image)
tags           - Categories (id, name, slug, color)
events         - Upcoming events (id, user_id, title, event_date, type)
comments       - Post replies (id, user_id, post_id, content)
post_tag       - Posts ↔ Tags relationship
forum_tag      - Forums ↔ Tags relationship
```

## 🔗 Model Relationships

```php
// User
$user->posts         // User's posts
$user->comments      // User's comments
$user->events        // User's events

// Post
$post->user          // Post author
$post->forum         // Post's forum
$post->tags          // Post's tags
$post->comments      // Post's comments

// Forum
$forum->posts        // Forum's posts
$forum->tags         // Forum's tags

// Tag
$tag->posts          // Tagged posts
$tag->forums         // Tagged forums
```

## 📍 Important Routes

```php
// Public
Route::get('/', [HomeController::class, 'index'])
Route::get('/community', [CommunityController::class, 'index'])
Route::get('/events', [EventController::class, 'index'])
Route::get('/search', [SearchController::class, 'index'])

// Auth Required
Route::get('/profile', [ProfileController::class, 'show'])
Route::get('/posts/create/new', [PostController::class, 'create'])
Route::post('/posts', [PostController::class, 'store'])
Route::post('/comments', [CommentController::class, 'store'])
```

## 🎯 Common Tasks

### Adding a New Forum
```php
use App\Models\Forum;

Forum::create([
    'name' => 'New Forum',
    'slug' => 'new-forum',
    'description' => 'Description here',
    'icon' => '🎮',
]);
```

### Creating a Post
```php
use App\Models\Post;

$post = Post::create([
    'user_id' => auth()->id(),
    'forum_id' => 1,
    'title' => 'Post Title',
    'slug' => Str::slug('Post Title'),
    'content' => 'Content here',
]);

$post->tags()->attach([1, 2, 3]); // Add tags
```

### Adding a Tag
```php
use App\Models\Tag;

Tag::create([
    'name' => 'New Tag',
    'slug' => 'new-tag',
    'color' => '#A8B3E8',
    'description' => 'Tag description',
]);
```

### Creating an Event
```php
use App\Models\Event;

Event::create([
    'user_id' => auth()->id(),
    'title' => 'Event Title',
    'slug' => Str::slug('Event Title'),
    'description' => 'Event description',
    'type' => 'anime_release',
    'event_date' => '2024-12-31 19:00:00',
    'location' => 'Tokyo, Japan',
]);
```

## 🔍 Debugging Tips

### Check Database Connection
```php
php artisan tinker
DB::connection()->getPdo();
```

### Test a Model
```php
php artisan tinker
App\Models\Post::with('user', 'forum', 'tags')->first();
```

### Clear Everything
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Check Routes
```bash
php artisan route:list
```

## 🎨 CSS Class Quick Reference

### Layouts
```html
.container          - Max-width content wrapper
.navbar             - Top navigation
.main-content       - Page content area
.footer             - Bottom footer
```

### Components
```html
.post-card          - Post card in grid
.forum-card         - Forum listing card
.event-card         - Event card
.tag-badge          - Small tag indicator
.filter-tag         - Tag filter button
```

### Buttons
```html
.btn-primary        - Main action button
.btn-outline        - Secondary button
.btn-create         - Create/add button
.btn-view           - View details button
```

### Forms
```html
.form-group         - Form field wrapper
.create-post-form   - Post creation form
.comment-form       - Comment form
```

## 📊 Sample Queries

### Get Popular Posts
```php
$posts = Post::withCount('comments')
    ->orderBy('comments_count', 'desc')
    ->take(10)
    ->get();
```

### Search Posts by Tag
```php
$posts = Post::whereHas('tags', function($q) {
    $q->where('slug', 'anime');
})->get();
```

### Get User's Posts with Stats
```php
$posts = auth()->user()->posts()
    ->with(['forum', 'tags', 'comments'])
    ->withCount('comments')
    ->get();
```

### Upcoming Events
```php
$events = Event::where('event_date', '>=', now())
    ->orderBy('event_date', 'asc')
    ->get();
```

## ⚡ Performance Tips

```php
// Always eager load relationships
Post::with(['user', 'forum', 'tags'])->get();

// Use pagination for large datasets
Post::paginate(15);

// Cache expensive queries
Cache::remember('popular_tags', 3600, function() {
    return Tag::withCount('posts')->get();
});
```

## 🔐 Security Checklist

```php
// ✅ Always validate input
$request->validate([
    'title' => 'required|max:255',
    'content' => 'required',
]);

// ✅ Use mass assignment protection
protected $fillable = ['title', 'content'];

// ✅ Protect routes
Route::middleware('auth')->group(function() {
    // Protected routes
});

// ✅ Escape output (Blade does automatically)
{{ $post->title }}  // Escaped
{!! $post->content !!}  // Unescaped (be careful)
```

## 📝 Blade Directives Quick Ref

```blade
@extends('layouts.app')
@section('content') ... @endsection
@yield('title')

@if($condition) ... @endif
@foreach($items as $item) ... @endforeach
@forelse($items as $item) ... @empty ... @endforelse

@auth ... @endauth
@guest ... @endguest

{{ $variable }}  // Escaped
{!! $html !!}    // Unescaped

@csrf            // CSRF token
@method('PUT')   // Method spoofing

{{ asset('css/style.css') }}  // Asset URL
{{ route('home') }}           // Named route
```

## 🎯 Next Steps for Development

1. **Add Authentication**
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   ```

2. **Add Image Optimization**
   ```bash
   composer require intervention/image
   ```

3. **Add Rich Text Editor**
   - Include TinyMCE or Quill.js
   - Update post create form

4. **Add Real-time Features**
   ```bash
   composer require pusher/pusher-php-server
   ```

5. **Deploy to Production**
   - Set up .env for production
   - Run migrations on production DB
   - Configure web server (Apache/Nginx)

## 📚 Helpful Resources

- Laravel Docs: https://laravel.com/docs
- Eloquent Relationships: https://laravel.com/docs/eloquent-relationships
- Blade Templates: https://laravel.com/docs/blade
- Validation: https://laravel.com/docs/validation

---

**Pro Tip**: Keep this file bookmarked for quick reference during development!
