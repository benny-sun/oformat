# Thumbnails Generating [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## Usage
Initialize
```php
require 'Image.php';
$image = new Image($pic)
```
Resize
```php
$image->resize($width, $height)
```
Ratio resize
```php
$image->ratio_resize($width, $height)
```
Set output directory
```php
$image->setDir($folder)
```
Save file
```php
$image->save($output_name)
```

## Basic Example
```php
require 'Image.php';
$image = new Image('pic.jpg');
$image->resize($width, $height)
      ->setDir($folder)
      ->save($output_name);
```

## Get error message
```php
try {
    $image = new Image('pic.jpg');
    $image->resize($width, $height)
          ->setDir($folder)
          ->save($output_name);
} catch (Exception $e) {
    $e->getMessage();   //  <------ this line
}

```

