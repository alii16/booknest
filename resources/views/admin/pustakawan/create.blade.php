@extends('layouts.app')

@section('title', 'Tambah Pustakawan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Pustakawan</h1>
                <p class="text-gray-600 mt-2">Buat akun pustakawan baru</p>
            </div>
            <a href="{{ route('admin.pustakawan.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('admin.pustakawan.store') }}" class="space-y-6">
            @csrf
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2 text-gray-400"></i>
                    Nama Lengkap
                </label>
                <input id="name" 
                       name="name" 
                       type="text" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="Masukkan nama lengkap pustakawan">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                    Email
                </label>
                <input id="email" 
                       name="email" 
                       type="email" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="username"
                       placeholder="pustakawan@perpustakaan.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                    Password
                </label>
                <input id="password" 
                       name="password" 
                       type="password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror" 
                       required 
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                    Konfirmasi Password
                </label>
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       type="password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all @error('password_confirmation') border-red-500 @enderror" 
                       required 
                       autocomplete="new-password"
                       placeholder="Ulangi password">
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Role Info -->
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-2 rounded-lg">
                        <i class="fas fa-info-circle text-purple-600"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-purple-900">Informasi Role</h4>
                        <p class="text-sm text-purple-700 mt-1">
                            Akun ini akan dibuat dengan role <strong>Pustakawan</strong> yang memiliki akses untuk mengelola buku dan melihat data peminjaman.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.pustakawan.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pustakawan
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <h3 class="text-lg font-medium text-blue-900 mb-3">
            <i class="fas fa-lightbulb mr-2"></i>
            Tips Keamanan
        </h3>
        <ul class="space-y-2 text-sm text-blue-800">
            <li class="flex items-start">
                <i class="fas fa-check text-blue-600 mr-2 mt-0.5"></i>
                Gunakan password yang kuat minimal 8 karakter
            </li>
            <li class="flex items-start">
                <i class="fas fa-check text-blue-600 mr-2 mt-0.5"></i>
                Kombinasikan huruf besar, kecil, angka dan simbol
            </li>
            <li class="flex items-start">
                <i class="fas fa-check text-blue-600 mr-2 mt-0.5"></i>
                Pastikan email yang digunakan aktif dan dapat diakses
            </li>
            <li class="flex items-start">
                <i class="fas fa-check text-blue-600 mr-2 mt-0.5"></i>
                Berikan informasi login kepada pustakawan dengan aman
            </li>
        </ul>
    </div>
</div>
@endsection