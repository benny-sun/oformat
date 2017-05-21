<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/18
 * Time: 下午 02:42
 */
require_once '../lib/utility.php';
require_once '../lib/Database.php';

if (isset($_POST['sort'])) {

    $sort = $_POST['sort'];

    $sort = json_decode($sort);

    $sql = '';
    $ord = 1;
    foreach ($sort as $id) {
        $sql .= "UPDATE demo SET ord = $ord WHERE id = $id;";
        $ord++;
    }

    pretty($sql);

    $db = new Database();

    $db->update($sql);

    $db->Disconnect();

}