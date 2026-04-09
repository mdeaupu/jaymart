<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalRequest extends Model
{
    protected $fillable = [
        'transaction_id',
        'requested_by',
        'approved_by',
        'type',
        'status',
        'reason'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transaction_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
