<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-anime btn-error inline-flex items-center justify-center px-6 py-3 bg-red-400 border-none rounded-anime font-medium text-white shadow-soft hover:shadow-anime hover:bg-red-500 transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-red-300/30 transition-all duration-300']) }}>
    {{ $slot }}
</button>
