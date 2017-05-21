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
}

/* 取得排序片段 */
function getSortPart($json, $start, $range) {
    $x = json_decode($json);
    $y = array_slice($x, $start, $range);
    $z = implode(',', $y);
    if ($z === '') { $z = 0; }
    return $z;
}


function get_json_combine($orig_json, $new_json) {
    $orig_arr = json_decode($orig_json);
    $new_arr = json_decode($new_json);
    $result = get_array_combine($orig_arr, $new_arr);
    return json_encode($result);
}

function get_array_combine($orig_arr=[], $new_arr) {
    foreach ($new_arr as $key => $value) {
        $orig_arr[$key] = $value;
    }
    return $orig_arr;
}