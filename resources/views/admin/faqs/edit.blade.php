<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan <span class="text-red-500">*</span></label>
                            <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            @error('question') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban <span class="text-red-500">*</span></label>
                            <textarea id="answer" name="answer" rows="5" required class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Nomor Urut Tampil <span class="text-red-500">*</span></label>
                                <input type="number" name="order" id="order" value="{{ old('order', $faq->order) }}" required min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="text-xs text-gray-500 mt-1">FAQ akan diurutkan dari nomor terkecil ke terbesar.</p>
                                @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="flex items-center pt-6">
                                <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">Aktifkan (Tampilkan di web)</label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t">
                            <a href="{{ route('admin.faqs.index') }}" class="bg-gray-200 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Batal
                            </a>
                            <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
