<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLogs extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branches::class);
    }
}
