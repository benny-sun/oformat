# Detecting invalid browser [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
Using setting config to protect too old version browser from client side

## Usage
Setting in ```config.json```
```
{

  "IE": {
    "PC": "8",
    "Mobile": "8",
    "FewPC": [],
    "FewMob": []
  },

  "Edge": {
    "PC": "8",
    "Mobile": "8",
    "FewPC": [],
    "FewMob": []
  }
  ...
  ...
  ...
}
```

Initialize
```php
require 'Web.php';
$info = Web::detect()->get();
```

## Error Code Return
```
0 => correct
1 => whole browser not allow
2 => specific version not allow
3 => version too old
```
