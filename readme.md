laravel5-visitor
=====================

## Install via Composer

In composer.json
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url":  "https://github.com/miviskin/laravel5-visitor.git"
        }
    ],
    "require": {
        "miviskin/php-minify": "dev-master"
    }
}
```

Update composer

```shell
$ composer update
```

## Config

in config/app.php
```php
'providers' => [
    // Other Service Providers

    Miviskin\Visitor\VisitorServiceProvider::class,
],
```
