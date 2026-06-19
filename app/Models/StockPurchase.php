<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockPurchase extends Model
{
    protected $fillable = [
        'po_number',
        'branch_id',
        'supplier_id',
        'user_id',
        'purchase_date',
        'total_price',
        'status',
        'approved_by',
        'received_by',
        'invoice_number',
        'invoice_file',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];
    /**
     * Relasi ke Detail Item Pembelian (One-to-Many)
     */
    public function details()
    {
        return $this->hasMany(StockPurchaseDetail::class, 'stock_purchase_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id'); // Sesuaikan nama model Branch Anda
    }

    /**
     * User (Manager) yang membuat pengajuan
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * User (Owner/Pak Jayusman) yang menyetujui
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * User (Pegawai Gudang) yang menerima & memverifikasi barang di lapangan
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function getInvoiceUrlAttribute()
    {
        return $this->invoice_file ? asset('storage/' . $this->invoice_file) : null;
    }
}
