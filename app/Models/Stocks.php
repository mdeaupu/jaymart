<?php

namespace App\Models;

use App\Traits\ScopesToBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stocks extends Model
{
    use ScopesToBranch;

    protected $fillable = ['branch_id', 'product_id', 'quantity', 'low_stock_threshold'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
}
