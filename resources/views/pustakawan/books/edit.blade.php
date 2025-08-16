@extends('layouts.app')
@section('title', 'Edit Buku')
@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('pustakawan.dashboard') }}" class="mr-4 p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Buku</h1>
                <p class="text-gray-600">Perbarui informasi buku "{{ $book->judul }}"</p>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('pustakawan.books.update', $book->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Current Book Info Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4">
                        @if($book->sampul)
                            <img src="{{ $book->sampul }}" 
                                alt="Cover {{ $book->judul }}" 
                                class="w-full h-full object-cover rounded-md hover:scale-105 transition-transform duration-200"
                                onerror="this.parentElement.innerHTML='<div class=\'h-full w-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center p-2\'><svg viewBox=\'0 0 24 24\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\' class=\'w-full h-full text-white\'><path d=\'M4 19.5C4 18.1193 5.11929 17 6.5 17H20V4.5C20 3.11929 18.8807 2 17.5 2H6.5C5.11929 2 4 3.11929 4 4.5V19.5Z\' fill=\'currentColor\' opacity=\'0.9\'/><path d=\'M6.5 17C5.11929 17 4 18.1193 4 19.5C4 20.8807 5.11929 22 6.5 22H20V17H6.5Z\' fill=\'currentColor\'/><path d=\'M8 6H16M8 9H15M8 12H13\' stroke=\'currentColor\' stroke-width=\'1.2\' stroke-linecap=\'round\' fill=\'none\' opacity=\'0.7\'/><path d=\'M17 2V8L19 6L21 8V2\' fill=\'currentColor\' opacity=\'0.8\'/></svg></div>'">
                        @else
                            <i class="fas fa-book text-blue-600 text-2xl"></i>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $book->judul }}</h3>
                        <p class="text-gray-600">{{ $book->penulis }} • {{ $book->tahun }}</p>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 mt-1">
                            {{ $book->kategori }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Cover Upload Section -->
            <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300 text-center">
                <div class="mb-4">
                    <div class="mx-auto w-20 h-20 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-image text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ganti Sampul Buku</h3>
                    <p class="text-gray-600 text-sm">PNG, JPG hingga 5MB (Kosongkan jika tidak ingin mengubah)</p>
                </div>
                <input type="file" name="sampul" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200">
            </div>

            <!-- Book Information -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-edit text-blue-600 mr-2"></i>
                    Edit Informasi Buku
                </h3>
                
                <div class="space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-book mr-2 text-blue-600"></i>
                            Judul Buku
                        </label>
                        <input type="text" id="judul" name="judul" value="{{ $book->judul }}" placeholder="Masukkan judul buku" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                               required>
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label for="penulis" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-edit mr-2 text-blue-600"></i>
                            Penulis
                        </label>
                        <input type="text" id="penulis" name="penulis" value="{{ $book->penulis }}" placeholder="Nama penulis" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                               required>
                    </div>

                    <!-- Row for Kategori and Tahun -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-tags mr-2 text-blue-600"></i>
                                Kategori
                            </label>
                            <select id="kategori" name="kategori" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                    required>
                                <option value="">Pilih kategori</option>
                                <option value="Fiksi" {{ $book->kategori == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                                <option value="Non-Fiksi" {{ $book->kategori == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                                <option value="Sains" {{ $book->kategori == 'Sains' ? 'selected' : '' }}>Sains</option>
                                <option value="Teknologi" {{ $book->kategori == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                                <option value="Sejarah" {{ $book->kategori == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                <option value="Biografi" {{ $book->kategori == 'Biografi' ? 'selected' : '' }}>Biografi</option>
                                <option value="Pendidikan" {{ $book->kategori == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="Lainnya" {{ $book->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                Tahun Terbit
                            </label>
                            <input type="number" id="tahun" name="tahun" value="{{ $book->tahun }}" placeholder="2024"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                   required>
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-box mr-2 text-blue-600"></i>
                                Stok
                            </label>
                            <input type="number" id="stok" name="stok" value="{{ $book->stok }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                   required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-4 px-8 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-check mr-2"></i>
                    Update Buku
                </button>
                <a href="{{ route('pustakawan.books.index') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 font-semibold py-4 px-8 rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>

        <!-- Danger Zone -->
        <div class="mt-8 bg-red-50 border border-red-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-2 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                Danger Zone
            </h3>
            <p class="text-red-700 text-sm mb-4">Tindakan ini tidak dapat dibatalkan. Buku akan dihapus secara permanen.</p>
            <form action="{{ route('pustakawan.books.destroy', $book->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-700 transition-all duration-200 flex items-center"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.')">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Buku
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image upload
document.querySelector('input[type="file"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add image preview functionality here
            console.log('File selected:', file.name);
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection