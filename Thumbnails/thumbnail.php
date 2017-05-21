<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/21
 * Time: 上午 09:43
 */

//header('Content-Type: image/png');

function create_thumbnail($path, $save, $width, $height) {
    $info = getimagesize($path);
    $size = array($info[0], $info[1]);

    if ($info['mime'] == 'image/png') {
        $src = imagecreatefrompng($path);
    } else if ($info['mime'] == 'image/jpeg') {
        $src = imagecreatefromjpeg($path);
    } else if ($info['mime'] == 'image/gif') {
        $src = imagecreatefromgif($path);
    } else {
        return false;
    }

    $thumb = imagecreatetruecolor($width, $height);

    $src_aspect = $size[0] / $size[1];
    $thumb_aspect = $width / $height;

    if ($src_aspect < $thumb_aspect) {
        $scale = $width / $size[0];
        $new_size = array($width, $width / $src_aspect);
        $src_post = array(0, ($size[1] * $scale - $height) / $scale / 2);

    } else if ($src_aspect > $thumb_aspect) {

        $scale = $width / $size[1];
        $new_size = array($height * $src_aspect, $height);
        $src_post = array(($size[0] * $scale - $width) / $scale / 2, 0);

    } else {
        $new_size = array($width, $height);
        $src_post = array(0, 0);
    }
    $new_size[0] = max($new_size[0], 1);
    $new_size[1] = max($new_size[1], 1);

    imagecopyresampled($thumb, $src, 0, 0, 0, 0, $new_size[0], $new_size[1], $size[0], $size[1]);

    if($save === false){
        return imagepng($thumb);
    } else {
        return imagepng($thumb, $save);
    }
}
//=========================================
//print_r(getimagesize('53.jpg'));
//$path = '53.jpg';
//$img = imagecreatefromjpeg($path);   //來源
//$thumb = imagecreatetruecolor(100, 100);

//create_thumbnail($path, 'small.jpg', 100, 100);

//// 這個文件
//$filename = '53.jpg';
//// 設置最大寬高
//$width = 200;
//$height = 100;
//
//// Content type
//header('Content-Type: image/jpeg');
//
//// 獲取新尺寸
//list($width_orig, $height_orig) = getimagesize($filename);
//
//$ratio_orig = $width_orig/$height_orig;
//
//if ($width/$height > $ratio_orig) {
//    $width = $height*$ratio_orig;
//} else {
//    $height = $width/$ratio_orig;
//}
//
//// 重新取樣
//$image_p = imagecreatetruecolor($width, $height);
//$image = imagecreatefromjpeg($filename);
//imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
//
//// 輸出
//imagejpeg($image_p, 'small3.jpg', 100);
//=========================================

///**
// * 初始化
// * @param  string  $pic
// */
//$image = new Image($pic);
//
///**
// * 設定任意寬高(不按比例)
// * @param  int|float  $width
// * @param  int|float  $height
// */
//$image->resize($width, $height)
//
///**
// * 設定寬高(按比例)
// * @param  int|float  $width
// * @param  int|float  $height
// */
//$image->ratio_resize($width, $height)
//
///**
// * 指定輸出資料夾
// * @param  string  $folder
// */
//$image->setDir($folder)
//
///**
// * 存檔
// * @param  string  $output_name
// */
//$image->save($output_name)
//
///**
// * 基本範例
// *
// * @param  int|float  $width
// * @param  int|float  $height
// * @param  string  $folder
// * @param  string  $output_name
// * @return Exception $e
// */
//require 'Image.php';
//$image = new Image('pic.jpg');
//$image->resize($width, $height)
//      ->setDir($folder)
//      ->save($output_name);

/**
 * 取得錯誤回傳值
 */
try {
    $image = new Image('pic.jpg');
    $image->resize($width, $height)
        ->setDir($folder)
        ->save($output_name);
} catch (Exception $e) {
    $e->getMessage();   //  <---------- this line
}