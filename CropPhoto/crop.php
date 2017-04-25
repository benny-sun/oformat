<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/21
 * Time: 下午 05:03
 */

//if (isset($_FILES)) {
//    echo '<pre>';
//    print_r($_FILES);
//    echo '</pre>';
//
//    if (move_uploaded_file($_FILES['croppedImage']['tmp_name'], "pic/{$_FILES['croppedImage']['name']}")){
//
//        echo 'file uploaded!';
//
//    }
//}

if (isset($_POST['obj']) && isset($_POST['fname'])) {

    echo '<pre>';
    print_r($_POST['obj']);
    echo '</pre>';

    $array = array();
    $array = $_POST['obj'];

    $fname = $_POST['fname'];

    $img1 = imagecreatefrompng('demo.png');
    $new_image = imagecreatetruecolor($_POST['obj']['width'], $_POST['obj']['height']);
    $rotate = imagerotate($img1, $_POST['obj']['rotate']*(-1), 0);
    imagecopyresampled($new_image, $rotate, 0, 0, $_POST['obj']['x'], $_POST['obj']['y'], $_POST['obj']['width'], $_POST['obj']['height'], $_POST['obj']['width'], $_POST['obj']['height']);
//    $img2 = imagecrop($img1, $array);

    if ($img2 !== FALSE) {
        imagepng($new_image, $fname);
    }
}


