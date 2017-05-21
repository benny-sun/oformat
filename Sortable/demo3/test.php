<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/5/19
 * Time: 上午 09:42
 */

require_once 'lib/Database.php';
require_once 'lib/utility.php';
$z = [1,2,3,4,5,6,7,8,9,10];
$y = [6,5,2];
$result = get_array_combine($z, $y);
pretty($z);
pretty($y);
pretty(json_encode($result));

