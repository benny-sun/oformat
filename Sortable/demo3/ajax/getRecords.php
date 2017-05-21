<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/18
 * Time: 下午 03:09
 */
require_once '../lib/utility.php';
require_once '../lib/Database.php';

if (! (isset($_GET['start']) && isset($_GET['range']))) {
    echo 'no id set';
    http_response_code(510);
    exit();
}

$start = $_GET['start'];

$range = $_GET['range'];

$sql = 'SELECT * FROM demo ORDER BY ord LIMIT '.$start.','.$range;

$db = new Database();

$rows = $db->getRows($sql);

$db->Disconnect();

if (sizeof($rows) === 0) { header("HTTP/1.1 999 EOF"); exit(); }

foreach ($rows as $key => $row) {
    echo '<div data-id="',$row['id'],'" class="list-group-item">';
    echo '    <span class="badge">',$row['id'],'</span>';
    echo '    <span class="glyphicon glyphicon-move" aria-hidden="true"></span>';
    echo '    &nbsp;&nbsp;&nbsp;&nbsp;',$row['data'];
    echo '</div>';
}