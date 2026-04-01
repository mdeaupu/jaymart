<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockLogs extends Model
{
    protected $fillable = ['branch_id', 'product_id', 'user_id', 'type', 'amount', 'reason'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
}
