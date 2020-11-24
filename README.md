# Symfony Correlation ID bundle

This bundle keeps track of correlation-id which makes it easier
to track requests across microservices.

![Tests](https://github.com/Jontsa/JontsaMaintenanceBundle/workflows/Tests/badge.svg)

## Features

- Creates unique correlation ID
- Picks up x-correlation-id from incoming HTTP requests which becomes the parent correlation id
- Includes Monolog processor to automatically write correlation id and parent id to log messages
- Includes Messenger middleware to automatically write correlation id to outgoing messages and read id from incoming messages

## Still missing

- HttpClient middleware
- Configuration
- More tests

## Requirements

- Symfony 5.1+
- PHP 7.2+
- composer

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Add following repository to your composer.json

```yaml
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:Jontsa/CorrelationIdBundle.git"
        }
    ]
```

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require jontsa/correlation-id-bundle:dev-master
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require jontsa/correlation-id-bundle:dev-master
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Jontsa\Bundle\CorrelationIdBundle\JontsaCorrelationIdBundle::class => ['all' => true],
];
```

## Usage

The bundle automatically starts listening for request events and registers monolog
processor. To enable messenger middleware, configure it in messenger.yaml:

```yaml
# config/packages/messenger.yaml
framework:
    messenger:
        buses:
            messenger.bus.default:
                middleware:
                    - 'jontsa.correlation_id.messenger_middleware'
```