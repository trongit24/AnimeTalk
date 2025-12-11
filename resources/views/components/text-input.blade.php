@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input-anime w-full rounded-soft border-2 border-anime-sky/30 focus:border-anime-blue focus:ring-4 focus:ring-anime-sky/20 px-4 py-3 bg-white/80 backdrop-blur-sm placeholder:text-gray-400 transition-all duration-300']) }}>
