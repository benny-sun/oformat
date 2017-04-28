# Grab static html from website using cUrl [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## Usage
Initialize
```php
require 'HTML.php';
$html = new HTML('http://example.com/')
```
Set output directory
```php
$html->setDir('2017')
```
Customize filename
```php
$html->setFileName('fname.html')
```
Save file
```php
$html->save()
```

## Basic Example
```php
require 'HTML.php';
$html->setDir('2017')->setFileName('fname.html')->save();
```

## Batch
Basic
```php
$urls = [
    'http://example.com?id=1',
    'http://example.com?id=2',
    'http://example.com?id=3',
];
$html = new HTML($urls);
```
Customize each filename
```php
$urls = [
    'http://example.com?id=1',
    'http://example.com?id=2',
    'http://example.com?id=3',
];
$fname = [
    'name1',
    'name2',
    'name3',
];
$array = [$urls, $fname];

$html = new HTML($array);
```
