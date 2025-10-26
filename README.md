<h1 align="center">iFrost Plain Data Transformer</h1>

<p align="center">
    <strong>A PHP library for transforming various data to specific format.</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php->=8.4-blue?colorB=%238892BF" alt="Code Coverage">  
    <img src="https://img.shields.io/badge/coverage-100%25 files|100%25 lines-brightgreen" alt="Code Coverage">   
    <img src="https://img.shields.io/badge/release-v1.1.2-blue" alt="Release Version">   
    <img src="https://img.shields.io/badge/license-MIT-blue?style=flat-square&colorB=darkcyan" alt="Read License">
</p>

# Installation

```
composer require grzegorz-jamroz/plain-data-transformer
```

---

# Development with Docker

### Build and run the containers:
```shell
docker compose up -d
```

### Copy vendor folder from container to host

```shell
docker compose cp app:/app/vendor ./vendor
```

### Run static analysis

```shell
docker compose exec app bin/fix
```

### Run tests

```shell
docker compose exec app bin/test
```

### Run coverage report

1. [Enable xdebug](#enable-xdebug)
2. Run:
```shell
docker compose exec app bin/coverage
```

Run single test file:

```shell
docker compose exec app vendor/bin/phpunit --filter <testMethodName> <path/to/TestFile.php>
docker compose exec app vendor/bin/phpunit --filter testShouldReturnExpectedFloat tests/Unit/TransformNumeric/ToFloatTest.php
```

### Enable xdebug

```shell
docker compose exec app xdebug on
```

### Disable xdebug

```shell
docker compose exec app xdebug off
```
