<?php

declare(strict_types=1);

namespace NunoMaduro\Curryable\Adapters\Laravel;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

/**
 * @internal
 */
final class CurryableServiceProvider extends ServiceProvider
{
    /**
     * Registers the Eloquent macro.
     */
    public function register(): void
    {
        Builder::macro('curry', function () {
            return curry($this->model);
        });
    }
}
