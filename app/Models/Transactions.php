<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transactions extends Model
{
    // Jika nama tabel di database adalah 'transactions', Laravel sudah otomatis mendeteksi.
    // Namun jika Anda ingin eksplisit:
    // protected $table = 'transactions';

    protected $fillable = ['branch_id', 'user_id', 'invoice_number', 'total_price'];

    /**
     * Relasi ke Cabang
     * Kita tambahkan 'branch_id' secara eksplisit karena nama model Anda 'Branches'
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }

    /**
     * Relasi ke User/Pegawai yang melayani transaksi
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Detail Transaksi (Barang apa saja yang dibeli)
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransactionsDetail::class, 'transaction_id');
    }
}
