# Laravel helpers files loader

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mphpmaster/laravel-helper-loader.svg?style=flat-square)](https://packagist.org/packages/mphpmaster/laravel-helper-loader)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mphpmaster/laravel-helper-loader/run-tests?label=tests)](https://github.com/mphpmaster/laravel-helper-loader/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mphpmaster/laravel-helper-loader/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mphpmaster/laravel-helper-loader/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mphpmaster/laravel-helper-loader.svg?style=flat-square)](https://packagist.org/packages/mphpmaster/laravel-helper-loader)

---
## Installation

You can install the package via composer:

```bash
composer require mphpmaster/laravel-helper-loader
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="mphpmaster-configs"
```

This is the contents of the published config file:

```php
return [
    'allowed_suffix' => [
        '.functions',
        '.class'
    ],

    'allowed_extension' => '.php',

    'auto_load_paths' => [],
];
```

## Usage

```php
\MPhpMaster\LaravelHelperLoader\HelperLoader::autoLoad(base_path("app/Helpers"));
```

## Testing

No tests

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [hlaCk](https://github.com/mPhpMaster)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
