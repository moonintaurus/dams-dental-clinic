<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md
             font-semibold text-xs text-white uppercase tracking-widest
             hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
             transform hover:-translate-y-0.5 hover:scale-[1.02] hover:shadow-lg
             focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
             transition ease-out duration-200'
    ]) }}
>
    {{ $slot }}
</button>
