<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/13
 * Time: 下午 04:47
 */

require_once 'lib/Database.php';

$db = new Database();

$newId = 14;

$sql = "
        UPDATE sortable 
        set sort = JSON_MERGE(sort, '{\"x\": 0, \"attr\": \"".$newId."\"}')
        WHERE id=5
    ";

$db->update($sql, [$newId]);

$db->Disconnect();