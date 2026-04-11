<?php

namespace App\Models;

use App\Traits\ScopesToBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transactions extends Model
{
    use ScopesToBranch;

    protected $fillable = ['branch_id', 'user_id', 'invoice_number', 'total_price'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionsDetail::class, 'transaction_id');
    }
    protected static function booted()
{
    static::creating(function ($transaction) {
        $transaction->invoice_number = 'INV-' . now()->format('YmdHis');
    });
}
}
