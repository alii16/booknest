@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header -->
    <div class="bg-white rounded-xl mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
                <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name }}!</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ now()->format('d M Y, H:i') }}</p>
                <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium mt-1">
                    <i class="fas fa-crown mr-1"></i> Administrator
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold">{{ $statistics['total_users'] }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Books -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Buku</p>
                    <p class="text-3xl font-bold">{{ $statistics['total_books'] }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-book text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Loans -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold">{{ $statistics['active_loans'] }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-bookmark text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Pustakawan -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Pustakawan</p>
                    <p class="text-3xl font-bold">{{ $statistics['total_pustakawan'] }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-user-tie text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Loan Statistics -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                Statistik Peminjaman
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Total Peminjaman</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $statistics['total_loans'] }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Sedang Dipinjam</span>
                    <span class="text-2xl font-bold text-yellow-600">{{ $statistics['active_loans'] }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Sudah Dikembalikan</span>
                    <span class="text-2xl font-bold text-green-600">{{ $statistics['returned_loans'] }}</span>
                </div>
            </div>
        </div>

        <!-- User Statistics -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-users text-purple-600 mr-2"></i>
                Statistik Pengguna
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 bg-purple-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Total Pustakawan</span>
                    <span class="text-2xl font-bold text-purple-600">{{ $statistics['total_pustakawan'] }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Total Peminjam</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $statistics['total_peminjam'] }}</span>
                </div>
                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Total Semua User</span>
                    <span class="text-2xl font-bold text-gray-600">{{ $statistics['total_users'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Popular Books -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Loans -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-history text-emerald-600 mr-2"></i>
                Peminjaman Terbaru
            </h3>
            <div class="space-y-3">
                @forelse($recent_loans as $loan)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $loan->book->judul }}</p>
                        <p class="text-sm text-gray-600">oleh {{ $loan->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $loan->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        @if($loan->tanggal_kembali)
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                Dikembalikan
                            </span>
                        @else
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">
                                Dipinjam
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>Belum ada peminjaman</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Popular Books -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-star text-yellow-600 mr-2"></i>
                Buku Terpopuler
            </h3>
            <div class="space-y-3">
                @forelse($popular_books as $book)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $book->judul }}</p>
                        <p class="text-sm text-gray-600">{{ $book->penulis }}</p>
                        <p class="text-xs text-gray-500">{{ $book->kategori }} • {{ $book->tahun }}</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $book->loans_count }} peminjaman
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-book text-4xl mb-2"></i>
                    <p>Belum ada data peminjaman buku</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            <i class="fas fa-bolt text-indigo-600 mr-2"></i>
            Aksi Cepat
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.pustakawan.index') }}" 
               class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                <div class="bg-purple-500 text-white p-3 rounded-lg group-hover:bg-purple-600 transition-colors">
                    <i class="fas fa-user-tie text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-900">Kelola Pustakawan</p>
                    <p class="text-sm text-gray-600">Tambah, edit, hapus pustakawan</p>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                <div class="bg-blue-500 text-white p-3 rounded-lg group-hover:bg-blue-600 transition-colors">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-900">Kelola User</p>
                    <p class="text-sm text-gray-600">Manajemen semua pengguna</p>
                </div>
            </a>

            <a href="{{ route('admin.books.stats') }}" 
               class="flex items-center p-4 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors group">
                <div class="bg-indigo-500 text-white p-3 rounded-lg group-hover:bg-indigo-600 transition-colors">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-900">Statistik Buku</p>
                    <p class="text-sm text-gray-600">Analisis koleksi perpustakaan</p>
                </div>
            </a>

            <a href="{{ route('loans.index') }}" 
               class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                <div class="bg-green-500 text-white p-3 rounded-lg group-hover:bg-green-600 transition-colors">
                    <i class="fas fa-bookmark text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-900">Lihat Peminjaman</p>
                    <p class="text-sm text-gray-600">Monitor semua peminjaman</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection