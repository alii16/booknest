@extends('layouts.app')
@section('title', 'Daftar Buku')
@section('content')
<div class="p-2 md:p-8 lg:p-10">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Buku</h1>
        <p class="text-gray-600">Temukan dan pinjam buku favorit Anda dari koleksi perpustakaan</p>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Cari judul buku, penulis, atau kategori..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
            <div class="flex-row space-y-2">
                <select class="px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Kategori</option>
                    <option>Fiksi</option>
                    <option>Non-Fiksi</option>
                    <option>Sains</option>
                    <option>Teknologi</option>
                    <option>Sejarah</option>
                </select>
                <select class="px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option>Semua Status</option>
                    <option>Tersedia</option>
                    <option>Dipinjam</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 2xl:grid-cols-5 gap-6">
    @foreach ($books as $book)
        <div class="group relative bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden 
                    hover:shadow-lg hover:scale-[1.02] transition-transform duration-300">

            <div class="relative w-full aspect-[2/3] overflow-hidden">
                @if($book->sampul)
                    <img src="{{ $book->sampul }}" alt="{{ $book->judul }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.835 5.8 9.28 5 7.5 5c-2.485 0-4.5 2.015-4.5 4.5S5.015 14 7.5 14c1.78 0 3.335-.8 4.5-1.753m0-13C13.165 5.8 14.72 5 16.5 5c2.485 0 4.5 2.015 4.5 4.5S18.985 14 16.5 14c-1.78 0-3.335-.8-4.5-1.753" />
                        </svg>
                    </div>
                @endif
                
                <div class="absolute top-3 right-3 z-10">
                    @if (!$book->dipinjam)
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full 
                                     bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">
                            Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full 
                                     bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20">
                            Dipinjam
                        </span>
                    @endif
                </div>

                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300
                            flex items-center justify-center gap-2">
                    <a href="#" class="p-2 bg-white/20 backdrop-blur-sm rounded-full text-white 
                                       hover:bg-white/30 transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="p-4 flex flex-col justify-between h-[calc(100%-16rem)]">
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 leading-tight">
                        {{ $book->judul }}
                    </h3>
                    <div class="space-y-2 text-sm text-gray-500">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ $book->penulis }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                            </svg>
                            <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700">
                                {{ $book->kategori }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    @auth
                        @if (!$book->dipinjam)
                            <button onclick="openBorrowModal({{ $book->id }}, '{{ $book->judul }}')"
                                    class="w-full bg-indigo-600 text-white font-semibold py-2.5 rounded-lg 
                                           hover:bg-indigo-700 transition-colors 
                                           flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Pinjam Buku
                            </button>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                                <p class="text-red-700 font-medium text-sm">Buku sedang dipinjam</p>
                            </div>
                        @endif
                    @else
                        <button onclick="showLoginPrompt()" 
                                class="w-full bg-gray-500 text-white font-semibold py-2.5 rounded-lg 
                                       hover:bg-gray-600 transition-colors 
                                       flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Login untuk Pinjam
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
</div>

<div id="borrowModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 shadow-lg transform transition-all duration-300 scale-95 opacity-0">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl font-bold text-gray-900">Pinjam Buku</h4>
            <button onclick="closeBorrowModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="mb-4">
            <p class="text-sm text-gray-600">Anda akan meminjam buku:</p>
            <p id="modalBookTitle" class="text-lg font-bold text-indigo-600 mt-1"></p>
        </div>

        <form id="borrowForm" method="POST" action="" class="space-y-4">
            @csrf
            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700">No. HP</label>
                <input type="text" name="no_hp" id="no_hp" placeholder="Masukkan nomor HP" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm 
                              focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" placeholder="Masukkan alamat lengkap" required rows="3"
                          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm 
                                 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
            </div>
            
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeBorrowModal()"
                        class="flex-1 bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg 
                               hover:bg-gray-300 transition-colors text-sm">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg 
                               hover:bg-indigo-700 transition-colors text-sm">
                    Konfirmasi Pinjaman
                </button>
            </div>
        </form>
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
        
        // Trigger transition
        setTimeout(() => {
            borrowModal.querySelector('div').classList.remove('scale-95', 'opacity-0');
            borrowModal.querySelector('div').classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeBorrowModal() {
        borrowModal.querySelector('div').classList.remove('scale-100', 'opacity-100');
        borrowModal.querySelector('div').classList.add('scale-95', 'opacity-0');
        
        // Hide modal after transition
        setTimeout(() => {
            borrowModal.classList.add('hidden');
        }, 300);
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == borrowModal) {
            closeBorrowModal();
        }
    }
</script>

    <!-- Enhanced Styles -->
    <style>
    /* Line clamp utility */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Compact scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f8fafc;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Enhanced focus states */
    input:focus, textarea:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Smooth form animations */
    .form-enter {
        animation: formSlideIn 0.3s ease-out;
    }

    @keyframes formSlideIn {
        from {
            opacity: 0;
            transform: translateY(-8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card hover optimizations */
    .group:hover .book-cover-image {
        transform: scale(1.05);
    }

    /* Badge improvements */
    .status-badge {
        font-size: 10px;
        letter-spacing: 0.025em;
    }

    /* Button text optimization */
    button span {
        white-space: nowrap;
    }

    /* Responsive text scaling */
    @media (max-width: 640px) {
        .grid {
            gap: 1rem;
        }
        
        .book-card h3 {
            font-size: 0.875rem;
        }
        
        .book-card .book-details {
            font-size: 0.75rem;
        }
    }

    @media (min-width: 1536px) {
        .grid {
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }
    }

    /* Micro-interactions */
    .hover-lift:hover {
        transform: translateY(-1px);
    }

    .click-scale:active {
        transform: scale(0.98);
    }

    /* Enhanced shadows */
    .enhanced-shadow {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .enhanced-shadow:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    </style>

    <!-- Empty State -->
    @if($books->isEmpty())
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada buku</h3>
            <p class="text-gray-600">Koleksi buku akan muncul di sini</p>
        </div>
    @endif

    <!-- Pagination -->
    @if($books->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $books->links() }}
        </div>
    @endif
</div>

<!-- Login Prompt Modal -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-sign-in-alt text-blue-600 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Login Diperlukan</h3>
            <p class="text-gray-600 mb-6">Anda harus login terlebih dahulu untuk meminjam buku</p>
            <div class="flex gap-3">
                <button onclick="hideLoginPrompt()" 
                        class="flex-1 bg-gray-100 text-gray-700 font-semibold py-3 px-4 rounded-lg hover:bg-gray-200 transition-all duration-200">
                    Batal
                </button>
                <a href="{{ route('login') }}" 
                   class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:shadow-lg transition-all duration-300 text-center">
                    Login Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function toggleBorrowForm(bookId) {
    const form = document.getElementById('borrowForm' + bookId);
    form.classList.toggle('hidden');
}

function showLoginPrompt() {
    document.getElementById('loginModal').classList.remove('hidden');
}

function hideLoginPrompt() {
    document.getElementById('loginModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('loginModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideLoginPrompt();
    }
});

// Search functionality
document.querySelector('input[placeholder*="Cari"]').addEventListener('input', function(e) {
    // Add search functionality here
    console.log('Searching for:', e.target.value);
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection