# 拖放排序搭配Load more 範例[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## 相關套件
- CSS
  - bootstrap.min.css 3.3.1
- JS
  - Sortable.js
  - jquery.min.js
  
## 拖放排序
效果範例
```html
<html>
...
<body>
  <div id="listWithHandle" class="list-group">
      <div data-id="1" class="list-group-item">
          <span class="badge">14</span>
          <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
          Drag me by the handle
      </div>
      <div data-id="2" class="list-group-item">
          <span class="badge">2</span>
          <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
          You can also select text
      </div>
      <div data-id="3" class="list-group-item">
          <span class="badge">1</span>
          <span class="glyphicon glyphicon-move" aria-hidden="true"></span>
          Best of both worlds!
      </div>
  </div>
  <script>
    Sortable.create(listWithHandle, {
        handle: '.glyphicon-move',
        animation: 150
    });
  </script>
</body>
</html>
```
儲存範例
```js
// javascript
var demo = Sortable.create(listWithHandle, {
    handle: '.glyphicon-move',
    animation: 150,
    onUpdate: function () {
        $.ajax({
            url: "後端處理排序的網址",
            method: "POST",
            data: { sort: JSON.stringify(demo.toArray())},
            success: function () {
                console.log("order change");
            }
        });
    }
});
```
```php
// refreshSort.php
if (isset($_POST['sort'])) {
    // 處理排序存入db
}
```


## 動態載入 (Frontend)
偵測卷軸滾動到最底
```js
$(window).scroll(function() {
    if(Math.ceil(window.pageYOffset)+window.innerHeight >= document.body.scrollHeight) {
        // 到底之後做的事
    }
});
```
卷軸到底後，向後端請求資料
```js
start = 1;    // 起始值
range = 10;   // 每次取得的筆數範圍
$.ajax({
    url: "接收資料的後台網址",
    method: "GET",
    beforeSend: function () {
        // 顯示loading icon
    },
    success: function (data) {
        // 成功請求後台資料
        // append回傳的版面
    },
    error: function (jqXHR) {
        // 錯誤處理
    }
});
```

## 動態載入 (Backend)
資料庫欄位 (範例)
```mysql
+-------------+----------+------+-----+---------+----------------+
| Field       | Type     | Null | Key | Default | Extra          |
+-------------+----------+------+-----+---------+----------------+
| id          | int(11)  | NO   | PRI |         | auto_increment |
| data        | char(35) | YES  |     | NULL    |                |
| ord         | int(11)  | YES  |     | NULL    |                |
+-------------+----------+------+-----+---------+----------------+
```
取得資料行 (getRecords.php)
```php
require_once '../lib/Database.php';

$start = $_GET('start');  // 取得ajax過來的起始值

$range = $_GET('range');  // 取得ajax過來的筆數範圍

$db = new Database();

$rows = $db->getRows("SELECT * FROM table LIMIT $start, $range");

$db->Disconnect();

// 輸出layout
foreach ($rows as $key => $row) {
    echo '<div data-id="',$row['id'],'" class="list-group-item">';
    echo '    <span class="badge">',$row['id'],'</span>';
    echo '    <span class="glyphicon glyphicon-move" aria-hidden="true"></span>';
    echo '    &nbsp;&nbsp;&nbsp;&nbsp;',$row['data'];
    echo '</div>';
}
```

