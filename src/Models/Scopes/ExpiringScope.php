<?php

namespace Soap\LaravelSubscriptions\Mdoels\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ExpiringScope implements Scope
{
    protected $extensions = [
        'OnlyExpired',
        'WithExpired',
        'WithoutExpired',
    ];

    public function apply(Builder $builder, Model $model)
    {
        $builder->where(
            fn (Builder $query) => $query->where('ends_at', '>', now())
                ->orWhereNull('ends_at')
        );
    }

    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }

    protected function addWithExpired(Builder $builder)
    {
        $builder->macro('withExpired', function (Builder $builder, $withExpired = true) {
            if ($withExpired) {
                return $builder->withoutGlobalScope($this);
            }

            return $builder->withoutExpired();
        });
    }

    protected function addWithoutExpired(Builder $builder)
    {
        $builder->macro('withoutExpired', function (Builder $builder) {
            $builder->withoutGlobalScope($this)->where(
                fn (Builder $query) => $query->where('starts_at', '>', now())
                    ->orWhereNull('starts_at')
            );

            return $builder;
        });
    }

    protected function addOnlyExpired(Builder $builder)
    {
        $builder->macro('onlyExpired', function (Builder $builder) {
            $builder->withoutGlobalScope($this)->where(
                fn (Builder $query) => $query->where('starts_at', '<=', now())
                    ->whereNotNull('starts_at')
            );

            return $builder;
        });
    }
}
