<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/11
 * Time: 下午 01:52
 */

require_once 'lib/Database.php';

if (isset($_POST['postData'])) {

    $sort = array();

    parse_str($_POST['postData'], $sort);

    $str = implode(',', $sort['item']);

    $db = new Database();

    $db->update("UPDATE sortable SET sort = ? WHERE id = 1", [$str]);

    $db->Disconnect();
} elseif (isset($_POST['sort'])) {

    $sort = $_POST['sort'];

    $db = new Database();

    $db->update("UPDATE sortable SET sort = ? WHERE id = 2", [$sort]);

    $db->Disconnect();

} elseif (isset($_POST['v2'])) {

    $sort = $_POST['v2'];

    $db = new Database();

    $db->update("UPDATE sortable SET sort = ? WHERE id = 3", [$sort]);

    $db->Disconnect();

} elseif (isset($_POST['v3'])) {

    $sort = $_POST['v3'];

    $nextX = $_POST['nextX'];

    echo $nextX;

    $db = new Database();

    $db->update("UPDATE sortable SET sort = ?, next_x = ? WHERE id = 4", [$sort, $nextX]);

    $db->Disconnect();

}