<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockPurchaseDetail extends Model
{
    protected $fillable = [
        'stock_purchase_id',
        'product_id',
        'quantity_ordered',   // Jumlah rencana awal dari manager & di-ACC owner
        'quantity_received',  // Jumlah riil yang dihitung pegawai gudang (default: 0)
        'price_per_item',
        'expired_at',         // Diisi oleh pegawai gudang saat barang datang fisik
    ];

    protected $casts = [
        'expired_at' => 'date',
    ];

    /**
     * Relasi balik ke Header/Nota Pembelian
     */
    public function purchase()
    {
        return $this->belongsTo(StockPurchase::class, 'stock_purchase_id');
    }

    /**
     * Relasi ke data produk terkait
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id'); // Sesuaikan nama model Product Anda
    }
}
