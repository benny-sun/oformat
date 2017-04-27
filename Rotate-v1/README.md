# Check EXIF Orientation info in jpeg files

## Usage
Basic initialize and rotate the original image.
```php
require 'Rotate.php';
Rotate::Image('photo.jpg')->save();
```
## Customize
Save with customize filename.
```php
Rotate::Image('photo.jpg')->save('new_name.jpg');
```
## Error Code
If function went wrong then return error code below.
```
1 => file not exists
2 => not jpeg file
3 => file path not exists
```
