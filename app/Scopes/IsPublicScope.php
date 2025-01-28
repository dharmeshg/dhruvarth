<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class IsPublicScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if ($user && $user->role === 'administrator') {
            return $builder; // Admin can see all products, including private ones
        }
        if ($user && $user->hasProductAccess()) {
            return $builder;
        }
        return $builder->where('is_public', 1);
    }
}