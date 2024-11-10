# Subscription management package for Laravel application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/soap/laravel-subscriptions.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-subscriptions)
[![PHPStan](https://github.com/soap/laravel-subscriptions/actions/workflows/phpstan.yml/badge.svg)](https://github.com/soap/laravel-subscriptions/actions/workflows/phpstan.yml)
[![run-tests](https://github.com/soap/laravel-subscriptions/actions/workflows/run-tests.yml/badge.svg)](https://github.com/soap/laravel-subscriptions/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/soap/laravel-subscriptions/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/soap/laravel-subscriptions/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/soap/laravel-subscriptions.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-subscriptions)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-subscriptions.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-subscriptions)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require soap/laravel-subscriptions
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-subscriptions-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-subscriptions-config"
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
        'plan_subscription_usage' => 'plan_subscription_usage',

    ],

    // Subscriptions Models
    'models' => [

        'plan' => \Soap\LaravelSubscriptions\Models\Plan::class,
        'plan_feature' => \Soap\LaravelSubscriptions\Models\PlanFeature::class,
        'plan_subscription' => \Soap\LaravelSubscriptions\Models\PlanSubscription::class,
        'plan_subscription_usage' => \Soap\LaravelSubscriptions\Models\PlanSubscriptionUsage::class,

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
