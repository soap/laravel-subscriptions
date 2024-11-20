<?php

declare(strict_types=1);

namespace Soap\LaravelSubscriptions\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug as BaseHasSlug;

trait HasSlug
{
    use BaseHasSlug;

    protected static function bootHasSlug(): void
    {
        // Auto generate slugs early before validation
        static::creating(function (Model $model): void {
            // @phpstan-ignore-next-line
            if ($model->exists && $model->getSlugOptions()->generateSlugsOnUpdate) {
                // @phpstan-ignore-next-line
                $model->generateSlugOnUpdate();
                // @phpstan-ignore-next-line
            } elseif (! $model->exists && $model->getSlugOptions()->generateSlugsOnCreate) {
                // @phpstan-ignore-next-line
                $model->generateSlugOnCreate();
            }
        });
    }
}
