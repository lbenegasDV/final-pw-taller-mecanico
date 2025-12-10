@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-emerald-500 bg-slate-900 text-base font-medium text-slate-50 focus:outline-none focus:bg-slate-800 focus:text-slate-50'
                : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-slate-300 hover:text-slate-50 hover:bg-slate-900 hover:border-slate-700 focus:outline-none focus:bg-slate-900 focus:text-slate-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
