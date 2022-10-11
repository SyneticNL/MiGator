# Laravel Migator

A package that will allow developers to interactively generate schema migrations for a laravel application.

This package will ask the developer interactively for the following:

- [ ] model
- [x] table (default: derived from laravel model naming convention)
- [x] fields (repeatedly)
    - [x] name 
    - [x] type
        - [x] boolean
        - [x] text
        - [ ] date
        - [ ] datetime
        - [ ] json
        - [ ] id
        - [ ] integer
    - [ ] default value
    - [ ] index
- [ ] relations to other entities

It will then ask for writing this into a migration file.

## Installation

This package can be installed using composer:

```bash
composer require synetic/migator --dev
```

## Usage

`php artisan make:migator`

This will start the migator process.

## Roadmap

- [ ] Derive table name default from the given model
- [ ] Implement validation of preexisting columns / definitions
- [ ] Implement CLI usage for 'model'-specific use case
- [ ] Implement CLI usage for 'other' use case
- [ ] Implement relation mapping / autocomplete