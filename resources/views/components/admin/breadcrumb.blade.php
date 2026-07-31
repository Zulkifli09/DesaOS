@props(['title', 'links' => []])

<div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
    <h1 class="text-2xl font-bold font-outfit text-slate-900 dark:text-white">{{ $title }}</h1>
    
    <nav aria-label="Breadcrumb">
        <ol class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                    <span class="sr-only">Dashboard</span>
                </a>
            </li>
            @foreach($links as $label => $url)
                <li>
                    <svg class="h-4 w-4 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                </li>
                <li>
                    @if($url)
                        <a href="{{ $url }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">{{ $label }}</a>
                    @else
                        <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $label }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
