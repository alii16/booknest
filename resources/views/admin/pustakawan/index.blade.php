@extends('layouts.app')

@section('title', 'Kelola Pustakawan')

@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header -->
    <div class="bg-white rounded-xl mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Pustakawan</h1>
                <p class="text-gray-600 mt-1 sm:mt-2">Manajemen data pustakawan perpustakaan</p>
            </div>
            <a href="{{ route('admin.pustakawan.create') }}" 
            class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pustakawan
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pustakawan</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_pustakawan']) }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Hari Ini -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Terdaftar Hari Ini</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['pustakawan_hari_ini']) }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-user-plus text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Minggu Ini -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Minggu Ini</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['pustakawan_minggu_ini']) }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-calendar-week text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Bulan Ini -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Bulan Ini</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['pustakawan_hari_ini']) }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Pustakawan Aktif -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Status Aktivitas</h3>
                <i class="fas fa-chart-line text-gray-400"></i>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pustakawan Aktif (7 hari)</span>
                    <span class="font-semibold text-green-600">{{ number_format($stats['pustakawan_aktif']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Registrasi/Hari</span>
                    <span class="font-semibold text-blue-600">{{ number_format($stats['rata_rata_registrasi'], 1) }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['total_pustakawan'] > 0 ? ($stats['pustakawan_aktif'] / $stats['total_pustakawan']) * 100 : 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-500">
                    {{ $stats['total_pustakawan'] > 0 ? number_format(($stats['pustakawan_aktif'] / $stats['total_pustakawan']) * 100, 1) : 0 }}% pustakawan aktif
                </p>
            </div>
        </div>

        <!-- Grafik Registrasi Bulanan -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Registrasi 6 Bulan Terakhir</h3>
                <i class="fas fa-chart-bar text-gray-400"></i>
            </div>
            <div class="space-y-2">
                @foreach($registrasi_bulanan as $data)
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 w-16">{{ $data['bulan'] }}</span>
                    <div class="flex-1 mx-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $max_registrasi = collect($registrasi_bulanan)->max('jumlah');
                                $percentage = $max_registrasi > 0 ? ($data['jumlah'] / $max_registrasi) * 100 : 0;
                            @endphp
                            <div class="bg-purple-500 h-2 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-gray-900 w-8 text-right">{{ $data['jumlah'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Pustakawan List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Daftar Pustakawan</h2>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle"></i>
                    <span>Total: {{ number_format($pustakawan->total()) }} pustakawan</span>
                </div>
            </div>
        </div>
        
        @if($pustakawan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pustakawan
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Terdaftar
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aktivitas Terakhir
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
                    @foreach($pustakawan as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-purple-600"></i>
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->updated_at)
                                <div class="text-sm text-gray-900">{{ $user->updated_at->format('d M Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $user->updated_at->diffForHumans() }}</div>
                            @else
                                <div class="text-sm text-gray-500">Belum ada aktivitas</div>
                                <div class="text-sm text-gray-400">-</div>
                            @endif
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
                                    Belum Pernah Login
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.pustakawan.edit', $user) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.pustakawan.destroy', $user) }}" 
                                  class="inline-block"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pustakawan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
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
        @if($pustakawan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pustakawan->links() }}
        </div>
        @endif
        
        @else
        <div class="p-12 text-center">
            <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                <i class="fas fa-user-tie text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pustakawan</h3>
            <p class="text-gray-500 mb-4">Mulai dengan menambahkan pustakawan pertama.</p>
            <a href="{{ route('admin.pustakawan.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pustakawan
            </a>
        </div>
        @endif
    </div>
</div>
@endsection