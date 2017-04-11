<?php
require 'Libreoffice.php';
require 'GhostScript.php';
//require 'PDF2Image.php';

use Libreoffice\Libreoffice;
use GhostScript\GhostScript;
//use PDF2Image\PDF2Image;

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $pure_fname = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
    $file_tmp = $file['tmp_name'];
    $isError = $file['error'];
    $outputDir  = 'files/';
    $imgDir = 'img/';

    if (!$isError) {

        if (!is_dir($outputDir)) {
            mkdir($outputDir);
        }

        if (!is_dir($imgDir)){
            mkdir($imgDir);
        }

        if (move_uploaded_file($file_tmp, $outputDir.$file_name)){

            $upload_time = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];

            Libreoffice::convertToPDF($outputDir, $outputDir.$file_name);
            GhostScript::convertToJPG($imgDir, 72, 75, $outputDir.$pure_fname.'.pdf');

            $format_time = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'] - $upload_time;
            echo '<p>轉換完成</p>';
            echo '<p>總耗時 ',round($upload_time + $format_time,4),'秒</p>';
            echo '<p>上傳耗時 ',round($upload_time,4),' 秒</p>';
            echo '<p>轉換耗時 ',round($format_time,4),' 秒</p>';
        }
    } else {
        echo 'ERROR';
    }
}