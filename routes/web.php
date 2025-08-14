<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PustakawanController;

Route::get('/', [BookController::class, 'index']);
// Redirect ke /buku setelah login
Route::get('/dashboard', fn() => redirect('/buku'))->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes - Hanya untuk Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/books/stats', [AdminController::class, 'bookStats'])->name('books.stats');
    
    // Kelola Pustakawan
    Route::get('/pustakawan', [AdminController::class, 'pustakawan'])->name('pustakawan.index');
    Route::get('/pustakawan/create', [AdminController::class, 'createPustakawan'])->name('pustakawan.create');
    Route::post('/pustakawan', [AdminController::class, 'storePustakawan'])->name('pustakawan.store');
    Route::get('/pustakawan/{pustakawan}/edit', [AdminController::class, 'editPustakawan'])->name('pustakawan.edit');
    Route::patch('/pustakawan/{pustakawan}', [AdminController::class, 'updatePustakawan'])->name('pustakawan.update');
    Route::delete('/pustakawan/{pustakawan}', [AdminController::class, 'destroyPustakawan'])->name('pustakawan.destroy');
    
    // Kelola Users
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pinjamanku', [LoanController::class, 'myLoans'])->name('pinjamanku');
    
    // Peminjam bisa meminjam buku
    Route::post('/pinjam/{book}', [LoanController::class, 'store'])->name('pinjam');
});

// Routes untuk Pustakawan
Route::middleware(['auth', 'isPustakawan'])->prefix('pustakawan')->name('pustakawan.')->group(function () {
    Route::get('/dashboard', [PustakawanController::class, 'dashboard'])->name('dashboard');
    
    // User Management untuk Pustakawan
    Route::get('/users', [PustakawanController::class, 'users'])->name('users.index');
    Route::get('/users/create', [PustakawanController::class, 'createUser'])->name('users.create');
    Route::post('/users', [PustakawanController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [PustakawanController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [PustakawanController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [PustakawanController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [PustakawanController::class, 'destroyUser'])->name('users.destroy');

    // Kelola Buku untuk Pustakawan
    Route::resource('books', BookController::class)->except(['show']);
    
    // Kelola Peminjaman
    Route::get('/loans', [LoanController::class, 'adminLoans'])->name('loans.index');
    Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');
});

// Daftar buku terbuka untuk umum
Route::get('/buku', [BookController::class, 'index']);

// Data Peminjaman untuk Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/loans', [LoanController::class, 'adminLoans'])->name('loans.index');
});

Route::get('/buku', [BookController::class, 'index'])->name('buku.index');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

require __DIR__.'/auth.php';