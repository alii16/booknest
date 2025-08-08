@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Kelola Pengguna</h1>
            <p class="text-gray-600">Manajemen data pengguna perpustakaan</p>
        </div>
        <a href="{{ route('pustakawan.users.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300">
            <i class="fas fa-user-plus mr-2"></i>
            Tambah Pengguna
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_users']) }}</p>
                </div>
                <i class="fas fa-users text-3xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Hari Ini</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['users_hari_ini']) }}</p>
                </div>
                <i class="fas fa-user-plus text-3xl text-yellow-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-indigo-400 to-indigo-500 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">Minggu Ini</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['users_minggu_ini']) }}</p>
                </div>
                <i class="fas fa-calendar-week text-3xl text-indigo-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Bulan Ini</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['users_bulan_ini']) }}</p>
                </div>
                <i class="fas fa-calendar-alt text-3xl text-red-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Aktif (30 Hari)</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['users_aktif']) }}</p>
                </div>
                <i class="fas fa-user-check text-3xl text-green-200"></i>
            </div>
        </div>
    </div>

    <!-- Users List -->
    <div class="bg-white rounded-xl overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Daftar Pengguna</h2>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i>
                    <span>Total: {{ number_format($users->total()) }} pengguna</span>
                </div>
            </div>
        </div>
        
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pengguna
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Terdaftar
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total Pinjaman
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ number_format($user->loans_count) }} pinjaman
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->updated_at && $user->updated_at >= \Carbon\Carbon::now()->subDays(7))
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-circle text-green-500 mr-1 text-xs"></i>
                                    Aktif
                                </span>
                            @elseif($user->updated_at && $user->updated_at >= \Carbon\Carbon::now()->subDays(30))
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-circle text-yellow-500 mr-1 text-xs"></i>
                                    Jarang Aktif
                                </span>
                            @elseif($user->updated_at)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    <i class="fas fa-circle text-gray-500 mr-1 text-xs"></i>
                                    Tidak Aktif
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-circle text-red-500 mr-1 text-xs"></i>
                                    Belum Login
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-1">
                            <a href="{{ route('pustakawan.users.show', $user) }}" 
                               class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors text-xs">
                                <i class="fas fa-eye mr-1"></i>
                                Detail
                            </a>
                            <a href="{{ route('pustakawan.users.edit', $user) }}" 
                               class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg hover:bg-yellow-200 transition-colors text-xs">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('pustakawan.users.destroy', $user) }}" 
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')"
                                        class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-xs">
                                    <i class="fas fa-trash mr-1"></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
        
        @else
        <div class="p-12 text-center">
            <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                <i class="fas fa-users text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengguna</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan pengguna pertama.</p>
            <a href="{{ route('pustakawan.users.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-user-plus mr-2"></i>
                Tambah Pengguna
            </a>
        </div>
        @endif
    </div>
</div>
@endsection