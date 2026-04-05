<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branches extends Model
{
    protected $fillable = ['name', 'address'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transactions::class, 'branch_id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stocks::class, 'branch_id');
    }
}
