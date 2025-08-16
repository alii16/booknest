@extends('layouts.app')
@section('title', 'Daftar Buku')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50">
    <!-- Hero Header Section -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -translate-y-48 translate-x-48"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full translate-y-32 -translate-x-32"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Jelajahi <span class="text-yellow-300">Koleksi Buku</span> Kami
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Temukan ribuan buku berkualitas dari berbagai kategori untuk memperkaya pengetahuan Anda
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 -mt-8 relative z-20">
        <!-- Enhanced Search and Filter -->
        <form method="GET" action="{{ route('buku.index') }}" class="bg-white backdrop-blur-lg rounded-2xl shadow-md border border-white/20 p-8 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <!-- Search Input -->
                <div class="md:col-span-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Buku</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Masukkan judul buku, penulis, atau kata kunci..." 
                            class="w-full pl-12 pr-4 py-4 bg-gray-50/80 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200 placeholder-gray-400"
                        >
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="md:col-span-3">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select 
                        name="kategori"
                        class="w-full px-4 py-4 bg-gray-50/80 border-0 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-200"
                    >
                        <option value="">🏷️ Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-3 flex gap-3">
                    <button 
                        type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold py-4 px-6 rounded-xl hover:from-blue-600 hover:to-indigo-700 focus:ring-4 focus:ring-blue-300 transform hover:scale-[1.02] transition-all duration-200 shadow-lg"
                    >
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                    <a 
                        href="{{ route('books.index') }}" 
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-4 px-6 rounded-xl focus:ring-4 focus:ring-gray-300 transition-all duration-200 flex items-center justify-center"
                    >
                        <i class="fas fa-refresh"></i>
                    </a>
                </div>
            </div>
        </form>

        <!-- Stats Section -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                <div class="text-2xl font-bold text-blue-600">{{ $books->total() ?? 0 }}</div>
                <div class="text-sm text-gray-600">Total Buku</div>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                <div class="text-2xl font-bold text-green-600">{{ $books->where('dipinjam', false)->count() }}</div>
                <div class="text-sm text-gray-600">Tersedia</div>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                <div class="text-2xl font-bold text-yellow-600">{{ $books->where('dipinjam', true)->count() }}</div>
                <div class="text-sm text-gray-600">Dipinjam</div>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                <div class="text-2xl font-bold text-purple-600">{{ $kategoris->count() ?? 0 }}</div>
                <div class="text-sm text-gray-600">Kategori</div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-6 2xl:grid-cols-5 gap-6 mb-12">
            @foreach ($books as $book)
                <div class="group relative bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    <!-- Book Cover -->
                    <div class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                        @if($book->sampul)
                            <img src="{{ $book->sampul }}" alt="{{ $book->judul }}" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-200 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-book text-4xl text-blue-400 mb-2"></i>
                                    <div class="text-sm text-blue-600 font-medium px-4">{{ $book->judul }}</div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3 z-10">
                            @if (!$book->dipinjam)
                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 ring-2 ring-emerald-200">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-800 ring-2 ring-red-200">
                                    <i class="fas fa-clock mr-1"></i>
                                    Dipinjam
                                </span>
                            @endif
                        </div>

                        <!-- Overlay Actions -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                            <div class="flex gap-2">
                                <button class="p-3 bg-white/20 backdrop-blur-md rounded-full text-white hover:bg-white/30 transition-all duration-200 hover:scale-110">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="p-3 bg-white/20 backdrop-blur-md rounded-full text-white hover:bg-white/30 transition-all duration-200 hover:scale-110">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Book Info -->
                    <div class="p-5">
                        <div class="mb-3">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                {{ $book->judul }}
                            </h3>
                            
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-user w-4 mr-2 text-blue-500"></i>
                                    <span class="font-medium">{{ $book->penulis }}</span>
                                </div>
                                
                                <div class="flex items-center">
                                    <i class="fas fa-tag w-4 mr-2 text-purple-500"></i>
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-50 text-purple-700 border border-purple-200">
                                        {{ $book->kategori }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        @auth
                            @if (!$book->dipinjam)
                                <button onclick="openBorrowModal({{ $book->id }}, '{{ $book->judul }}')"
                                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-3 rounded-xl hover:from-blue-600 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg group-hover:shadow-xl">
                                    <i class="fas fa-plus mr-2"></i>
                                    Pinjam Sekarang
                                </button>
                            @else
                                <div class="w-full bg-gradient-to-r from-red-100 to-red-200 text-red-700 font-bold py-3 rounded-xl text-center border-2 border-red-200">
                                    <i class="fas fa-ban mr-2"></i>
                                    Tidak Tersedia
                                </div>
                            @endif
                        @else
                            <button onclick="showLoginPrompt()" 
                                    class="w-full bg-gradient-to-r from-gray-400 to-gray-500 text-white font-bold py-3 rounded-xl hover:from-gray-500 hover:to-gray-600 transform hover:scale-[1.02] transition-all duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login untuk Pinjam
                            </button>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($books->isEmpty())
            <div class="text-center py-20">
                <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-indigo-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-5xl text-blue-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Tidak Ada Buku Ditemukan</h3>
                <p class="text-gray-600 text-lg mb-6">Coba ubah kata kunci pencarian atau filter kategori</p>
                <a href="{{ route('books.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200">
                    <i class="fas fa-refresh mr-2"></i>
                    Reset Filter
                </a>
            </div>
        @endif

        <!-- Pagination -->
        @if($books->hasPages())
            <div class="flex justify-center mt-12">
                <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-2">
                    {{ $books->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Enhanced Borrow Modal -->
<div id="borrowModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="text-xl font-bold">Pinjam Buku</h4>
                    <p class="text-blue-100 text-sm mt-1">Lengkapi data untuk meminjam buku</p>
                </div>
                <button onclick="closeBorrowModal()" class="text-white/80 hover:text-white transition-colors p-1">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                <p class="text-sm text-blue-800 font-medium mb-1">Buku yang akan dipinjam:</p>
                <p id="modalBookTitle" class="text-lg font-bold text-blue-900"></p>
            </div>

            <form id="borrowForm" method="POST" action="" class="space-y-5">
                @csrf
                <div>
                    <label for="no_hp" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-green-500"></i>
                        Nomor HP
                    </label>
                    <input type="text" name="no_hp" id="no_hp" placeholder="Contoh: 08123456789" required
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
                
                <div>
                    <label for="alamat" class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Alamat Lengkap
                    </label>
                    <textarea name="alamat" id="alamat" placeholder="Masukkan alamat lengkap untuk pengiriman buku" required rows="4"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"></textarea>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeBorrowModal()"
                            class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 px-4 rounded-xl hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-3 px-4 rounded-xl hover:from-blue-600 hover:to-indigo-700 transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                        <i class="fas fa-check mr-2"></i>
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Enhanced Login Modal -->
<div id="loginModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-400 to-red-500 text-white p-8 text-center">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lock text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2">Login Diperlukan</h3>
            <p class="text-orange-100">Masuk untuk mengakses fitur peminjaman buku</p>
        </div>
        
        <div class="p-8">
            <div class="flex gap-3">
                <button onclick="hideLoginPrompt()" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-xl transition-all duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </button>
                <a href="{{ route('login') }}" 
                   class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-200 text-center transform hover:scale-[1.02] shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </a>
            </div>
        </div>
    </div>
</div>

<script>
const borrowModal = document.getElementById('borrowModal');
const modalBookTitle = document.getElementById('modalBookTitle');
const borrowForm = document.getElementById('borrowForm');

function openBorrowModal(bookId, bookTitle) {
    modalBookTitle.textContent = bookTitle;
    borrowForm.action = `/pinjam/${bookId}`;
    borrowModal.classList.remove('hidden');
    
    setTimeout(() => {
        borrowModal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        borrowModal.querySelector('div').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeBorrowModal() {
    borrowModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
    borrowModal.querySelector('div').classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        borrowModal.classList.add('hidden');
    }, 300);
}

function showLoginPrompt() {
    document.getElementById('loginModal').classList.remove('hidden');
}

function hideLoginPrompt() {
    document.getElementById('loginModal').classList.add('hidden');
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target == borrowModal) {
        closeBorrowModal();
    }
    if (event.target == document.getElementById('loginModal')) {
        hideLoginPrompt();
    }
}

// Enhanced search with loading state
document.querySelector('input[name="search"]').addEventListener('input', function(e) {
    // Add debounced search functionality here
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        console.log('Searching for:', e.target.value);
    }, 500);
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
}

/* Smooth animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.book-card {
    animation: fadeInUp 0.6s ease-out forwards;
}

.book-card:nth-child(even) {
    animation-delay: 0.1s;
}

.book-card:nth-child(3n) {
    animation-delay: 0.2s;
}

/* Responsive improvements */
@media (max-width: 640px) {
    .grid {
        gap: 1rem;
    }
}

/* Focus improvements */
input:focus, textarea:focus, select:focus, button:focus {
    outline: none;
}

/* Button hover effects */
.btn-gradient {
    background-size: 200% 200%;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background-position: right center;
}
</style>

@endsection