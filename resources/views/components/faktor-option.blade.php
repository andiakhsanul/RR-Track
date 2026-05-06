@props([
    'faktor',
    'checked' => false,
    'tone' => 'orange',
    'compact' => false,
])

@php
    $toneClasses = match ($tone) {
        'red' => [
            'checkedBorder' => 'border-red-400 bg-red-50',
            'hoverBorder' => 'hover:border-red-300 hover:bg-red-50',
            'input' => 'text-red-600 focus:ring-red-500',
            'tooltip' => 'bg-red-600',
        ],
        default => [
            'checkedBorder' => 'border-orange-400 bg-orange-50',
            'hoverBorder' => 'hover:border-orange-300 hover:bg-orange-50',
            'input' => 'text-orange-600 focus:ring-orange-500',
            'tooltip' => 'bg-slate-900',
        ],
    };

    $label = $faktor->nama_utama;
    $detail = $faktor->detail;
@endphp

<label
    title="{{ $detail ?: $label }}"
    {{ $attributes->class([
        'group relative flex cursor-pointer items-center rounded-xl border-2 bg-slate-50 transition-all',
        $compact ? 'min-h-[56px] px-3 py-2.5' : 'min-h-[72px] p-4',
        $checked ? $toneClasses['checkedBorder'] : 'border-slate-200',
        $toneClasses['hoverBorder'],
    ]) }}
>
    <input type="checkbox" name="faktor[]" value="{{ $faktor->id_faktor }}"
        class="{{ $compact ? 'h-4 w-4' : 'h-5 w-5' }} shrink-0 rounded border-slate-300 {{ $toneClasses['input'] }}"
        {{ $checked ? 'checked' : '' }}>

    <span class="{{ $compact ? 'ml-2 text-sm' : 'ml-3 text-base' }} font-semibold leading-snug text-slate-700 group-hover:text-slate-950">
        {{ $label }}
    </span>

    @if ($detail)
        <span
            class="pointer-events-none absolute left-4 top-full z-30 mt-2 hidden max-w-xs rounded-lg px-3 py-2 text-sm font-medium leading-snug text-white shadow-xl group-hover:block {{ $toneClasses['tooltip'] }}">
            {{ $detail }}
        </span>
    @endif
</label>
