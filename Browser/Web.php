<?php

/**
 * Created by PhpStorm.
 * User: Hao
 * Date: 2017/5/4
 * Time: 下午 01:33
 */

require 'lib/Browser.php';
require 'lib/Mobile_Detect.php';

class Web
{
    
    private $browser, $version, $errCode;

    function __construct()
    {
        $detect = new Mobile_Detect;

        $browser = new Browser();
        
        $this->browser = $browser->getBrowser();

        $this->version = $browser->getVersion();

        $json = file_get_contents('config.json');

        $obj = json_decode($json);

        $this->errCode = 0;

        // error code
        // 1 => browser not allow
        // 2 => specific
        // 3 => version too old
        if ($detect->isMobile()) {

            switch ($browser->getBrowser()) {
                case Browser::BROWSER_CHROME:
                    if ((!isset($obj->Chrome)) || (!$obj->Chrome->Mobile)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Chrome->FewMob)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Chrome->Mobile, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_IE:
                    if ((!isset($obj->Chrome)) || (!$obj->IE->Mobile)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->IE->FewMob)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->IE->Mobile, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_EDGE:
                    if ((!isset($obj->Chrome)) || (!$obj->Edge->Mobile)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Edge->FewMob)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Edge->Mobile, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_FIREFOX:
                    if ((!isset($obj->Chrome)) || (!$obj->Firefox->Mobile)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Firefox->FewMob)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Firefox->Mobile, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_SAFARI:
                    if ((!isset($obj->Chrome)) || (!$obj->Safari->Mobile)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Safari->FewMob)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Safari->Mobile, '<')) {
                        $this->errCode = 3;
                    }
                    break;
            }

        } else {

            switch ($browser->getBrowser()) {
                case Browser::BROWSER_CHROME:
                    if ((!isset($obj->Chrome)) || (!$obj->Chrome->PC)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Chrome->FewPC)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Chrome->PC, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_IE:
                    if ((!isset($obj->IE)) || (!$obj->IE->PC)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->IE->FewPC)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->IE->PC, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_EDGE:
                    if ((!isset($obj->Edge)) || (!$obj->Edge->PC)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Edge->FewPC)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Edge->PC, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_FIREFOX:
                    if ((!isset($obj->Firefox)) || (!$obj->Firefox->PC)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Firefox->FewPC)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Firefox->PC, '<')) {
                        $this->errCode = 3;
                    }
                    break;
                case Browser::BROWSER_SAFARI:
                    if ((!isset($obj->Safari)) || (!$obj->Safari->PC)) {
                        $this->errCode = 1;
                    } else if (in_array($browser->getVersion(), $obj->Safari->FewPC)) {
                        $this->errCode = 2;
                    } else if (version_compare($browser->getVersion(), $obj->Safari->PC, '<')) {
                        $this->errCode = 3;
                    }
                    break;
            }
        }

    }

    public static function detect()
    {
        return new self();
    }

    public function get()
    {
        $info = [
            'browser'=> $this->browser,
            'version'=> $this->version,
            'error' => $this->errCode
        ];
        return $info;
    }

}