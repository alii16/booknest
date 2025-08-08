<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'kategori',
        'tahun',
        'sampul',
        'dipinjam',
        'stok',
    ];

    /**
     * Get current active loan (buku yang sedang dipinjam)
     */
    public function loan()
    {
        return $this->hasOne(Loan::class)->whereNull('tanggal_kembali');
    }

    /**
     * Get all loans for this book (untuk statistik)
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Check if book is currently borrowed
     */
    public function isBorrowed()
    {
        return $this->dipinjam;
    }

    /**
     * Check if book is available
     */
    public function isAvailable()
    {
        return !$this->dipinjam && $this->stok > 0;
    }

    /**
     * Get book status
     */
    public function getStatusAttribute()
    {
        if ($this->dipinjam) {
            return 'dipinjam';
        } elseif ($this->stok > 0) {
            return 'tersedia';
        } else {
            return 'habis';
        }
    }
}