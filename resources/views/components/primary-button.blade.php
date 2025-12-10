<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'inline-flex items-center justify-center px-4 py-2 bg-emerald-600 border border-emerald-500/80 rounded-md ' .
            'font-semibold text-xs text-white uppercase tracking-widest ' .
            'hover:bg-emerald-500 hover:border-emerald-400 ' .
            'focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-950 ' .
            'disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-150',
    ]) }}
>
    {{ $slot }}
</button>
