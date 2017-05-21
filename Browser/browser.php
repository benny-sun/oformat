<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/28
 * Time: 下午 04:23
 */

require 'lib/Browser.php';

require 'lib/Mobile_Detect.php';

$detect = new Mobile_Detect;

$browser = new Browser();

$json = file_get_contents('config.json');

$obj = json_decode($json);

$errCode = 0;

// error code
// 1 => browser not allow
// 2 => specific
// 3 => version too old
if ($detect->isMobile()) {

    switch ($browser->getBrowser()) {
        case Browser::BROWSER_CHROME:
            if (in_array($browser->getVersion(), $obj->Chrome->FewMob)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->Chrome->Mobile, '<')) {
                $errCode = 3;
            }
            break;
        case Browser::BROWSER_IE:

            if ((!isset($obj->IE)) || ($obj->IE->Mobile)) { $errCode = 1; break; }

            if (in_array($browser->getVersion(), $obj->IE->FewMob)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->IE->Mobile, '<')) {
                $errCode = 3;
            }
            break;
        case Browser::BROWSER_FIREFOX:
            if (in_array($browser->getVersion(), $obj->Firefox->FewMob)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->Firefox->Mobile, '<')) {
                $errCode = 3;
            }
            break;
        case Browser::BROWSER_SAFARI:
            if (in_array($browser->getVersion(), $obj->Safari->FewMob)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->Safari->Mobile, '<')) {
                $errCode = 3;
            }
            break;
    }

} else {

    switch ($browser->getBrowser()) {
        case Browser::BROWSER_CHROME:
            if ((!isset($obj->Chrome)) || (!$obj->Chrome->PC)) {
                $errCode = 1;
            } else if (in_array($browser->getVersion(), $obj->Chrome->FewPC)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->Chrome->PC, '<')) {
                $errCode = 3;
            }
            break;
        case Browser::BROWSER_IE:
            if ((!isset($obj->IE)) || (!$obj->IE->PC)) {
                $errCode = 1;
            } else if (in_array($browser->getVersion(), $obj->IE->FewPC)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->IE->PC, '<')) {
                $errCode = 3;
            }
            break;
        case Browser::BROWSER_FIREFOX:
            if ((!isset($obj->Firefox)) || (!$obj->Firefox->PC)) {
                $errCode = 1;
            } else if (in_array($browser->getVersion(), $obj->Firefox->FewPC)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->Firefox->PC, '<')) {
                $errCode = 3;
            }
            break;
        case Browser::BROWSER_SAFARI:
            if ((!isset($obj->Safari)) || (!$obj->Safari->PC)) {
                $errCode = 1;
            } else if (in_array($browser->getVersion(), $obj->Safari->FewPC)) {
                $errCode = 2;
            } else if (version_compare($browser->getVersion(), $obj->Safari->PC, '<')) {
                $errCode = 3;
            }
            break;
    }

}

$info = [
    'browser'=> $browser->getBrowser(),
    'version'=> $browser->getVersion(),
    'error' => $errCode
];
return $info;