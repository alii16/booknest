<nav class="bg-white shadow-lg border-b border-gray-100 sticky top-0 z-50 backdrop-blur-sm bg-white/95">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3 group">
                <img src="{{ asset('img/logo.webp') }}" alt="BookNest Logo" class="w-10 h-10 rounded-md">               
                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    BookNest
                </span>
            </a>
            
            <!-- Desktop Navigation Links -->
            <div class="hidden lg:flex items-center space-x-2">
                <a href="{{ url('/buku') }}" class="group flex items-center px-4 py-2.5 text-gray-700 hover:text-blue-600 rounded-xl transition-all duration-200 font-medium relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    <i class="fas fa-book mr-2 relative z-10"></i>
                    <span class="relative z-10">Daftar Buku</span>
                </a>
                
                @auth
                    {{-- Menu Pinjaman Saya hanya untuk role user --}}
                    @if (auth()->user()->role === 'peminjam')
                        <a href="{{ route('pinjamanku') }}" class="group flex items-center px-4 py-2.5 text-gray-700 hover:text-blue-600 rounded-xl transition-all duration-200 font-medium relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            <i class="fas fa-clipboard-list mr-2 relative z-10"></i>
                            <span class="relative z-10">Pinjaman Saya</span>
                        </a>
                    @endif
                    
                    @if (auth()->user()->role === 'pustakawan')
                        <div class="relative">
                            <button id="adminDropdownBtn" type="button"
                                class="group flex items-center px-4 py-2.5 text-gray-700 hover:text-blue-600 rounded-xl transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 relative overflow-hidden"
                                onclick="toggleAdminDropdown()">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                <i class="fas fa-shield-alt mr-2 relative z-10"></i>
                                <span class="relative z-10">Pustakawan Panel</span>
                                <i class="fas fa-chevron-down ml-2 text-xs relative z-10 transition-transform duration-200" id="adminChevron"></i>
                            </button>
                            <div id="adminDropdownMenu"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible transition-all duration-300 transform scale-95 origin-top-right z-50 backdrop-blur-md bg-white/95">
                                <div class="p-2">
                                    <a href="{{ route('pustakawan.books.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 rounded-lg transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                            <i class="fas fa-book text-blue-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Kelola Buku</span>
                                    </a>
                                    <a href="{{ route('pustakawan.loans.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 rounded-lg transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-indigo-200 transition-colors duration-200">
                                            <i class="fas fa-handshake text-indigo-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Kelola Peminjaman</span>
                                    </a>
                                    <a href="{{ route('pustakawan.users.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 rounded-lg transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                            <i class="fas fa-users text-purple-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Kelola Pengguna</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->role === 'admin')
                        <div class="relative">
                            <button id="adminDropdownBtn" type="button"
                                class="group flex items-center px-4 py-2.5 text-gray-700 hover:text-blue-600 rounded-xl transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 relative overflow-hidden"
                                onclick="toggleAdminDropdown()">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                <i class="fas fa-shield-alt mr-2 relative z-10"></i>
                                <span class="relative z-10">Admin Panel</span>
                                <i class="fas fa-chevron-down ml-2 text-xs relative z-10 transition-transform duration-200" id="adminChevron"></i>
                            </button>
                            <div id="adminDropdownMenu"
                                class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible transition-all duration-300 transform scale-95 origin-top-right z-50 backdrop-blur-md bg-white/95">
                                <div class="p-2">
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 rounded-lg transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors duration-200">
                                            <i class="fas fa-rocket text-blue-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Dashboard Admin</span>
                                    </a>
                                    
                                    <div class="border-t border-gray-100 my-2"></div>
                                    
                                    <!-- Kelola Pustakawan -->
                                    <a href="{{ route('admin.pustakawan.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 rounded-lg transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors duration-200">
                                            <i class="fas fa-user-tie text-purple-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Kelola Pustakawan</span>
                                    </a>
                                    
                                    <!-- Kelola Pengguna -->
                                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 rounded-lg transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors duration-200">
                                            <i class="fas fa-users text-green-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Kelola Pengguna</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- User Menu Desktop -->
                    <div class="relative ml-4">
                        <button id="userDropdownBtn" type="button"
                            class="flex items-center space-x-3 px-4 py-2.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-30"
                            onclick="toggleUserDropdown()">
                            <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="font-medium max-w-32 truncate">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="userChevron"></i>
                        </button>
                        <div id="userDropdownMenu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 opacity-0 invisible transition-all duration-300 transform scale-95 origin-top-right z-50 backdrop-blur-md bg-white/95">
                            <div class="p-2">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 group">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors duration-200">
                                            <i class="fas fa-sign-out-alt text-red-600 text-sm"></i>
                                        </div>
                                        <span class="font-medium">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-3 ml-4">
                        <a href="{{ route('login') }}" class="px-4 py-2.5 text-gray-700 hover:text-blue-600 font-medium transition-all duration-200 rounded-xl hover:bg-blue-50">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-xl hover:scale-105 transition-all duration-300 font-medium">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="lg:hidden p-2.5 rounded-xl hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20">
                <i class="fas fa-bars text-gray-600 text-lg" id="mobileMenuIcon"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="lg:hidden bg-white border-t border-gray-100 shadow-lg transition-all duration-300 max-h-0 overflow-hidden opacity-0">
        <div class="container mx-auto px-4 py-4 space-y-2">
            <a href="{{ url('/buku') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium">
                <i class="fas fa-book mr-3 w-5"></i>
                Daftar Buku
            </a>
            
            @auth
                {{-- Menu Pinjaman Saya hanya untuk role peminjam (Mobile) --}}
                @if (auth()->user()->role === 'peminjam')
                    <a href="{{ route('pinjamanku') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium">
                        <i class="fas fa-clipboard-list mr-3 w-5"></i>
                        Pinjaman Saya
                    </a>
                @endif
                
                <!-- Menu untuk Pustakawan -->
                @if (auth()->user()->role === 'pustakawan')
                    <div class="border-t border-gray-100 pt-2 mt-2">
                        <div class="px-4 py-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Pustakawan Panel</span>
                        </div>
                        <a href="{{ route('pustakawan.books.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium ml-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-book text-blue-600 text-sm"></i>
                            </div>
                            Kelola Buku
                        </a>
                        <a href="{{ route('pustakawan.loans.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium ml-2">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-handshake text-indigo-600 text-sm"></i>
                            </div>
                            Kelola Peminjaman
                        </a>
                        <a href="{{ route('pustakawan.users.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium ml-2">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-users text-purple-600 text-sm"></i>
                            </div>
                            Kelola Pengguna
                        </a>
                    </div>
                @endif

                <!-- Menu untuk Admin -->
                @if(auth()->user()->role === 'admin')
                    <div class="border-t border-gray-100 pt-2 mt-2">
                        <div class="px-4 py-2">
                            <span class="text-xs font-semibold text-red-500 uppercase tracking-wider">Admin Panel</span>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" 
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors ml-2 rounded-xl">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-tachometer-alt text-blue-600 text-sm"></i>
                            </div>
                            Dashboard Admin
                        </a>
                        <div class="border-l-2 border-gray-200 ml-6 pl-4 space-y-1">
                            <a href="{{ route('admin.pustakawan.index') }}" 
                                class="flex items-center px-4 py-2 text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors rounded-lg text-sm">
                                <i class="fas fa-user-tie mr-3 w-4"></i>
                                Kelola Pustakawan
                            </a>
                            <a href="{{ route('admin.users.index') }}" 
                                class="flex items-center px-4 py-2 text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors rounded-lg text-sm">
                                <i class="fas fa-users mr-3 w-4"></i>
                                Kelola Users
                            </a>
                        </div>
                    </div>
                @endif
            
                <!-- User Info Mobile -->
                <div class="border-t border-gray-100 pt-4 mt-4">
                    <div class="flex items-center px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl mb-2">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 font-medium">
                            <i class="fas fa-sign-out-alt mr-3 w-5"></i>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="border-t border-gray-100 pt-4 mt-4 space-y-2">
                    <a href="{{ route('login') }}" class="block w-full px-4 py-3 text-center text-gray-700 hover:text-blue-600 font-medium transition-all duration-200 rounded-xl hover:bg-blue-50">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block w-full px-4 py-3 text-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all duration-300 font-medium">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    // Admin dropdown functionality
    function toggleAdminDropdown() {
        const menu = document.getElementById('adminDropdownMenu');
        const chevron = document.getElementById('adminChevron');
        
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('invisible');
        menu.classList.toggle('opacity-100');
        menu.classList.toggle('visible');
        menu.classList.toggle('scale-95');
        menu.classList.toggle('scale-100');
        
        chevron.classList.toggle('rotate-180');
    }

    // User dropdown functionality
    function toggleUserDropdown() {
        const menu = document.getElementById('userDropdownMenu');
        const chevron = document.getElementById('userChevron');
        
        menu.classList.toggle('opacity-0');
        menu.classList.toggle('invisible');
        menu.classList.toggle('opacity-100');
        menu.classList.toggle('visible');
        menu.classList.toggle('scale-95');
        menu.classList.toggle('scale-100');
        
        chevron.classList.toggle('rotate-180');
    }

    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuIcon = document.getElementById('mobileMenuIcon');
    let isMobileMenuOpen = false;

    mobileMenuBtn.addEventListener('click', function() {
        isMobileMenuOpen = !isMobileMenuOpen;
        
        if (isMobileMenuOpen) {
            mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
            mobileMenu.classList.remove('opacity-0');
            mobileMenu.classList.add('opacity-100');
            mobileMenuIcon.classList.remove('fa-bars');
            mobileMenuIcon.classList.add('fa-times');
        } else {
            mobileMenu.style.maxHeight = '0px';
            mobileMenu.classList.remove('opacity-100');
            mobileMenu.classList.add('opacity-0');
            mobileMenuIcon.classList.remove('fa-times');
            mobileMenuIcon.classList.add('fa-bars');
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        // Admin dropdown
        const adminBtn = document.getElementById('adminDropdownBtn');
        const adminMenu = document.getElementById('adminDropdownMenu');
        const adminChevron = document.getElementById('adminChevron');
        if (adminBtn && adminMenu && !adminBtn.contains(e.target) && !adminMenu.contains(e.target)) {
            adminMenu.classList.add('opacity-0', 'invisible', 'scale-95');
            adminMenu.classList.remove('opacity-100', 'visible', 'scale-100');
            if (adminChevron) adminChevron.classList.remove('rotate-180');
        }

        // User dropdown
        const userBtn = document.getElementById('userDropdownBtn');
        const userMenu = document.getElementById('userDropdownMenu');
        const userChevron = document.getElementById('userChevron');
        if (userBtn && userMenu && !userBtn.contains(e.target) && !userMenu.contains(e.target)) {
            userMenu.classList.add('opacity-0', 'invisible', 'scale-95');
            userMenu.classList.remove('opacity-100', 'visible', 'scale-100');
            if (userChevron) userChevron.classList.remove('rotate-180');
        }

        // Mobile menu
        if (mobileMenuBtn && mobileMenu && !mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target) && isMobileMenuOpen) {
            isMobileMenuOpen = false;
            mobileMenu.style.maxHeight = '0px';
            mobileMenu.classList.remove('opacity-100');
            mobileMenu.classList.add('opacity-0');
            mobileMenuIcon.classList.remove('fa-times');
            mobileMenuIcon.classList.add('fa-bars');
        }
    });

    // Close mobile menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024 && isMobileMenuOpen) {
            isMobileMenuOpen = false;
            mobileMenu.style.maxHeight = '0px';
            mobileMenu.classList.remove('opacity-100');
            mobileMenu.classList.add('opacity-0');
            mobileMenuIcon.classList.remove('fa-times');
            mobileMenuIcon.classList.add('fa-bars');
        }
    });
</script>