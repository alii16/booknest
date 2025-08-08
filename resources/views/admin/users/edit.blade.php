@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
                <p class="text-gray-600 mt-2">Perbarui data user: {{ $user->name }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PATCH')
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user mr-2 text-gray-400"></i>
                    Nama Lengkap
                </label>
                <input id="name" 
                       name="name" 
                       type="text" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror" 
                       value="{{ old('email', $user->email) }}" 
                       required 
                       autocomplete="username"
                       placeholder="user@example.com">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-user-tag mr-2 text-gray-400"></i>
                    Role
                </label>
                <select id="role" 
                        name="role" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('role') border-red-500 @enderror" 
                        required>
                    <option value="">Pilih Role</option>
                    <option value="peminjam" {{ old('role', $user->role) === 'peminjam' ? 'selected' : '' }}>
                        Peminjam
                    </option>
                    <option value="pustakawan" {{ old('role', $user->role) === 'pustakawan' ? 'selected' : '' }}>
                        Pustakawan
                    </option>
                </select>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Mengubah role akan mengubah hak akses user pada sistem
                </p>
            </div>

            <!-- Role Description -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-900">Penjelasan Role</h4>
                        <div class="text-sm text-blue-700 mt-2 space-y-2">
                            <div class="flex items-start">
                                <i class="fas fa-user text-blue-600 mr-2 mt-0.5"></i>
                                <div>
                                    <strong>Peminjam:</strong> Dapat melihat dan meminjam buku, melihat riwayat peminjaman sendiri
                                </div>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-user-tie text-purple-600 mr-2 mt-0.5"></i>
                                <div>
                                    <strong>Pustakawan:</strong> Dapat mengelola buku, melihat semua data peminjaman
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Info -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="bg-gray-100 p-2 rounded-lg">
                        <i class="fas fa-info-circle text-gray-600"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-gray-900">Informasi Akun</h4>
                        <div class="text-sm text-gray-700 mt-1 space-y-1">
                            <p><strong>Role Saat Ini:</strong> 
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                    {{ $user->role === 'pustakawan' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </p>
                            <p><strong>Terdaftar:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Terakhir diperbarui:</strong> {{ $user->updated_at->format('d M Y H:i') }}</p>
                            @if($user->loans_count > 0)
                                <p><strong>Total Peminjaman:</strong> {{ $user->loans_count }} buku</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Section -->
    <div class="bg-red-50 border border-red-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="bg-red-100 p-2 rounded-lg">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-lg font-medium text-red-900">Zona Bahaya</h3>
                <p class="text-sm text-red-700 mt-1 mb-4">
                    Menghapus user akan menghapus semua data terkait termasuk riwayat peminjaman. Tindakan ini tidak dapat dibatalkan.
                </p>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait akan ikut terhapus dan tidak dapat dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection