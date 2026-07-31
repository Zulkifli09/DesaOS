<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $contactMessage->subject }}</h3>
                            <span class="text-sm text-gray-500">{{ $contactMessage->created_at->format('d F Y, H:i') }}</span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Pengirim:</p>
                                <p class="text-base text-gray-900">{{ $contactMessage->name }}</p>
                            </div>
                            
                            <div class="flex gap-6">
                                @if($contactMessage->email)
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Email:</p>
                                        <a href="mailto:{{ $contactMessage->email }}" class="text-base text-indigo-600 hover:underline">{{ $contactMessage->email }}</a>
                                    </div>
                                @endif
                                
                                @if($contactMessage->phone)
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">Telepon/WA:</p>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactMessage->phone) }}" target="_blank" class="text-base text-green-600 hover:underline">{{ $contactMessage->phone }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none text-gray-700 leading-relaxed min-h-[150px]">
                        {!! nl2br(e($contactMessage->message)) !!}
                    </div>

                    <div class="mt-10 pt-6 border-t border-gray-200 flex justify-between items-center">
                        <a href="{{ route('admin.contact_messages.index') }}" class="text-indigo-600 hover:text-indigo-900 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Daftar Pesan
                        </a>
                        
                        <form action="{{ route('admin.contact_messages.destroy', $contactMessage->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pesan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-md transition-colors text-sm font-medium">Hapus Pesan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
