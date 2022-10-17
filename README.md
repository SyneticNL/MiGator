# Laravel Migator
[![Latest Version](https://img.shields.io/github/release/syneticnl/migator.svg?style=flat-square)](https://github.com/syneticnl/migator/releases)
[![GitHub Workflow Status](https://github.com/syneticnl/migator/actions/workflows/phpunit.yml/badge.svg)](https://github.com/SyneticNL/MiGator/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/wearesynetic/laravel-migator.svg?style=flat-square)](https://packagist.org/packages/wearesynetic/laravel-migator)

![Laravel Migator personified as Arnold Schwarzenegger in Terminator](https://scontent-ams2-1.xx.fbcdn.net/v/t39.30808-6/277566413_369133498558681_7312429908945278869_n.png?_nc_cat=108&ccb=1-7&_nc_sid=e3f864&_nc_ohc=-HGg91wVyroAX-j4LpE&_nc_ht=scontent-ams2-1.xx&oh=00_AT8284yIQkTdrmByJJ3xRyu3buR-RqVdeWmH0ZBcTzy8tw&oe=634A4458 "The Migator will be back!")

A package that will allow developers to interactively generate schema migrations for a laravel application. 
It takes into account the existing entity/fields based on the available data in the database.

This package will ask the developer interactively for the following:

- [x] model
- [x] table (default: derived from laravel model naming convention)
- [x] fields (repeatedly)
    - [x] name
    - [x] type
        - [x] id
        - [x] uuid
        - [x] type
        - [x] boolean
        - [x] text
        - [x] date
        - [x] datetime
        - [x] json
        - [x] id
        - [x] integer
    - [ ] default value (#11)
    - [ ] index (#12)
    - [ ] foreign keys (#13)
- [ ] relations to other entities (#9)

It will then ask for writing this into a migration file. It creates and writes a new migration file to the default laravel migration path.

## Installation

This package can be installed using composer:

```bash
composer require wearesynetic/laravel-migator --dev
```

## Usage

`php artisan make:migator`

This will start the migator process.

## Roadmap

- [x] Derive table name default from the given model
- [x] Implement validation of preexisting columns / definitions
- [x] Implement CLI usage for 'model'-specific use case (#5)
- [ ] Implement CLI usage for 'other' use case (#6)
- [ ] Implement relation mapping / autocomplete (#9)
- [ ] Optionally specify the stub to be used for the migration (#10)
