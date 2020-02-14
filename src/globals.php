<?php

use NunoMaduro\Curryable\CurryProxy;

if (! \function_exists('curry')) {

    /**
     * Creates a new curry proxy.
     *
     * @param  object|string|null  $target A class name, a instance object, function or null (pending new this).
     *
     * @return CurryProxy|Closure
     */
    function curry($target = null)
    {
        $curryProxy = new CurryProxy($target);

        if ($target !== null && ! is_object($target) && ! class_exists($target)) {
            $arguments = func_get_args();
            array_shift($arguments);

            return Closure::fromCallable(function () use ($curryProxy, $arguments) {
                return $curryProxy->__invoke(...array_merge($arguments, func_get_args()));
            });
        }

        return $curryProxy;
    }
}
