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
    $this->assertEquals($closure('NUNO'), 'nuno');

    $closure = curry('strtolower', 'NUNO');
    $this->assertEquals($closure(), 'nuno');
});

it('curry the given instance', function (): void {
    $closure = curry(new CurryClass())->instanceMethod();
    $this->assertEquals($closure('first', 'second'), 'first second');

    $closure = curry(new CurryClass())->instanceMethod('first');
    $this->assertEquals($closure('second'), 'first second');

    $closure = curry(new CurryClass())->instanceMethod('first', 'second');
    $this->assertEquals($closure(), 'first second');
});

it('curry given string class', function (): void {
    $closure = curry(CurryClass::class)->staticMethod();
    $this->assertEquals($closure('first', 'second'), 'first second');

    $closure = curry(CurryClass::class)->staticMethod('first');
    $this->assertEquals($closure('second'), 'first second');

    $closure = curry(CurryClass::class)->staticMethod('first', 'second');
    $this->assertEquals($closure(), 'first second');
});

it('curry to properties', function (): void {
    $closure = curry(new CurryClass())->publicInstanceProperty;
    $this->assertEquals($closure(), 'publicInstanceProperty');

    $closure = curry(CurryClass::class)->publicStaticProperty;
    $this->assertEquals($closure(), 'publicStaticProperty');

    $closure = curry()->privateInstanceProperty;
    $closure = $closure->bindTo(new CurryClass(), CurryClass::class);
    $this->assertEquals($closure(), 'privateInstanceProperty');
});

it('allows pending binds', function (): void {
    $closure = curry()->instanceMethod();

    $closure = $closure->bindTo(new CurryClass(), CurryClass::class);

    $this->assertEquals($closure('first', 'second'), 'first second');
});
