<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'book_id',
        'nama',
        'no_hp',
        'alamat',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
    ];
    public function getDendaAttribute()
    {
        if (!$this->tanggal_pengembalian || $this->status !== 'dipinjam') {
            return 0;
        }

        $keterlambatan = Carbon::parse($this->tanggal_pengembalian)->diffInDays(Carbon::now(), false);

        return $keterlambatan > 0 ? $keterlambatan * 1000 : 0; // Contoh: Rp 1000/hari
    }

    public function getTerlambatAttribute()
    {
        // Pastikan ada tanggal pengembalian
        if (!$this->tanggal_pengembalian) {
            return null;
        }
        
        $dueDate = Carbon::parse($this->tanggal_pengembalian);
        $now = Carbon::now();

        // Jika waktu sekarang belum melewati tanggal batas pengembalian, tidak terlambat
        if ($now->lte($dueDate)) {
            return null;
        }

        $diff = $dueDate->diff($now);

        return sprintf('%d hari, %d jam, %d menit', $diff->d, $diff->h, $diff->i);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}