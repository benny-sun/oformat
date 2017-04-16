<?php
/**
 * Created by PhpStorm.
 * User: Haogood
 * Date: 2017/4/11
 * Time: 下午 01:38
 */

//namespace HTML;

class HTML
{
    protected $url = '';

    protected $dir = '';

    protected $file_name = 'default';

    protected $log;

    protected $isError = true;

    public function __construct($url)
    {
        $this->url = $url;

        $http_code = $this->getHttpCode($url);

        if ($this->checkUrlCorrect($http_code)) $this->isError = false;
    }

    private function checkUrlCorrect($http_code)
    {
        switch ($http_code){
            case 0:
                $this->setErrorLog('net::ERR_NAME_NOT_RESOLVED');
                return false;
            case 403:
                $this->setErrorLog('403 Forbidden');
                return false;
            case 404:
                $this->setErrorLog('404 Not Found');
                return false;
            case 500:
                $this->setErrorLog('500 Internal Server Error');
                return false;
            default:
                return true;
        }
    }

    private function getHttpCode($url)
    {
        $ch = curl_init($url);
        $options = array(
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        );
        curl_setopt_array($ch, $options);
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code;
    }

    private function setErrorLog($log)
    {
        $this->log = $log;
        $time = date("Y-m-d H:i:s");
        $txt = sprintf("[%s] URL:%s  Status: %s\n", $time, $this->url, $log);
        file_put_contents('log.txt', $txt, FILE_APPEND);
    }

    public function setDir($dir)
    {
        $this->dir = '';
        $parts = explode('/', $dir);
        foreach($parts as $part){
            $this->dir .= "$part/";
            if(!is_dir($this->dir)) mkdir($this->dir);
        }

        return $this;

    }

    public function setFileName($file_name)
    {
        $this->file_name = $file_name . '.html';

        return $this;
    }

    public function saveHTML()
    {

//        if ($this->isError) throw new Exception('Wrong URL.');
        if ($this->isError) return;

        $content = file_get_contents($this->url);

        $path = $this->dir . $this->file_name;

        file_put_contents($path, $content);

    }

    public function __destruct()
    {
//        echo __FUNCTION__;
    }

}