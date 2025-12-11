<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-anime btn-primary inline-flex items-center px-6 py-3 bg-anime-blue border-none rounded-anime font-medium text-white shadow-soft hover:shadow-anime transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-anime-sky/30 transition-all duration-300']) }}>
    {{ $slot }}
</button>
