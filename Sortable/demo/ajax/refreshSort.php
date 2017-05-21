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

    $id = $_POST['id'];

    $db = new Database();

    $orig_sort = $db->getRow('SELECT sort FROM sortable WHERE id = ?', [$id]);

    $new_sort = get_json_combine($orig_sort['sort'], $sort);

    $db->update("UPDATE sortable SET sort = ? WHERE id = ?", [$new_sort, $id]);

    $db->Disconnect();

}