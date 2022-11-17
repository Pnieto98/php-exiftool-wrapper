# Php-Exiftool

## Introduction

PHP wrapper around the `exiftool` command

## Table of contents:
- [Installation](#installation)
- [How to use](#how-to-use)
- [Specials types](#specials-types)
- [Extra](#extra)
- [License](#license)

## Installation

### 1 - Install mediainfo
You should install [exiftool](https://exiftool.org/):

#### On linux:

```bash
$ sudo apt-get install exiftool
```

#### On Mac:

```bash
$ brew install exiftool
```

### 2 - Integration in your php project

To use this library install it through [Composer](https://getcomposer.org/), run:

```bash
$ composer require mhor/php-mediainfo
```

## How to use

### Retrieve media information container
```php
<?php
//...
$exif = new \ExiftoolWrapper\Exiftool();
//...
$mediaInfo = new Exiftool();
$mediaInfoContainer = $mediaInfo->getInfo('image.jpg');
//...
```
