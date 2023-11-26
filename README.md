<h1 align="center">iFrost Plain Data Transformer</h1>

<p align="center">
    <strong>A PHP library for transforming various data to specific format.</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php->=7.4-blue?colorB=%238892BF" alt="Code Coverage">  
    <img src="https://img.shields.io/badge/coverage-37%25-brightgreen" alt="Code Coverage">   
    <img src="https://img.shields.io/badge/release-v1.0.0-blue" alt="Release Version">   
    <img src="https://img.shields.io/badge/license-MIT-blue?style=flat-square&colorB=darkcyan" alt="Read License">
</p>

## Installation

```
composer require grzegorz-jamroz/plain-data-transformer
```

## Usage

### TransformNumeric

#### Method `toInt`
Parse numeric value (`string`, `float` and `int`) to `integer`. It is possible to specify decimal precision using second argument `precision`  

#### Method `toFloat`
Parse `int` value to `float`. It is possible to specify decimal precision using second argument `precision`  

