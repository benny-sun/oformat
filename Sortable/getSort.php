<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/11
 * Time: 下午 05:22
 */

require_once 'lib/Database.php';

$id = '';
if (isset($_GET['v1'])) {
    $id = $_GET['v1'];
} elseif (isset($_GET['v2'])) {
    $id = $_GET['v2'];
} elseif (isset($_GET['v3'])) {
    $id = $_GET['v3'];
}

$db = new Database();

$row = $db->getRow("SELECT sort FROM sortable WHERE id = ?", [$id]);

$db->Disconnect();

echo $row['sort'];
