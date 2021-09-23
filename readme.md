iLovePDF Api - Php Library
--------------------------

[![Build Status](https://travis-ci.org/ilovepdf/ilovepdf-php.svg?branch=master)](https://travis-ci.org/ilovepdf/ilovepdf-php)
[![Latest Stable Version](https://poser.pugx.org/ilovepdf/ilovepdf-php/version)](https://packagist.org/packages/ilovepdf/ilovepdf-php)
[![Total Downloads](https://poser.pugx.org/ilovepdf/ilovepdf-php/downloads.svg)](https://packagist.org/packages/ilovepdf/ilovepdf-php)
[![License](https://poser.pugx.org/ilovepdf/ilovepdf-php/license)](https://packagist.org/packages/ilovepdf/ilovepdf-php)

A library in php for [iLovePDF Api](https://developer.ilovepdf.com)

You can sign up for a iLovePDF account at https://developer.ilovepdf.com

Develop and automate PDF processing tasks like Compress PDF, Merge PDF, Split PDF, convert Office to PDF, PDF to JPG, Images to PDF, add Page Numbers, Rotate PDF, Unlock PDF, stamp a Watermark and Repair PDF. Each one with several settings to get your desired results.

## Requirements

PHP 7.3 and later.

## Install

### Using composer

You can install the library via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require ilovepdf/ilovepdf-php
```

To use the library, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```


### Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/ilovepdf/ilovepdf-php/releases). Then, to use the library, include the `init.php` file.

```php
require_once('/path/to/ilovepdf-php/init.php');
```

## Getting Started

Simple usage looks like:

```php
use Ilovepdf\Ilovepdf;

$ilovepdf = new Ilovepdf('project_public_id','project_secret_key');
$myTask = $ilovepdf->newTask('compress');
$file1 = $myTask->addFile('file1.pdf');
$myTask->execute();
$myTask->download();
```

## Samples

See samples folder.

## Documentation

Please see https://developer.ilovepdf.com/docs for up-to-date documentation.