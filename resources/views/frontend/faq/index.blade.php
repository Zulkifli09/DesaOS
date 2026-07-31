<x-public-layout>
    <x-slot name="title">FAQ - Tanya Jawab</x-slot>

    <!-- Header Section -->
    <section class="pt-32 pb-16 bg-white overflow-hidden relative border-b border-slate-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center max-w-3xl">
            <span class="text-blue-600 font-bold uppercase tracking-wider text-sm mb-2 block">Pusat Bantuan</span>
            <h1 class="text-4xl md:text-5xl font-bold font-outfit text-slate-900 mb-6 leading-tight">FAQ / Tanya Jawab</h1>
            <p class="text-slate-600 text-lg mb-8">Temukan jawaban atas pertanyaan yang paling sering diajukan terkait administrasi, pelayanan, dan informasi umum desa kami.</p>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="py-16 bg-slate-50 min-h-[50vh]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            
            @if($faqs->count() > 0)
                <div class="space-y-4" x-data="{ active: null }">
                    @foreach($faqs as $index => $faq)
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm transition-all duration-300" 
                             :class="active === {{ $index }} ? 'ring-2 ring-blue-500 shadow-md' : 'hover:border-blue-300'">
                            
                            <button @click="active = active === {{ $index }} ? null : {{ $index }}" class="flex justify-between items-center w-full p-6 text-left focus:outline-none">
                                <h3 class="text-lg font-bold font-outfit text-slate-900 pr-8" :class="active === {{ $index }} ? 'text-blue-600' : ''">
                                    {{ $faq->question }}
                                </h3>
                                <div class="shrink-0 text-slate-400 transition-transform duration-300" :class="active === {{ $index }} ? 'rotate-180 text-blue-600' : ''">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </button>
                            
                            <div x-show="active === {{ $index }}" x-collapse x-cloak>
                                <div class="px-6 pb-6 pt-2 border-t border-slate-100 text-slate-600 prose prose-slate max-w-none">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-slate-500 text-lg">Belum ada FAQ yang ditambahkan.</p>
                </div>
            @endif

            <div class="mt-16 text-center bg-blue-600 rounded-2xl p-8 text-white shadow-xl shadow-blue-600/20">
                <h3 class="text-2xl font-bold font-outfit mb-4">Masih memiliki pertanyaan?</h3>
                <p class="text-blue-100 mb-6">Jangan ragu untuk menghubungi kami jika Anda tidak menemukan jawaban yang Anda cari.</p>
                <a href="{{ route('kontak.index') }}" class="inline-block bg-white text-blue-600 font-bold py-3 px-8 rounded-xl shadow-md hover:shadow-lg hover:bg-blue-50 transition-all transform hover:-translate-y-1">Hubungi Kami Sekarang</a>
            </div>

        </div>
    </section>

</x-public-layout>
