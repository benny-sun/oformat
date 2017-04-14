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
//    $url = 'https://www.w3schools.com/images/';
    $url = 'http://www.example.com';

    require 'GenerateHTML.php';
    use GenerateHTML\GenerateHTML;
    $html = new GenerateHTML($url);
    $html->createFolder('test/haha')->setFileName('abc')->saveHTML();

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