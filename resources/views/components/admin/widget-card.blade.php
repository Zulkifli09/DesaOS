@props(['title', 'value', 'icon', 'trend' => null, 'trendValue' => null])

<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition-all hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $title }}</p>
            <h3 class="mt-2 text-3xl font-bold font-outfit text-slate-900 dark:text-white">{{ $value }}</h3>
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
            {!! $icon !!}
        </div>
    </div>
    
    @if($trend)
        <div class="mt-4 flex items-center text-sm">
            @if($trend === 'up')
                <svg class="mr-1 h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" /></svg>
                <span class="text-emerald-600 font-medium">+{{ $trendValue }}</span>
            @elseif($trend === 'down')
                <svg class="mr-1 h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" /></svg>
                <span class="text-red-600 font-medium">-{{ $trendValue }}</span>
            @endif
            <span class="ml-2 text-slate-500 dark:text-slate-400">vs bulan lalu</span>
        </div>
    @endif
</div>
