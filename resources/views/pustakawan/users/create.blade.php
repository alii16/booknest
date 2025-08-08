@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Pengguna Baru</h1>
                <p class="text-gray-600 mt-2">Daftarkan pengguna baru ke perpustakaan</p>
            </div>
            <a href="{{ route('pustakawan.users.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Informasi Pengguna</h2>
            <p class="text-gray-600 mt-1">Lengkapi data pengguna dengan benar</p>
        </div>
        
        <form method="POST" action="{{ route('pustakawan.users.store') }}" class="p-6 space-y-6">
            @csrf
            
            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2 text-blue-500"></i>
                    Nama Lengkap
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('name') border-red-500 ring-red-500 @enderror"
                       placeholder="Masukkan nama lengkap"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-blue-500"></i>
                    Alamat Email
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('email') border-red-500 ring-red-500 @enderror"
                       placeholder="user@example.com"
                       required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-blue-500"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors @error('password') border-red-500 ring-red-500 @enderror"
                               placeholder="Minimal 8 karakter"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password')" 
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="password-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-check-circle mr-2 text-blue-500"></i>
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                               placeholder="Ulangi password"
                               required>
                        <button type="button" 
                                onclick="togglePassword('password_confirmation')" 
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye" id="password_confirmation-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Role Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-blue-900">Informasi Role</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            Pengguna yang didaftarkan akan memiliki role <strong>"User/Peminjam"</strong> dan dapat melakukan peminjaman buku.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('pustakawan.users.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium inline-flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Pengguna
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>
@endsection