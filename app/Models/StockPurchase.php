<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockPurchase extends Model
{
    protected $fillable = [
        'branch_id',
        'supplier_id',
        'product_id',
        'user_id',
        'quantity',
        'total_price',
        'invoice_number',
        'purchase_date'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
