@extends('layouts.app')
@section('title', 'Admin - Buku')
@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Kelola Buku</h1>
            <p class="text-gray-600">Manage dan kelola koleksi buku perpustakaan</p>
        </div>
        <a href="{{ route('pustakawan.books.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
            <i class="fas fa-plus mr-2"></i>
            Tambah Buku
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-400 to-blue-500 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Buku</p>
                    <p class="text-3xl font-bold">{{ $books->count() }}</p>
                </div>
                <i class="fas fa-book text-3xl text-blue-200"></i>
            </div>
        </div>
        <div class="bg-gradient-to-r from-green-400 to-green-500 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Tersedia</p>
                    <p class="text-3xl font-bold">
                        {{ $books->where('dipinjam', false)->count() }}
                    </p>
                </div>
                <i class="fas fa-check-circle text-3xl text-emerald-200"></i>
            </div>
        </div>
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Dipinjam</p>
                <p class="text-3xl font-bold">
                {{ $books->where('dipinjam', true)->count() }}
                </p>
            </div>
            <i class="fas fa-hand-holding text-3xl text-orange-200"></i>
            </div>
        </div>
    </div>
    
    <!-- Search and Filter -->
    <div class="bg-gray-50 p-6 rounded-xl mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Cari buku..." class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <select class="px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>Semua Kategori</option>
                <option>Fiksi</option>
                <option>Non-Fiksi</option>
                <option>Sains</option>
            </select>
        </div>
    </div>
    
    <!-- Books Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Buku
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Penulis
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Tahun
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Stok
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($books as $book)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-book text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $book->judul }}</div>
                                    <div class="text-sm text-gray-500">ID: #{{ $book->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $book->penulis }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $book->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $book->tahun }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $book->stok }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($book->stok>0)
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('pustakawan.books.edit', $book->id) }}" class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <form action="{{ route('pustakawan.books.destroy', $book->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-semibold">1</span> sampai <span class="font-semibold">{{ $books->count() }}</span> dari <span class="font-semibold">{{ $books->count() }}</span> hasil
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Previous
                    </button>
                    <button class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg">
                        1
                    </button>
                    <button class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection