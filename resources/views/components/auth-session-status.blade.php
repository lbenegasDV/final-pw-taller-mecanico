@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' =>
            'mb-4 rounded-md bg-emerald-500/10 border border-emerald-500/40 px-4 py-3 text-sm text-emerald-200',
    ]) }}>
        {{ $status }}
    </div>
@endif

