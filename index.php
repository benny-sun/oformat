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
        'http://www.example.com',
        'http://www.example.com',
        'http://www.example.com/xxx',
        'https://www.w3schools.com/',
    );

    require 'HTML.php';
    foreach ($arr as $key => $row){
        $html = new HTML($row);
        $html->setDir('x/abc')->setFileName('a'.$key)->saveHTML();
    }

    echo '<pre>';
    echo file_get_contents( "log.txt" );
    echo '</pre>';





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