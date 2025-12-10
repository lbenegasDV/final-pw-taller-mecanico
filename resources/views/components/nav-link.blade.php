@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-slate-50 bg-slate-800 border border-emerald-500/60 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-950'
                : 'inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:text-slate-50 hover:bg-slate-800/70 border border-transparent focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-950 transition-colors duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
