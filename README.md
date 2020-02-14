<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/curryable/master/docs/example.png" alt="Curryable" height="300">
</p>

<p align="center">
  <a href="https://travis-ci.org/nunomaduro/curryable"><img src="https://img.shields.io/travis/nunomaduro/curryable/master.svg" alt="Build Status"></img></a>
  <a href="https://packagist.org/packages/nunomaduro/curryable"><img src="https://poser.pugx.org/nunomaduro/curryable/d/total.svg" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/nunomaduro/curryable"><img src="https://poser.pugx.org/nunomaduro/curryable/v/stable.svg" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/nunomaduro/curryable"><img src="https://poser.pugx.org/nunomaduro/curryable/license.svg" alt="License"></a>
</p>

## About Curryable

**This package is under development, please don't use it on production and wait for the stable release!**

Curryable was created by, and is maintained by [Nuno Maduro](https://github.com/nunomaduro), and is an elegant and simple
**curry(f)** implementation in PHP. Currying is an advanced technique of working with functions. It **wraps the given expressions and arguments into a new function** that resolves a value.

## Installation & Usage

> **Requires [PHP 7.2+](https://php.net/releases/)**

Create your package using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/curryable
```

This helper usage is best described through example in the [Laravel](https://laravel.com) framework:

### On routing:

```php
Route::get('/', curry('view', 'welcome'));

// Calls Post::find($id);
Route::get('post/{id}', curry(Post::class)->find());

// Using the Eloquent macro
Route::get('post/{id}', Post::curry()->find());
```

### On macros:

Renaming the `lower` method to `toLower`:

```php
Str::macro('toLower', curry()->lower()); // or Str::macro('toLower', curry('strtolower'));
Str::toLower('NUNO'); // nuno
```

### On collections:

Using the global `strtoupper`:
```php
$collection = collect(['nuno'])->map(curry('strtoupper')); // ['NUNO']
```

Here is another example using the `each`:
```php 
// Calls User::create($user) foreach user
collect($users)->each(User::curry()->create());
```

### Dispatching jobs:
```php
dispatch(function () {
    Artisan::call('horizon:terminate');
});
```

Same example **now using `curry`**:
```php
dispatch(curry(Artisan::class)->call('horizon:terminate'));
```

### Curry on class instance methods

With global helper:

```php
$closure = curry($instance)->instanceMethodName();
$closure($first, $second);

$closure = curry($instance)->instanceMethodName($first);
$closure($second); // just need for the second argument

$closure = curry($instance)->instanceMethodName($first, $second);
$closure(); // no need for arguments
```

With trait `NunoMaduro\Curryable\Curryable`:

```php
$closure = $instance->curry()->instanceMethodName();
$closure($first, $second);

$closure = $instance->curry()->instanceMethodName($first);
$closure($second); // just need for the second argument

$closure = $instance->curry()->instanceMethodName($first, $second);
$closure(); // no need for arguments
```

### Curry on class static methods

```php
// Curry on instance methods
$closure = curry(Instance::class)->staticMethodName();
$closure($first, $second);

$closure = curry(Instance::class)->staticMethodName($first);
$closure($second); // just need for the second argument

$closure = curry(Instance::class)->staticMethodName($first, $second);
$closure(); // no need for arguments
```

### Curry on functions

```php
// Curry on instance methods
$closure = curry('function_name');
$closure($first, $second);

$closure = curry('function_name', $first);
$closure($second); // just need for the second argument

$closure = curry('function_name', $first, $second);
$closure(); // no need for arguments
```

## Contributing

Thank you for considering to contribute to *Curryable*. All the contribution guidelines are mentioned [here](CONTRIBUTING.md).

You can have a look at the [CHANGELOG](CHANGELOG.md) for constant updates & detailed information about the changes. You can also follow the twitter account for latest announcements or just come say hi!: [@enunomaduro](https://twitter.com/enunomaduro)

## Support the development
**Do you like this project? Support it by donating**

- Github sponsors: [Donate](https://github.com/sponsors/nunomaduro)
- PayPal: [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=66BYDWAT92N6L)
- Patreon: [Donate](https://www.patreon.com/nunomaduro)

## License

curryable is an open-sourced software licensed under the [MIT license](LICENSE.md).
