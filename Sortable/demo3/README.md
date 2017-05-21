# 拖放排序搭配Load more 範例[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

## 相關套件
- CSS
  - bootstrap.min.css 3.3.1
- JS
  - Sortable.js
  - jquery.min.js
  
## 拖放排序
範例
```html
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
```
```js
Sortable.create(listWithHandle, {
    handle: '.glyphicon-move',
    animation: 150
});
```

## 動態載入
偵測卷軸滾動到最底
```js
$(window).scroll(function() {
    if(Math.ceil(window.pageYOffset)+window.innerHeight >= document.body.scrollHeight) {
        // 到底之後做的事
    }
});
```

