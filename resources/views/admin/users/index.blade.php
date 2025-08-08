@extends('layouts.app')

@section('title', 'Kelola Users')

@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header -->
    <div class="bg-white rounded-xl mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Users</h1>
                <p class="text-gray-600 mt-1 sm:mt-2">Manajemen semua pengguna sistem perpustakaan</p>
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full sm:w-auto">
                <!-- Filter Role -->
                <select id="roleFilter" 
                        class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Role</option>
                    <option value="pustakawan">Pustakawan</option>
                    <option value="peminjam">Peminjam</option>
                </select>

                <!-- Search -->
                <div class="relative w-full sm:w-auto">
                    <input type="text" 
                        id="searchUser" 
                        placeholder="Cari user..." 
                        class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
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
                    <p class="text-blue-100 text-sm font-medium">Total Pengguna</p>
                    <p class="text-3xl font-bold">{{ $users->total() }}</p>
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
                    <p class="text-green-100 text-sm font-medium">Pustakawan</p>
                    <p class="text-3xl font-bold">{{ $users->where('role', 'pustakawan')->count() }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-user-tie text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Minggu Ini -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Peminjam</p>
                    <p class="text-3xl font-bold">{{ $users->where('role', 'peminjam')->count() }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-user-tie text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Bulan Ini -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Terdaftar Hari Ini</p>
                    <p class="text-3xl font-bold">{{ $users->where('created_at', '>=', today())->count() }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-50 p-3 rounded-lg">
                    <i class="fas fa-calendar-day text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Daftar Semua Pengguna</h2>
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
                            User
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Terdaftar
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors user-row" data-role="{{ $user->role }}" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center
                                    {{ $user->role === 'pustakawan' ? 'bg-purple-100' : 'bg-blue-100' }}">
                                    <i class="fas {{ $user->role === 'pustakawan' ? 'fa-user-tie text-purple-600' : 'fa-user text-blue-600' }}"></i>
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
                            @if($user->role === 'pustakawan')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                    <i class="fas fa-user-tie mr-1"></i>
                                    Pustakawan
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-user mr-1"></i>
                                    Peminjam
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                  class="inline-block"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait akan ikut terhapus.')">
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
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada users</h3>
            <p class="text-gray-500">Users akan muncul setelah mereka mendaftar.</p>
        </div>
        @endif
    </div>
</div>

<!-- JavaScript for filtering and search -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleFilter = document.getElementById('roleFilter');
    const searchInput = document.getElementById('searchUser');
    const userRows = document.querySelectorAll('.user-row');

    function filterUsers() {
        const selectedRole = roleFilter.value.toLowerCase();
        const searchTerm = searchInput.value.toLowerCase();

        userRows.forEach(row => {
            const userRole = row.dataset.role;
            const userName = row.dataset.name;
            const userEmail = row.dataset.email;
            
            const roleMatch = !selectedRole || userRole === selectedRole;
            const searchMatch = !searchTerm || 
                userName.includes(searchTerm) || 
                userEmail.includes(searchTerm);
            
            if (roleMatch && searchMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    roleFilter.addEventListener('change', filterUsers);
    searchInput.addEventListener('input', filterUsers);
});
</script>
@endsection