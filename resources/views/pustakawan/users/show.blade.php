@extends('layouts.app')

@section('title', 'Detail Pengguna: ' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Detail Pengguna</h1>
                <p class="text-gray-600 mt-2">Informasi lengkap tentang pengguna {{ $user->name }}</p>
            </div>
            <a href="{{ route('pustakawan.users.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Profil Pengguna</h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Alamat Email</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Role</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->role }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Terdaftar Sejak</p>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 border-t border-gray-200">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-600">Total Pinjaman</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalLoans) }}</p>
            </div>
            <div class="bg-red-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-600">Pinjaman Aktif</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($activeLoans) }}</p>
            </div>
        </div>
    </div>

<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Riwayat Peminjaman</h2>
        </div>
        @if($loans->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($loans as $loan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $loan->book->judul }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $loan->tanggal_pinjam->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($loan->tanggal_kembali)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Sudah Kembali
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Belum Kembali
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($loans->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $loans->links() }}
        </div>
        @endif
        @else
        <div class="p-6 text-center text-gray-500">
            Pengguna ini belum pernah meminjam buku.
        </div>
        @endif
    </div>
</div>
</div>
@endsection