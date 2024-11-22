# Subscription management package for Laravel application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/soap/laravel-subscriptions.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-subscriptions)
[![PHPStan](https://github.com/soap/laravel-subscriptions/actions/workflows/phpstan.yml/badge.svg)](https://github.com/soap/laravel-subscriptions/actions/workflows/phpstan.yml)
[![run-tests](https://github.com/soap/laravel-subscriptions/actions/workflows/run-tests.yml/badge.svg)](https://github.com/soap/laravel-subscriptions/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/soap/laravel-subscriptions/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/soap/laravel-subscriptions/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/soap/laravel-subscriptions.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-subscriptions)

Soap Laravel Subscriptions is a flexible plans and subscription management system for Laravel, with the required tools to run your SAAS like services efficiently. It's simple architecture, accompanied by powerful underlying to afford solid platform for your business.

 - Payments are out of scope for this package.
 - You may want to extend some of the core models, in case you need to override the logic behind some helper methods like renew(), cancel() etc. E.g.: when cancelling a subscription you may want to also cancel the recurring payment attached.
## Version Support
| Laravel Subscriptions      | Larvel Version      |
| ------------- | -------------------------------- |
| 1.x           | 10.x, 11.x on PHP 8.2 and 8.3w 1 |

## Support us



## Installation

You can install the package via composer:

```bash
composer require soap/laravel-subscriptions
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="subscriptions-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="subscriptions-config"
```

This is the contents of the published config file:

```php

return [

    // Manage autoload migrations
    'autoload_migrations' => true,

    // Subscriptions Database Tables
    'tables' => [

        'plans' => 'plans',
        'plan_features' => 'plan_features',
        'plan_subscriptions' => 'plan_subscriptions',
        'plan_feature_usage' => 'plan_feature_usage',

    ],

    // Subscriptions Models
    'models' => [

        'plan' => \Soap\LaravelSubscriptions\Models\Plan::class,
        'plan_feature' => \Soap\LaravelSubscriptions\Models\PlanFeature::class,
        'plan_subscription' => \Soap\LaravelSubscriptions\Models\PlanSubscription::class,
        'plan_feature_usage' => \Soap\LaravelSubscriptions\Models\PlanSubscriptionUsage::class,

    ],

];
```

## Usage

```php

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
- Rinvex for their excellent package, laravel-subscriptions (code base for this package)
- [Prasit Gebsaap](https://github.com/soap)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
