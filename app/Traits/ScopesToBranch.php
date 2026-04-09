<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ScopesToBranch
{
    protected static function booted()
    {
        static::addGlobalScope('branch_isolation', function (Builder $builder) {
            if (auth()->user()->hasAnyRole(['manager', 'supervisor', 'cashier', 'warehouse'])) {
                $table = $builder->getModel()->getTable();
                $builder->where($table . '.branch_id', auth()->user()->branch_id);
            }
        });
    }
}