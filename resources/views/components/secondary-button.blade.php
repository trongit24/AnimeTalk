<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-anime btn-ghost inline-flex items-center px-6 py-3 bg-white border-2 border-anime-sky/30 rounded-anime font-medium text-gray-700 shadow-soft hover:shadow-anime hover:bg-anime-sky/10 transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-anime-sky/20 disabled:opacity-50 transition-all duration-300']) }}>
    {{ $slot }}
</button>
