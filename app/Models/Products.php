<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Products extends Model
{
    protected $fillable = ['name', 'sell_price'];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stocks::class, 'product_id');
    }

    public function stock(): HasOne
    {
        return $this->hasOne(Stocks::class, 'product_id');
    }
}
