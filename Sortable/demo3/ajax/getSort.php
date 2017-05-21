<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/18
 * Time: 下午 02:36
 */

require_once '../lib/Database.php';


if (! isset($_GET['id'])) {
    echo 'no id set';
    exit();
}

$id = $_GET['id'];

$db = new Database();

$row = $db->getRow("SELECT sort FROM sortable WHERE id = ?", [$id]);

$db->Disconnect();

echo $row['sort'];
