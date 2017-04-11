<html>
    <head>
        <title>PDF converter</title>
    </head>
    <body>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit" value="upload">
        </form>
    <?php
//    echo 'time() = ',microtime(true);
//    echo '<br>';
//    echo '$_SERVER[\'REQUEST_TIME\'] = ',$_SERVER['REQUEST_TIME_FLOAT'];
//    echo '<br>';
//    sleep(2);
//    echo '睡2秒';
//    echo '<br>';
//    echo 'time() = ',microtime(true);
//    echo '<br>';
//    echo '$_SERVER[\'REQUEST_TIME\'] = ',$_SERVER['REQUEST_TIME_FLOAT'];
//    echo '<br>';
//    echo '跑', microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'] ,'秒'
    ?>
    </body>
</html>
<?php

//引入Class
require 'GenerateHTML.php';
use GenerateHTML\GenerateHTML;

//讀取要轉換的URL內容
$html = new GenerateHTML('https://www.yam.com/');

//設定路徑檔名並儲存
$html->setFileName('abc.html')->saveHTML();

?>