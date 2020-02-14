<?php

declare(strict_types=1);

class CurryClass
{
    public $publicInstanceProperty = 'publicInstanceProperty';

    public static $publicStaticProperty = 'publicStaticProperty';

    private $privateInstanceProperty = 'privateInstanceProperty';

    private static $privateStaticProperty = 'privateStaticProperty';

    public function instanceMethod($first, $second)
    {
        return "$first $second";
    }

    public static function staticMethod($first, $second)
    {
        return "$first $second";
    }
}

it('curry the given function', function (): void {
    $closure = curry('strtolower');
    assertEquals($closure('NUNO'), 'nuno');

    $closure = curry('strtolower', 'NUNO');
    assertEquals($closure(), 'nuno');
});

it('curry the given instance', function (): void {
    $closure = curry(new CurryClass())->instanceMethod();
    assertEquals($closure('first', 'second'), 'first second');

    $closure = curry(new CurryClass())->instanceMethod('first');
    assertEquals($closure('second'), 'first second');

    $closure = curry(new CurryClass())->instanceMethod('first', 'second');
    assertEquals($closure(), 'first second');
});

it('curry given string class', function (): void {
    $closure = curry(CurryClass::class)->staticMethod();
    assertEquals($closure('first', 'second'), 'first second');

    $closure = curry(CurryClass::class)->staticMethod('first');
    assertEquals($closure('second'), 'first second');

    $closure = curry(CurryClass::class)->staticMethod('first', 'second');
    assertEquals($closure(), 'first second');
});

it('curry to properties', function (): void {
    $closure = curry(new CurryClass())->publicInstanceProperty;
    assertEquals($closure(), 'publicInstanceProperty');

    $closure = curry(CurryClass::class)->publicStaticProperty;
    assertEquals($closure(), 'publicStaticProperty');

    $closure = curry()->privateInstanceProperty;
    $closure = $closure->bindTo(new CurryClass(), CurryClass::class);
    assertEquals($closure(), 'privateInstanceProperty');
});

it('allows pending binds', function (): void {
    $closure = curry()->instanceMethod();

    $closure = $closure->bindTo(new CurryClass(), CurryClass::class);

    assertEquals($closure('first', 'second'), 'first second');
});
