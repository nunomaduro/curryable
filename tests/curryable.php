<?php

declare(strict_types=1);

use NunoMaduro\Curryable\Curryable;
use NunoMaduro\Curryable\CurryProxy;

class CurryableClass
{
    use Curryable;

    public function instanceMethod($string)
    {
        return $string;
    }
}

it('gets an instance of curry proxy', function (): void {
    assertInstanceOf(CurryProxy::class, (new CurryableClass)->curry());
});

it('proxies arguments as usual', function (): void {
    $instanceMethod =  (new CurryableClass)->curry()->instanceMethod('foo');

    assertEquals('foo', $instanceMethod());
});
