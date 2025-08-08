<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $statistics = [
            'total_users' => User::count(),
            'total_pustakawan' => User::where('role', 'pustakawan')->count(),
            'total_peminjam' => User::where('role', 'peminjam')->count(),
            'total_books' => Book::count(),
            'total_loans' => Loan::count(),
            'active_loans' => Loan::whereNull('tanggal_kembali')->count(),
            'returned_loans' => Loan::whereNotNull('tanggal_kembali')->count(),
        ];

        // Data untuk chart - peminjaman terbaru
        $recent_loans = Loan::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        // Buku terpopuler berdasarkan jumlah peminjaman
        $popular_books = Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('statistics', 'recent_loans', 'popular_books'));
    }

    public function bookStats()
    {
        $total_books = Book::count();
        $available_books = Book::where('dipinjam', false)->where('stok', '>', 0)->count();
        $borrowed_books = Book::where('dipinjam', true)->count();
        $out_of_stock = Book::where('stok', '<=', 0)->count();
        $total_categories = Book::distinct('kategori')->count();

        $books_by_category = Book::selectRaw('kategori, COUNT(*) as count')
            ->groupBy('kategori')
            ->orderBy('count', 'desc')
            ->get();

        $popular_books = Book::withCount('loans')
            ->orderBy('loans_count', 'desc')
            ->take(10)
            ->get();

        $recent_books = Book::latest()
            ->take(5)
            ->get();

        return view('admin.books.stats', compact(
            'total_books',
            'available_books', 
            'borrowed_books',
            'out_of_stock',
            'total_categories',
            'books_by_category',
            'popular_books',
            'recent_books'
        ));
    }

    // Kelola Pustakawan
    public function pustakawan()
    {
        $pustakawan = User::where('role', 'pustakawan')->paginate(10);
        
        // Statistics untuk pustakawan
        $stats = [
            'total_pustakawan' => User::where('role', 'pustakawan')->count(),
            'pustakawan_hari_ini' => User::where('role', 'pustakawan')
                ->whereDate('created_at', Carbon::today())
                ->count(),
            'pustakawan_minggu_ini' => User::where('role', 'pustakawan')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
            'pustakawan_bulan_ini' => User::where('role', 'pustakawan')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
            'pustakawan_aktif' => User::where('role', 'pustakawan')
                ->where('updated_at', '>=', Carbon::now()->subDays(7))
                ->whereNotNull('updated_at')
                ->count(),
            'rata_rata_registrasi' => User::where('role', 'pustakawan')
                ->whereMonth('created_at', Carbon::now()->month)
                ->count() / max(1, Carbon::now()->day)
        ];

        // Registrasi pustakawan per bulan (6 bulan terakhir)
        $registrasi_bulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $registrasi_bulanan[] = [
                'bulan' => $bulan->format('M Y'),
                'jumlah' => User::where('role', 'pustakawan')
                    ->whereMonth('created_at', $bulan->month)
                    ->whereYear('created_at', $bulan->year)
                    ->count()
            ];
        }

        return view('admin.pustakawan.index', compact('pustakawan', 'stats', 'registrasi_bulanan'));
    }

    public function createPustakawan()
    {
        return view('admin.pustakawan.create');
    }

    public function storePustakawan(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pustakawan',
        ]);

        return redirect()->route('admin.pustakawan.index')
            ->with('success', 'Pustakawan berhasil ditambahkan.');
    }

    public function editPustakawan(User $pustakawan)
    {
        if ($pustakawan->role !== 'pustakawan') {
            abort(404);
        }
        return view('admin.pustakawan.edit', compact('pustakawan'));
    }

    public function updatePustakawan(Request $request, User $pustakawan)
    {
        if ($pustakawan->role !== 'pustakawan') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $pustakawan->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $pustakawan->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $pustakawan->password,
        ]);

        return redirect()->route('admin.pustakawan.index')
            ->with('success', 'Data pustakawan berhasil diperbarui.');
    }

    public function destroyPustakawan(User $pustakawan)
    {
        if ($pustakawan->role !== 'pustakawan') {
            abort(404);
        }

        $pustakawan->delete();
        return redirect()->route('admin.pustakawan.index')
            ->with('success', 'Pustakawan berhasil dihapus.');
    }

    // Kelola User/Peminjam
    public function users()
    {
        $users = User::where('role', '!=', 'admin')
            ->withCount('loans')
            ->paginate(15);

        // Statistics untuk users
        $user_stats = [
            'total_users' => User::where('role', '!=', 'admin')->count(),
            'total_peminjam' => User::where('role', 'peminjam')->count(),
            'total_pustakawan' => User::where('role', 'pustakawan')->count(),
            'users_hari_ini' => User::where('role', '!=', 'admin')
                ->whereDate('created_at', Carbon::today())
                ->count(),
            'users_minggu_ini' => User::where('role', '!=', 'admin')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
            'users_aktif' => User::where('role', '!=', 'admin')
                ->where('updated_at', '>=', Carbon::now()->subDays(30))
                ->whereNotNull('updated_at')
                ->count(),
        ];

        return view('admin.users.index', compact('users', 'user_stats'));
    }

    public function editUser(User $user)
    {
        if ($user->role === 'admin') {
            abort(404);
        }
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:pustakawan,peminjam'],
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if ($user->role === 'admin') {
            abort(404);
        }

        // Hapus semua loans yang terkait dengan user ini
        $user->loans()->delete();
        
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}