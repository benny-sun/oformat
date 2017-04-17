<html>
    <head>
        <meta charset="UTF-8" />
        <title>PDF converter</title>
    </head>
    <body>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <input type="submit" value="upload">
        </form>
    <?php
    $arr = array(
        'https://www.w3schools.com/images/',
        'http://www.example.com?k=1',
        'http://www.example.com?k=2',
        'https://www.google.com.tw',
        'http://www.example.com/xxx',
        'https://www.w3schools.com/',
    );

    require 'HTML.php';
    $html = new HTML('https://www.w3schools.com/images/');
    $html->save();
//    $html->setDir('r/one')->save();
//    echo '<pre>';
//    print_r(HTML::getHttpCode2($arr));
//    echo '</pre>';

//    foreach ($arr as $key => $row){
//        echo HTML::getHttpCode($row), '<br>';
//        $html = new HTML($row);
//        $html->setDir('x/abc')->setFileName('a'.$key)->saveHTML();
//    }

//    echo '<pre>';
//    echo file_get_contents( "log.txt" );
//    echo '</pre>';





//    print_r(get_headers($url, 1));

//    $dir    = '.';
//    $files1 = scandir($dir);
//    $files2 = scandir($dir, 1);
//    foreach ($files1 as $row){
//        echo $row, '<br>';
//    }
    ?>
    </body>
</html>