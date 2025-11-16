# AnimeTalk - Anime Community Forum

A modern, feature-rich anime community forum built with Laravel using MVC architecture. Features a soft, chill aesthetic inspired by anime art styles with pastel colors and smooth animations.

## 🎨 Features

### Core Functionality
- **Home Page**: Discover new posts filtered by tags with a beautiful hero section
- **Community Forums**: Navigate sub-forums organized by tags (Anime, Manga, Cosplay, etc.)
- **Events Page**: Discover upcoming anime releases, cosplay events, and conventions
- **Profile Management**: Manage your posts, create new content, and customize your profile
- **Advanced Search**: Search posts and forums by keywords and tags
- **Authentication**: User registration, login, and profile management

### Design Features
- Soft pastel color palette (purples, pinks, blues)
- Smooth animations and hover effects
- Responsive design for all devices
- Clean, modern UI with rounded corners
- Gradient accents and subtle shadows

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM (optional, for Vite)
- XAMPP/WAMP/MAMP or similar local server

## 🚀 Installation

### 1. Database Setup

#### Option A: Using the SQL File (Recommended)
```bash
# Import the database schema
mysql -u root -p < database/anime_forum.sql
```

#### Option B: Using Laravel Migrations
```bash
# Run migrations
php artisan migrate
```

### 2. Configure Environment

1. Copy `.env.example` to `.env`:
```bash
copy .env.example .env
```

2. Update database credentials in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=anime_forum
DB_USERNAME=root
DB_PASSWORD=
```

3. Generate application key:
```bash
php artisan key:generate
```

### 3. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies (optional)
npm install
```

### 4. Storage Setup

```bash
# Create symbolic link for storage
php artisan storage:link
```

### 5. Run the Application

```bash
# Start the development server
php artisan serve
```

Visit: `http://localhost:8000`

## 📁 Project Structure

```
AnimeTalk/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php
│   │       ├── CommunityController.php
│   │       ├── EventController.php
│   │       ├── PostController.php
│   │       ├── CommentController.php
│   │       ├── ProfileController.php
│   │       └── SearchController.php
│   └── Models/
│       ├── User.php
│       ├── Forum.php
│       ├── Post.php
│       ├── Tag.php
│       ├── Event.php
│       └── Comment.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000003_create_tags_table.php
│   │   ├── 2024_01_01_000004_create_forums_table.php
│   │   ├── 2024_01_01_000005_create_posts_table.php
│   │   ├── 2024_01_01_000006_create_events_table.php
│   │   ├── 2024_01_01_000007_create_comments_table.php
│   │   ├── 2024_01_01_000008_create_post_tag_table.php
│   │   └── 2024_01_01_000009_create_forum_tag_table.php
│   └── anime_forum.sql (Complete MySQL schema with sample data)
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       ├── community/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── events/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── posts/
│       │   ├── create.blade.php
│       │   └── show.blade.php
│       ├── profile/
│       │   ├── show.blade.php
│       │   └── edit.blade.php
│       └── search/
│           └── index.blade.php
├── public/
│   └── css/
│       └── anime-forum.css (Complete styling)
└── routes/
    └── web.php
```

## 🎨 Color Palette

The application uses a soft, chill color scheme:

- **Primary Purple**: `#A8B3E8`
- **Primary Pink**: `#F4A8C0`
- **Primary Blue**: `#A8D5E8`
- **Secondary Lavender**: `#D8C8F8`
- **Secondary Peach**: `#F8D8C8`
- **Secondary Mint**: `#C8F8E8`
- **Background**: `#FAFBFF` to `#F0F3FF` (gradient)

## 🔑 Key Routes

### Public Routes
- `GET /` - Home page with latest posts
- `GET /community` - Browse all forums
- `GET /community/{slug}` - View specific forum
- `GET /events` - Browse upcoming events
- `GET /posts/{slug}` - View post details
- `GET /search` - Search posts and forums

### Protected Routes (Require Authentication)
- `GET /profile` - User profile
- `GET /profile/edit` - Edit profile
- `GET /posts/create/new` - Create new post
- `POST /posts` - Store new post
- `POST /comments` - Add comment

## 📊 Database Schema

### Main Tables
- **users** - User accounts
- **forums** - Sub-forums (Anime Discussion, Manga Corner, etc.)
- **posts** - User posts in forums
- **tags** - Tags for categorization (Anime, Manga, Cosplay, etc.)
- **events** - Upcoming events (releases, cosplay, conventions)
- **comments** - Replies to posts

### Pivot Tables
- **post_tag** - Many-to-many relationship between posts and tags
- **forum_tag** - Many-to-many relationship between forums and tags

## 🎯 Usage

### Creating a Post
1. Log in to your account
2. Click "Create Post" in the navigation
3. Fill in the title, select a forum, add content
4. Optionally add an image and select tags
5. Click "Publish Post"

### Browsing Forums
1. Go to "Community" page
2. Filter forums by tags if needed
3. Click on a forum to view its posts
4. Click on any post to read and comment

### Searching
1. Use the search bar in the navigation
2. Enter keywords and select type (posts/forums/all)
3. Filter by tags for more specific results

## 🔧 Customization

### Changing Colors
Edit `public/css/anime-forum.css` and modify the CSS variables in the `:root` section.

### Adding New Features
1. Create a new migration for database changes
2. Add/update models with relationships
3. Create controllers following the MVC pattern
4. Define routes in `routes/web.php`
5. Create Blade views in `resources/views`

## 📝 Sample Data

The SQL file includes sample data:
- 6 predefined tags (Anime, Manga, Cosplay, Gaming, Art, Discussion)
- 5 forums with descriptions and icons
- Forum-tag relationships

## 🐛 Troubleshooting

### CSS Not Loading
Ensure the CSS file is in `public/css/anime-forum.css` and check the asset path in the layout.

### Database Connection Error
Verify your `.env` database credentials match your MySQL setup.

### Storage Permission Error
Run: `php artisan storage:link` and ensure storage folders have write permissions.

## 📄 License

This project is open-source and available for educational purposes.

## 🤝 Contributing

Feel free to fork, modify, and enhance the project!

---

Built with ❤️ using Laravel MVC Architecture
