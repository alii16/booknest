@extends('layouts.app')
@section('title', 'Buku yang Saya Pinjam')
@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pinjaman Saya</h1>
        <p class="text-gray-600">Kelola dan pantau status peminjaman buku Anda</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        @php
            $totalLoans = $loans->count();
            $activeLoans = $loans->whereNull('tanggal_kembali')->count();
            $returnedLoans = $loans->whereNotNull('tanggal_kembali')->count();
            $overdueLoans = $loans->filter(function($loan) {
                if ($loan->tanggal_kembali) return false;
                $batas = \Carbon\Carbon::parse($loan->tanggal_pinjam)->addDays(4);
                return \Carbon\Carbon::now()->greaterThan($batas);
            })->count();
        @endphp
        
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Pinjaman</p>
                    <p class="text-3xl font-bold">{{ $totalLoans }}</p>
                </div>
                <i class="fas fa-book text-3xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Sedang Dipinjam</p>
                    <p class="text-3xl font-bold">{{ $activeLoans }}</p>
                </div>
                <i class="fas fa-clock text-3xl text-yellow-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-400 to-green-500 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm font-medium">Dikembalikan</p>
                    <p class="text-3xl font-bold">{{ $returnedLoans }}</p>
                </div>
                <i class="fas fa-check-circle text-3xl text-emerald-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Terlambat</p>
                    <p class="text-3xl font-bold">{{ $overdueLoans }}</p>
                </div>
                <i class="fas fa-exclamation-triangle text-3xl text-red-200"></i>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Cari judul buku..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <select class="px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>Semua Status</option>
                <option>Sedang Dipinjam</option>
                <option>Dikembalikan</option>
                <option>Terlambat</option>
            </select>
        </div>
    </div>

    <!-- Loans Table -->
    @if($loans->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Buku
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Tanggal Pinjam
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Batas Kembali
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Tanggal Kembali
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Denda
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($loans as $loan)
                            @php
                                $batas = \Carbon\Carbon::parse($loan->tanggal_pinjam)->addDays(4);
                                $sekarang = $loan->tanggal_kembali ? \Carbon\Carbon::parse($loan->tanggal_kembali) : \Carbon\Carbon::now();
                                $terlambat = $sekarang->greaterThan($batas);
                                $jamTerlambat = $terlambat ? $sekarang->diffInHours($batas) : 0;
                                $denda = $jamTerlambat * 500; // Rp 500 per jam
                                $diff = $batas->diff($sekarang);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-lg overflow-hidden shadow-md border border-gray-200">
                                                @if($loan->book->sampul)
                                                    <img src="{{ $loan->book->sampul }}" 
                                                        alt="Cover {{ $loan->book->judul }}" 
                                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-200"
                                                        onerror="this.parentElement.innerHTML='<div class=\'h-full w-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center p-2\'><svg viewBox=\'0 0 24 24\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\' class=\'w-full h-full text-white\'><path d=\'M4 19.5C4 18.1193 5.11929 17 6.5 17H20V4.5C20 3.11929 18.8807 2 17.5 2H6.5C5.11929 2 4 3.11929 4 4.5V19.5Z\' fill=\'currentColor\' opacity=\'0.9\'/><path d=\'M6.5 17C5.11929 17 4 18.1193 4 19.5C4 20.8807 5.11929 22 6.5 22H20V17H6.5Z\' fill=\'currentColor\'/><path d=\'M8 6H16M8 9H15M8 12H13\' stroke=\'currentColor\' stroke-width=\'1.2\' stroke-linecap=\'round\' fill=\'none\' opacity=\'0.7\'/><path d=\'M17 2V8L19 6L21 8V2\' fill=\'currentColor\' opacity=\'0.8\'/></svg></div>'">
                                                @else
                                                    <!-- Fallback SVG jika tidak ada sampul -->
                                                    <div class="h-full w-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center p-2">
                                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-white">
                                                            <path d="M4 19.5C4 18.1193 5.11929 17 6.5 17H20V4.5C20 3.11929 18.8807 2 17.5 2H6.5C5.11929 2 4 3.11929 4 4.5V19.5Z" 
                                                                fill="currentColor" opacity="0.9"/>
                                                            <path d="M6.5 17C5.11929 17 4 18.1193 4 19.5C4 20.8807 5.11929 22 6.5 22H20V17H6.5Z" 
                                                                fill="currentColor"/>
                                                            <path d="M8 6H16M8 9H15M8 12H13" 
                                                                stroke="currentColor" 
                                                                stroke-width="1.2" 
                                                                stroke-linecap="round" 
                                                                fill="none" 
                                                                opacity="0.7"/>
                                                            <path d="M17 2V8L19 6L21 8V2" 
                                                                fill="currentColor" 
                                                                opacity="0.8"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900">
                                                {{ $loan->book->judul ?? 'Buku tidak ditemukan' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $loan->book->penulis ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $batas->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $batas->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($loan->tanggal_kembali)
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('H:i') }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">Belum dikembalikan</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($loan->tanggal_kembali)
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Dikembalikan
                                        </span>
                                    @elseif ($terlambat)
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Terlambat 
                                            {{ $diff->d > 0 ? $diff->d . ' hari, ' : '' }}
                                            {{ $diff->h > 0 ? $diff->h . ' jam, ' : '' }}
                                            {{ $diff->i }} menit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                @if($loan->denda_manual > 0)
                                    <div class="text-sm font-semibold text-red-600">
                                        Rp {{ number_format($loan->denda_manual, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $loan->denda_manual / 500 }} jam × Rp 500
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-book-open text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada peminjaman</h3>
            <p class="text-gray-600 mb-6">Anda belum meminjam buku apapun. Mulai jelajahi koleksi kami!</p>
            <a href="{{ url('/buku') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300">
                <i class="fas fa-search mr-2"></i>
                Jelajahi Buku
            </a>
        </div>
    @endif

    <!-- Late Return Warning -->
    @if($overdueLoans > 0)
        <div class="mt-6 bg-red-50 border-l-4 border-red-400 p-6 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                <div>
                    <h3 class="text-lg font-semibold text-red-800">Peringatan Keterlambatan</h3>
                    <p class="text-red-700 mt-1">
                        Anda memiliki {{ $overdueLoans }} buku yang terlambat dikembalikan. 
                        Segera kembalikan untuk menghindari denda tambahan.
                    </p>
                    <p class="text-red-600 text-sm mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Denda: Rp 500 per jam per buku
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection