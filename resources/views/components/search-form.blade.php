<form action="{{ route('book.search') }}" method="GET" class="mb-6">
    <div class="flex items-center">
        <input 
            type="text" 
            name="query" 
            value="{{ old('query', $query) }}" 
            class="px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-100" 
            placeholder="Cari berdasarkan judul atau penulis..."
        >
        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Cari
        </button>
    </div>
</form>