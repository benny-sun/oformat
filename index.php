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
    $url = 'https://www.w3schools.com/images/';
//    $url = 'http://www.example.com/xxx';

    require 'GenerateHTML.php';
    $html = new GenerateHTML($url);
    $html->saveHTML();
//    $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
//    $ch = curl_init($url);
//    curl_setopt($ch, CURLOPT_HEADER, true);
//    curl_setopt($ch, CURLOPT_NOBODY, true);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//    curl_setopt($ch, CURLOPT_TIMEOUT,10);
//    curl_setopt($ch, CURLOPT_USERAGENT, 'User-Agent: curl/7.39.0');
//    $output = curl_exec($ch);
//    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//    curl_close($ch);
//echo $http_code;

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