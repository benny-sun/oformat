<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/18
 * Time: 下午 03:09
 */
require_once '../lib/utility.php';
require_once '../lib/Database.php';

if (! isset($_GET['start'])) {
    echo 'no id set';
    http_response_code(510);
    exit();
}

$start = $_GET['start'];

$db = new Database();

$orig_sort = $db->getRow('SELECT sort FROM sortable WHERE id = 6');

$orig_sort = $orig_sort['sort'];

$orig_sort = getSortPart($orig_sort, $start, 10);

$rows = $db->getRows('SELECT * FROM demo WHERE id IN ( '.$orig_sort.' ) ORDER BY FIELD(id,'.$orig_sort.')');

$db->Disconnect();

if (sizeof($rows) === 0) { http_response_code(510); exit(); }

foreach ($rows as $key => $row) {
    echo '<div data-id="',$row['id'],'" class="list-group-item">';
    echo '    <span class="badge">',$row['id'],'</span>';
    echo '    <span class="glyphicon glyphicon-move" aria-hidden="true"></span>';
    echo '    &nbsp;&nbsp;&nbsp;&nbsp;',$row['data'];
    echo '</div>';
}