<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
}
