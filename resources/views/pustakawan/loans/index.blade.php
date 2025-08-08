{{-- filepath: resources/views/admin/loans/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Daftar Peminjaman')
@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Semua Peminjaman</h1>
        <p class="text-gray-600">Kelola dan pantau status peminjaman buku seluruh user</p>
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

    <!-- Loans Table -->
    @if($loans->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                User
                            </th>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Aksi
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
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $loan->user->name ?? $loan->nama ?? '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $loan->user->email ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-book text-white"></i>
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
                                    @if($denda > 0)
                                        <div class="text-sm font-semibold text-red-600">
                                            Rp {{ number_format($denda, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $jamTerlambat }} jam × Rp 500
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('pustakawan.loans.destroy', $loan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex text-sm items-center px-3 py-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-all duration-200" onclick="return confirm('Yakin ingin menghapus buku ini?')">
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
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-book-open text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada peminjaman</h3>
            <p class="text-gray-600 mb-6">Belum ada data peminjaman buku.</p>
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
                        Ada {{ $overdueLoans }} buku yang terlambat dikembalikan. 
                        Segera hubungi peminjam untuk menghindari denda tambahan.
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