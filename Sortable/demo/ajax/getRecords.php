<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/18
 * Time: 下午 03:09
 */

require_once '../lib/Database.php';
if (! isset($_GET['last_id'])) {
    echo 'no id set';
    http_response_code(510);
    exit();
}

$id = $_GET['last_id'];

$db = new Database();

$rows = $db->getRows("SELECT * FROM demo WHERE id > ? LIMIT 10", [$id]);

$db->Disconnect();

if (sizeof($rows) === 0) { http_response_code(510); exit(); }

foreach ($rows as $key => $row) {
    echo '<div data-id="',$row['id'],'" class="list-group-item">';
    echo '    <span class="badge">',$row['id'],'</span>';
    echo '    <span class="glyphicon glyphicon-move" aria-hidden="true"></span>';
    echo '    &nbsp;&nbsp;&nbsp;&nbsp;',$row['data'];
    echo '</div>';
}