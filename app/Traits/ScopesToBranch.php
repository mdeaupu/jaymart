<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopesToBranch
{
    protected static function booted()
    {
        static::addGlobalScope('branch_isolation', function (Builder $builder) {
            if (auth()->check() && auth()->user()->hasRole('Manajer Toko')) {
                $table = $builder->getQuery()->from;
                $builder->where($table . '.branch_id', auth()->user()->branch_id);
            }
        });
    }
}