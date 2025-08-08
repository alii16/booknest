@extends('layouts.app')

@section('title', 'Statistik Buku')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Statistik Buku</h1>
                <p class="text-gray-600 mt-2">Analisis lengkap koleksi perpustakaan</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Book Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Buku</p>
                    <p class="text-3xl font-bold">{{ $total_books }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-book text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Tersedia</p>
                    <p class="text-3xl font-bold">{{ $available_books }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Dipinjam</p>
                    <p class="text-3xl font-bold">{{ $borrowed_books }}</p>
                </div>
                <div class="bg-orange-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-book-reader text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Kategori</p>
                    <p class="text-3xl font-bold">{{ $total_categories }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-tags text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Books by Category -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">
            <i class="fas fa-chart-pie text-indigo-600 mr-2"></i>
            Buku per Kategori
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($books_by_category as $category)
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $category->kategori }}</h4>
                        <p class="text-sm text-gray-600">{{ $category->count }} buku</p>
                    </div>
                    <div class="text-2xl font-bold text-indigo-600">
                        {{ $category->count }}
                    </div>
                </div>
                <div class="mt-3 bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($category->count / $total_books) * 100 }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    {{ number_format(($category->count / $total_books) * 100, 1) }}% dari total koleksi
                </p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Most Popular Books -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6">
            <i class="fas fa-trophy text-yellow-600 mr-2"></i>
            Buku Terpopuler
        </h3>
        <div class="space-y-4">
            @foreach($popular_books as $index => $book)
            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-white font-bold">
                    {{ $index + 1 }}
                </div>
                <div class="ml-4 flex-1">
                    <h4 class="font-medium text-gray-900">{{ $book->judul }}</h4>
                    <p class="text-sm text-gray-600">{{ $book->penulis }} • {{ $book->kategori }}</p>
                    <p class="text-xs text-gray-500">Tahun: {{ $book->tahun }}</p>
                </div>
                <div class="text-right">
                    <div class="text-lg font-bold text-yellow-600">{{ $book->loans_count }}</div>
                    <div class="text-xs text-gray-500">peminjaman</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Book Status Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Stock Status -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-warehouse text-blue-600 mr-2"></i>
                Status Stok
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Stok Tersedia</span>
                    <span class="text-lg font-bold text-green-600">{{ $available_books }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Sedang Dipinjam</span>
                    <span class="text-lg font-bold text-orange-600">{{ $borrowed_books }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                    <span class="text-gray-700 font-medium">Stok Habis</span>
                    <span class="text-lg font-bold text-red-600">{{ $out_of_stock }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Additions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">
                <i class="fas fa-plus-circle text-emerald-600 mr-2"></i>
                Buku Terbaru
            </h3>
            <div class="space-y-3">
                @foreach($recent_books as $book)
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $book->judul }}</p>
                        <p class="text-sm text-gray-600">{{ $book->penulis }}</p>
                        <p class="text-xs text-gray-500">{{ $book->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                            {{ $book->dipinjam ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                            {{ $book->dipinjam ? 'Dipinjam' : 'Tersedia' }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection