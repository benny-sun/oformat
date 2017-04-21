<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/21
 * Time: 下午 05:03
 */

if (isset($_FILES)) {
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';

    if (move_uploaded_file($_FILES['croppedImage']['tmp_name'], "dist/{$_FILES['croppedImage']['name']}")){

        echo 'file uploaded!';

    }
}


