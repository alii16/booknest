<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Tampilkan daftar buku (untuk semua user)
    public function index(Request $request)
    {
        $query = Book::query();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }
        
        $books = $query->paginate(12);
        $categories = Book::distinct()->pluck('kategori');

        // Jika user mengakses lewat URL pustakawan
        if ($request->is('pustakawan/books') || $request->is('pustakawan/books/*')) {
            return view('pustakawan.books.index', compact('books', 'categories'));
        }

        return view('buku.index', compact('books', 'categories'));
    }

    // Tampilkan form tambah buku
    public function create()
    {
        // Hanya pustakawan yang bisa akses
        if (!auth()->user() || auth()->user()->role !== 'pustakawan') {
            abort(403, 'Unauthorized');
        }
        
        return view('pustakawan.books.create');
    }

    // Simpan buku baru
    public function store(Request $request)
    {
        // Hanya pustakawan yang bisa akses
        if (!auth()->user() || auth()->user()->role !== 'pustakawan') {
            abort(403, 'Unauthorized');
        }
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tahun' => 'required|integer|min:1000|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'judul.required' => 'Judul buku wajib diisi',
            'judul.max' => 'Judul tidak boleh lebih dari 255 karakter',
            'penulis.required' => 'Nama penulis wajib diisi',
            'penulis.max' => 'Nama penulis tidak boleh lebih dari 255 karakter',
            'kategori.required' => 'Kategori buku wajib diisi',
            'tahun.required' => 'Tahun terbit wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun tidak valid',
            'tahun.max' => 'Tahun tidak boleh lebih dari tahun sekarang',
            'stok.required' => 'Stok buku wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh kurang dari 0',
            'sampul.image' => 'File harus berupa gambar',
            'sampul.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'sampul.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($request->hasFile('sampul')) {
            $validated['sampul'] = $request->file('sampul')->store('sampul', 'public');
        }

        Book::create($validated);
        
        return redirect()->route('pustakawan.books.index')
                        ->with('success', 'Buku berhasil ditambahkan!');
    }

    // Tampilkan form edit
    public function edit(Book $book)
    {
        // Hanya pustakawan yang bisa akses
        if (!auth()->user() || auth()->user()->role !== 'pustakawan') {
            abort(403, 'Unauthorized');
        }
        
        return view('pustakawan.books.edit', compact('book'));
    }

    // Update data buku
    public function update(Request $request, Book $book)
    {
        // Hanya pustakawan yang bisa akses
        if (!auth()->user() || auth()->user()->role !== 'pustakawan') {
            abort(403, 'Unauthorized');
        }
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tahun' => 'required|integer|min:1000|max:' . date('Y'),
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'judul.required' => 'Judul buku wajib diisi',
            'judul.max' => 'Judul tidak boleh lebih dari 255 karakter',
            'penulis.required' => 'Nama penulis wajib diisi',
            'penulis.max' => 'Nama penulis tidak boleh lebih dari 255 karakter',
            'kategori.required' => 'Kategori buku wajib diisi',
            'tahun.required' => 'Tahun terbit wajib diisi',
            'tahun.integer' => 'Tahun harus berupa angka',
            'tahun.min' => 'Tahun tidak valid',
            'tahun.max' => 'Tahun tidak boleh lebih dari tahun sekarang',
            'stok.required' => 'Stok buku wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh kurang dari 0',
            'sampul.image' => 'File harus berupa gambar',
            'sampul.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'sampul.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        // Handle file upload
        if ($request->hasFile('sampul')) {
            // Hapus sampul lama jika ada
            if ($book->sampul && Storage::disk('public')->exists($book->sampul)) {
                Storage::disk('public')->delete($book->sampul);
            }
            
            $validated['sampul'] = $request->file('sampul')->store('sampul', 'public');
        }

        $book->update($validated);
        
        return redirect()->route('pustakawan.books.index')
                        ->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        // Hanya pustakawan yang bisa akses
        if (!auth()->user() || auth()->user()->role !== 'pustakawan') {
            abort(403, 'Unauthorized');
        }

        try {
            // Hapus file sampul jika ada
            if ($book->sampul) {
                Storage::disk('public')->delete($book->sampul);
            }

            // Hapus buku dari database
            $book->delete();

            return redirect()->route('pustakawan.books.index')
                            ->with('success', 'Buku berhasil dihapus!');
            
        } catch (\Exception $e) {
            // Log error untuk debugging lebih lanjut
            \Log::error('Gagal menghapus buku: ' . $e->getMessage(), ['book_id' => $book->id]);
            
            // Cek jika error terkait foreign key constraint
            if (str_contains($e->getMessage(), 'Integrity constraint violation')) {
                return redirect()->route('pustakawan.books.index')
                                ->with('error', 'Buku tidak dapat dihapus karena masih terkait dengan data lain (mis. riwayat peminjaman)!');
            }

            return redirect()->route('pustakawan.books.index')
                            ->with('error', 'Terjadi kesalahan saat menghapus buku. Silakan cek log aplikasi untuk detailnya.');
        }
    }

    // Method untuk menampilkan detail buku (opsional)
    public function show(Book $book)
    {
        return view('buku.detail', compact('book'));
    }
}