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

    if (!$isError) {
        if (!is_dir($outputDir)) {
            mkdir($outputDir);
        }
        if (move_uploaded_file($file_tmp, $outputDir.$file_name)){

            Libreoffice::convertToPDF($outputDir, $outputDir.$file_name);
            GhostScript::convertToJPG($outputDir, 100, $outputDir.$pure_fname.'.pdf');

/*=============別人的===================*/
//            $pdf = new PDF2Image($outputDir.'.pdf');
//            foreach (range(1, $pdf->getNumberOfPages()) as $pageNumber) {
//                $pdf->setPage($pageNumber)
//                    ->setResolution(72)
//                    ->saveImage('files/page'.$pageNumber.'.jpg');
//            }
/*================================*/

            echo '<p>convert completed</p>';
//            echo '<img src="'.$outputDir.'.jpg" style="width: 20vh; height: auto;">';

        }
    } else {
        echo 'ERROR';
    }
}