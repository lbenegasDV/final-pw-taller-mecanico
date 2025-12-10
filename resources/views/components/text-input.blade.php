@props(['disabled' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'class' =>
            'border-slate-700 bg-slate-950 text-slate-100 placeholder-slate-500 rounded-md shadow-sm ' .
            'focus:border-emerald-500 focus:ring-emerald-500 ' .
            'disabled:bg-slate-900 disabled:text-slate-500 disabled:border-slate-800',
    ]) !!}
>
