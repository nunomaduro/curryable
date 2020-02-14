<?php

declare(strict_types=1);

namespace NunoMaduro\Curryable;

trait Curryable
{
    /**
     * Creates a new curry proxy instance from the current instance.
     */
    public function curry(): CurryProxy
    {
        return curry($this);
    }
}

