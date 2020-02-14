<?php

declare(strict_types=1);

namespace NunoMaduro\Curryable;

use Closure;

/**
 * @internal
 */
final class CurryProxy
{
    /**
     * @var object|string|null
     */
    private $target;

    /**
     * Creates a new curry proxy.
     *
     * @param  object|string|null  $target A class name, a instance object, function or null (pending new this).
     */
    public function __construct($target)
    {
        $this->target = $target;
    }

    /**
     * Returns a new Closure that eventually resolve to a value.
     */
    public function __call(string $method, array $arguments): Closure
    {
        return function () use ($method, $arguments) {
            /** @var array<int, mixed> $arguments */
            $arguments = array_merge($arguments, func_get_args());

            /**
             * First, we check if the curry was created with pending binding. If yes, we
             * call the method on the new this.
             */
            if (get_class($this) !== CurryProxy::class) {
                return call_user_func_array([$this, $method], $arguments);
            }

            /**
             * Next, if the target is an object, we call the method on the object instance.
             */
            if (is_object($this->target)) {
                return call_user_func_array([$this->target, $method], $arguments);
            }

            /**
             * Finally, we assume that the curry will call a static method.
             */
            return forward_static_call_array([$this->target, $method], $arguments);
        };
    }

    public function __get(string $attribute): Closure
    {
        return function () use ($attribute) {
            /**
             * First, we check if the curry was created with pending binding. If yes,
             * we return the attribute of the new this.
             */
            if (get_class($this) !== CurryProxy::class) {
                return $this->{$attribute};
            }

            /**
             * Next, if the target is an object, we call the method on the object instance.
             */
            if (is_object($this->target)) {
                return $this->target->{$attribute};
            }

            /**
             * Finally, we assume that the curry will call a static method.
             */
            return $this->target::$$attribute;
        };
    }

    /**
     * Invokes the callable target.
     *
     * @return mixed
     */
    public function __invoke()
    {
        $arguments = func_get_args();

        return call_user_func_array($this->target, $arguments);
    }
}
