<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashierCorrections extends Model
{
    protected $fillable = [
        'branch_id',
        'transaction_id',
        'product_id',
        'user_id',
        'wrong_quantity',
        'corrected_quantity',
        'quantity_difference',
        'financial_impact',
        'reason',
        'status',
        'approved_by',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
