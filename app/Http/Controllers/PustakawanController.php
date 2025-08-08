<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class PustakawanController extends Controller
{

    // Dashboard Pustakawan
    public function dashboard()
    {
        $statistics = [
            'total_users' => User::where('role', 'peminjam')->count(),
            'total_books' => Book::count(),
            'total_loans' => Loan::count(),
            'active_loans' => Loan::whereNull('tanggal_kembali')->count(),
            'books_available' => Book::where('dipinjam', false)->count(),
            'users_today' => User::where('role', 'peminjam')
                ->whereDate('created_at', Carbon::today())
                ->count(),
        ];

        $recent_loans = Loan::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        $recent_users = User::where('role', 'peminjam')
            ->latest()
            ->take(5)
            ->get();

        return view('pustakawan.dashboard', compact('statistics', 'recent_loans', 'recent_users'));
    }

    // Kelola Users
    public function users()
    {
        $users = User::where('role', 'peminjam')
            ->withCount('loans')
            ->paginate(15);

        $stats = [
            'total_users' => User::where('role', 'peminjam')->count(),
            'users_hari_ini' => User::where('role', 'peminjam')
                ->whereDate('created_at', Carbon::today())
                ->count(),
            'users_minggu_ini' => User::where('role', 'peminjam')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count(),
            'users_bulan_ini' => User::where('role', 'peminjam')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->count(),
            'users_aktif' => User::where('role', 'peminjam')
                ->where('updated_at', '>=', Carbon::now()->subDays(30))
                ->whereNotNull('updated_at')
                ->count(),
        ];

        return view('pustakawan.users.index', compact('users', 'stats'));
    }

    public function createUser()
    {
        return view('pustakawan.users.create');
    }

    public function storeUser(Request $request)
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
            'role' => 'peminjam',
        ]);

        return redirect()->route('pustakawan.users.index')
            ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        if ($user->role !== 'peminjam') {
            abort(404, 'User tidak ditemukan.');
        }
        return view('pustakawan.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        if ($user->role !== 'peminjam') {
            abort(404, 'User tidak ditemukan.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('pustakawan.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if ($user->role !== 'peminjam') {
            abort(404, 'User tidak ditemukan.');
        }

        // Cek apakah user masih memiliki pinjaman aktif
        $activeLoan = $user->loans()->whereNull('tanggal_kembali')->first();
        if ($activeLoan) {
            return redirect()->route('pustakawan.users.index')
                ->with('error', 'Tidak dapat menghapus user yang masih memiliki pinjaman aktif.');
        }

        $userName = $user->name;
        $user->delete();
        
        return redirect()->route('pustakawan.users.index')
            ->with('success', "User {$userName} berhasil dihapus.");
    }

    public function showUser(User $user)
    {
        if ($user->role !== 'peminjam') {
            abort(404, 'User tidak ditemukan.');
        }

        $loans = $user->loans()->with('book')->latest()->paginate(10);
        $activeLoans = $user->loans()->whereNull('tanggal_kembali')->count();
        $totalLoans = $user->loans()->count();

        return view('pustakawan.users.show', compact('user', 'loans', 'activeLoans', 'totalLoans'));
    }
}