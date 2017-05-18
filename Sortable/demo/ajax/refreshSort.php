<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/18
 * Time: 下午 02:42
 */

require_once '../lib/Database.php';

if (isset($_POST['sort'])) {

    $sort = $_POST['sort'];

    $id = $_POST['id'];

    $db = new Database();

    $db->update("UPDATE sortable SET sort = ? WHERE id = ?", [$sort, $id]);

    $db->Disconnect();

}