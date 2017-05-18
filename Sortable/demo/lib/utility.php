<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/18
 * Time: 下午 02:25
 */

function createFakeData($num = 60) {
    $db = new Database();

    $sql = 'INSERT INTO demo (data) VALUE ( ? )';

    for ($i = 1; $i <= $num; $i++) {
        $db->insert($sql, ['item_'.$i]);
    }

    $db->Disconnect();
}

function pretty($str) {
    echo '<pre>';
    print_r($str);
    echo '</pre>';
    die();
}