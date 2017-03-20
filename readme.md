iLovePDF Api - Php Library
--------------------------

[![Build Status](https://travis-ci.org/ilovepdf/ilovepdf-php.svg?branch=master)](https://travis-ci.org/ilovepdf/ilovepdf-php)

A library in php for [iLovePDF Api] (https://developer.ilovepdf.com)

You can sign up for a iLovePDF account at https://developer.ilovepdf.com


## Requirements

PHP 5.6 and later.

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
$ilovepdf = new Ilovepdf('project_public_id','project_secret_key');
$myTask = $ilovepdf->newTask('compress');
$file1 = $myTask->addFile('file1.pdf');
$myTask->execute();
$myTask->download();
```

## Documentation

Please see https://developer.ilovepdf.com/docs for up-to-date documentation.