# Check EXIF Orientation info in JPEG files [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
Modify JPEG files into correct orientation when file upload to web server and display on web browser

## Usage
Basic initialize and rotate the original image.
```php
require 'Rotate.php';
Rotate::Image('photo.jpg')->save();
```
## Customize
Save customize filename and path.
```php
Rotate::Image('photo.jpg')->save('new_name.jpg');
```
## Error Code Return
If function went wrong then return error code below.
```
1 => file not exists
2 => not jpeg file
3 => store path not exists
```
