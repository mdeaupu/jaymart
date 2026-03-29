<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branches extends Model
{
    protected $fillable = ['name', 'address'];

    /**
     * Relasi ke User (Pegawai di Cabang)
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    /**
     * Tambahkan Relasi ke Transaksi
     * Agar Owner bisa melihat total penjualan per cabang
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transactions::class, 'branch_id');
    }

    /**
     * Tambahkan Relasi ke Stok
     * Agar Owner bisa memantau stok kritis di tiap cabang
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stocks::class, 'branch_id');
    }
}
