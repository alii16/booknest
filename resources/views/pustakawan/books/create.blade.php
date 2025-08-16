@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('pustakawan.dashboard') }}" class="mr-4 p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Buku Baru</h1>
                <p class="text-gray-600">Lengkapi informasi buku yang akan ditambahkan</p>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('pustakawan.books.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Cover Upload Section -->
            <div class="bg-gray-50 p-6 rounded-xl border-2 border-dashed border-gray-300 text-center">
                <div class="mb-4">
                    <div class="mx-auto w-20 h-20 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-image text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Upload Sampul Buku</h3>
                    <p class="text-gray-600 text-sm">PNG, JPG hingga 5MB</p>
                </div>
                <input type="file" name="sampul" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200">
            </div>

            <!-- Book Information -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Informasi Buku
                </h3>
                
                <div class="space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-book mr-2 text-blue-600"></i>
                            Judul Buku
                        </label>
                        <input type="text" id="judul" name="judul" placeholder="Masukkan judul buku" 
                               class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                               required>
                    </div>

                    <!-- Penulis -->
                    <div>
                        <label for="penulis" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-edit mr-2 text-blue-600"></i>
                            Penulis
                        </label>
                        <input type="text" id="penulis" name="penulis" placeholder="Nama penulis" 
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
                                <option value="Fiksi">Fiksi</option>
                                <option value="Non-Fiksi">Non-Fiksi</option>
                                <option value="Sains">Sains</option>
                                <option value="Teknologi">Teknologi</option>
                                <option value="Sejarah">Sejarah</option>
                                <option value="Biografi">Biografi</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- Tahun -->
                        <div>
                            <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-blue-600"></i>
                                Tahun Terbit
                            </label>
                            <input type="number" id="tahun" name="tahun" placeholder="2024"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                   required>
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-box mr-2 text-blue-600"></i>
                                Stok
                            </label>
                            <input type="number" id="stok" name="stok" placeholder="2024"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                   required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-4 px-8 rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Buku
                </button>
                <a href="{{ route('pustakawan.books.index') }}" 
                   class="flex-1 bg-gray-100 text-gray-700 font-semibold py-4 px-8 rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
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