@extends('layouts.anime-app')

@section('title', 'Anime Day Theme Demo - AnimeTalk')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <section class="mb-12 fade-in">
        <div class="card-anime text-center py-12 bg-gradient-to-br from-anime-sky to-anime-mint">
            <h1 class="text-5xl font-bold text-white mb-4 text-shadow-soft">Welcome to AnimeTalk</h1>
            <p class="text-xl text-white/90 mb-8">A sunny day anime community 🌤️</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="btn btn-anime btn-primary btn-lg">Get Started</a>
                <a href="#" class="btn btn-anime btn-secondary btn-lg">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-anime hover-lift">
                <div class="w-16 h-16 bg-anime-blue rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="bi bi-people-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2 text-center">Communities</h3>
                <p class="text-gray-600 text-center">Join vibrant anime communities and connect with fellow fans.</p>
            </div>

            <div class="card-anime hover-lift">
                <div class="w-16 h-16 bg-anime-mint rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="bi bi-chat-dots-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2 text-center">Messaging</h3>
                <p class="text-gray-600 text-center">Chat with friends in our beautiful messaging interface.</p>
            </div>

            <div class="card-anime hover-lift">
                <div class="w-16 h-16 bg-anime-pink/70 rounded-full flex items-center justify-center mb-4 mx-auto">
                    <i class="bi bi-calendar-event-fill text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2 text-center">Events</h3>
                <p class="text-gray-600 text-center">Discover and join exciting anime events and watch parties.</p>
            </div>
        </div>
    </section>

    <!-- Chat Demo -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Chat Preview</h2>
        <div class="max-w-3xl mx-auto bg-white/80 backdrop-blur-sm rounded-anime shadow-anime p-6">
            <div class="space-y-4">
                <!-- User Message -->
                <div class="flex justify-end">
                    <div class="chat-bubble-user slide-up">
                        <p>Hey! Have you watched the latest episode? 🎉</p>
                    </div>
                </div>

                <!-- Bot Message -->
                <div class="flex justify-start items-start space-x-3">
                    <div class="avatar-anime w-10 h-10 flex-shrink-0">
                        <div class="w-full h-full bg-anime-mint rounded-full flex items-center justify-center">
                            <i class="bi bi-robot text-white"></i>
                        </div>
                    </div>
                    <div class="chat-bubble-bot slide-up" style="animation-delay: 0.1s;">
                        <p>Yes! It was amazing! The animation quality was incredible! ✨</p>
                    </div>
                </div>

                <!-- User Message -->
                <div class="flex justify-end">
                    <div class="chat-bubble-user slide-up" style="animation-delay: 0.2s;">
                        <p>I know right! Can't wait for next week! 😊</p>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="mt-6">
                <div class="flex space-x-3">
                    <input type="text" placeholder="Type your message..." class="input-anime flex-1">
                    <button class="btn btn-anime btn-primary btn-square">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Buttons Showcase -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Button Styles</h2>
        <div class="flex flex-wrap gap-4 justify-center">
            <button class="btn btn-anime btn-primary">Primary Button</button>
            <button class="btn btn-anime btn-secondary">Secondary Button</button>
            <button class="btn btn-anime btn-accent">Accent Button</button>
            <button class="btn btn-anime btn-success">Success Button</button>
            <button class="btn btn-anime btn-warning">Warning Button</button>
            <button class="btn btn-anime btn-error">Error Button</button>
            <button class="btn btn-anime btn-ghost">Ghost Button</button>
        </div>
    </section>

    <!-- Form Elements -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Form Elements</h2>
        <div class="max-w-2xl mx-auto card-anime">
            <form class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Username</label>
                    <input type="text" placeholder="Enter your username" class="input-anime w-full">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" placeholder="your@email.com" class="input-anime w-full">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Favorite Anime</label>
                    <select class="input-anime w-full">
                        <option>Select your favorite</option>
                        <option>One Piece</option>
                        <option>Naruto</option>
                        <option>Attack on Titan</option>
                        <option>My Hero Academia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">About You</label>
                    <textarea placeholder="Tell us about yourself..." class="input-anime w-full h-32 resize-none"></textarea>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" class="btn btn-anime btn-ghost">Cancel</button>
                    <button type="submit" class="btn btn-anime btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Tags/Badges -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Tags & Badges</h2>
        <div class="flex flex-wrap gap-3 justify-center">
            <span class="badge-anime">Action</span>
            <span class="badge-anime">Comedy</span>
            <span class="badge-anime">Drama</span>
            <span class="badge-anime">Romance</span>
            <span class="badge-anime">Slice of Life</span>
            <span class="badge-anime">Fantasy</span>
            <span class="badge-anime">Sci-Fi</span>
        </div>
    </section>

    <!-- Cards Grid -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Post Cards</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <article class="post-card hover-lift">
                <div class="flex items-start space-x-4 mb-4">
                    <div class="avatar-anime w-12 h-12">
                        <div class="w-full h-full bg-anime-blue rounded-full flex items-center justify-center text-white font-semibold">
                            A
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-700">Anime Fan</h3>
                        <p class="text-sm text-gray-500">2 hours ago</p>
                    </div>
                    <span class="badge-anime">Discussion</span>
                </div>
                
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Best Anime of the Season?</h2>
                <p class="text-gray-600 mb-4">What do you think is the best anime this season? I'm really enjoying the new releases!</p>
                
                <div class="flex items-center space-x-6 text-gray-500">
                    <button class="flex items-center space-x-2 hover:text-anime-blue transition-colors">
                        <i class="bi bi-heart"></i>
                        <span>42</span>
                    </button>
                    <button class="flex items-center space-x-2 hover:text-anime-blue transition-colors">
                        <i class="bi bi-chat"></i>
                        <span>15</span>
                    </button>
                    <button class="flex items-center space-x-2 hover:text-anime-blue transition-colors">
                        <i class="bi bi-share"></i>
                        <span>Share</span>
                    </button>
                </div>
            </article>

            <article class="post-card hover-lift">
                <div class="flex items-start space-x-4 mb-4">
                    <div class="avatar-anime w-12 h-12">
                        <div class="w-full h-full bg-anime-mint rounded-full flex items-center justify-center text-white font-semibold">
                            M
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-700">Manga Reader</h3>
                        <p class="text-sm text-gray-500">5 hours ago</p>
                    </div>
                    <span class="badge-anime">Recommendation</span>
                </div>
                
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Hidden Gem Anime</h2>
                <p class="text-gray-600 mb-4">Check out this underrated anime that deserves more attention! The story is incredible.</p>
                
                <div class="flex items-center space-x-6 text-gray-500">
                    <button class="flex items-center space-x-2 hover:text-anime-blue transition-colors">
                        <i class="bi bi-heart-fill text-red-400"></i>
                        <span>128</span>
                    </button>
                    <button class="flex items-center space-x-2 hover:text-anime-blue transition-colors">
                        <i class="bi bi-chat"></i>
                        <span>34</span>
                    </button>
                    <button class="flex items-center space-x-2 hover:text-anime-blue transition-colors">
                        <i class="bi bi-share"></i>
                        <span>Share</span>
                    </button>
                </div>
            </article>
        </div>
    </section>

    <!-- Notification Examples -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Notifications</h2>
        <div class="max-w-2xl mx-auto space-y-4">
            <div class="alert alert-success bg-anime-mint/30 border border-anime-mint rounded-anime p-4 fade-in">
                <i class="bi bi-check-circle-fill text-green-600"></i>
                <span class="text-gray-700">Your post has been published successfully!</span>
            </div>

            <div class="alert alert-info bg-anime-blue/20 border border-anime-blue rounded-anime p-4 fade-in" style="animation-delay: 0.1s;">
                <i class="bi bi-info-circle-fill text-blue-600"></i>
                <span class="text-gray-700">You have 3 new messages from friends.</span>
            </div>

            <div class="alert alert-warning bg-anime-yellow/50 border border-anime-yellow rounded-anime p-4 fade-in" style="animation-delay: 0.2s;">
                <i class="bi bi-exclamation-triangle-fill text-yellow-600"></i>
                <span class="text-gray-700">Your session will expire in 5 minutes.</span>
            </div>
        </div>
    </section>

    <!-- Stats Cards -->
    <section class="mb-12">
        <h2 class="text-3xl font-semibold text-gray-700 mb-8 text-center">Community Stats</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card-anime text-center hover-lift">
                <div class="text-4xl font-bold text-anime-blue mb-2">1.2K</div>
                <div class="text-gray-600">Active Users</div>
            </div>

            <div class="card-anime text-center hover-lift">
                <div class="text-4xl font-bold text-anime-mint mb-2">350</div>
                <div class="text-gray-600">Communities</div>
            </div>

            <div class="card-anime text-center hover-lift">
                <div class="text-4xl font-bold text-pink-400 mb-2">5.8K</div>
                <div class="text-gray-600">Posts Today</div>
            </div>

            <div class="card-anime text-center hover-lift">
                <div class="text-4xl font-bold text-yellow-400 mb-2">98%</div>
                <div class="text-gray-600">Happy Users</div>
            </div>
        </div>
    </section>
</div>
@endsection
