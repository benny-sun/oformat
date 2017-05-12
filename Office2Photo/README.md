# Convert office file to JPEG in each slide [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
Using LibreOffice and GhostScript

## Usage
Import class file
```php
require 'Libreoffice.php';
require 'GhostScript.php';
```
## Convert office file to PDF
Save customize filename and path.
```php
/*
 * 標題：Office轉PDF
 * 說明：將Office檔案轉存成PDF格式
 * 時間：2017/4/20 Hao

 * @outputDir輸出的資料夾 (需先創建好)
 * @inputFile要轉成圖片的PDF檔案
 */
Libreoffice::convertToPDF($outputDir, $inputFile);
```
## Convert PDF to JPEG
Convert with each PDF slide and save in each JPEG file
```php
/*
 * 標題：PDF轉JPG
 * 說明：將PDF檔案內頁全數轉為JPG，一頁對應一個JPG檔
 * 時間：2017/4/20 Hao
 * 
 * @outputDir輸出的資料夾 (需先創建好)
 * @dpi圖片解析度
 * @quality圖片品質 (預設75，最高品質100)
 * @inputFile要轉成圖片的PDF檔案
 */
GhostScript::convertToJPG($outputDir, $dpi, 75, $inputFile);
```


## 環境設定
安裝 Libreoffice 完整版
```
# apt-get install libreoffice
```

安裝 java 套件
```
# apt-get update
# apt-get install default-jre
```

### 解決中文字亂碼
- step 1.
  - 回到 ubuntu 進入 `/usr/share/fonts/`
  - 創建新資料夾 `winfonts` (避免和ubuntu字型混淆)
  - 指令碼 ```# mkdir /usr/share/fonts/winfonts```
- step 2.
  - 進入 windows 系統的資料夾`C:\Windows\Fonts`
  - 將所有字體拷貝到ubuntu資料夾`/usr/share/fonts/winfonts`
- step 3.
  - 進入ubuntu系統
  - 修改植入的字體訪問權限
  - ```# cd /usr/share/fonts/winfonts```
  - ```# chmod 744 *```
- step 4.
  - 產生核心字體訊息
  - ```# apt-get install xfonts-utils```
  - ```# mkfontscale```
  - ```# mkfontdir```
  - ```# fc-cache -f -v```
