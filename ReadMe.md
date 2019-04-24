# Marktstand [WIP]

[![Build Status](https://travis-ci.org/plattform-neun/marktstand.svg?branch=master)](https://travis-ci.org/plattform-neun/marktstand)

## Introduction
Marktstand `[ˈmaʁktˌʃtant]` is an open source library to create a farmers market with Laravel. Markstand provides solutions for common e-commerce tasks, such as:
- Shopping Carts
- Products and Categories
- Roles (Customers, Sellers, Admins)
- Orders, Checkout

## Installation
Markstand can be installed via composer:
```
composer require plattform-neun/marktstand
```
The package will automatically register a service provider, but you may need to publish the Marktstand configuration file:
```
php artisan vendor:publish --provider="Marktstand\ServiceProvider"
```

## Credits
See [all contributors](https://github.com/plattform-neun/marktstand/graphs/contributors).

## License
The MIT-License ([MIT](https://github.com/plattform-neun/marktstand/blob/master/LICENSE)).