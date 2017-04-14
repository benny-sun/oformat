<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2017/4/11
 * Time: 下午 01:38
 */

namespace GenerateHTML;


class GenerateHTML
{
    protected $url = '';

    protected $dir = '';

    protected $file_name = 'default.html';

    protected $log;

    protected $isError = true;

    public function __construct($url)
    {

        $this->url = $url;

        switch ($this->getHttpCode($url)){
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
        }

        $this->isError = false;

    }

    private function getHttpCode($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT,10);
        $output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode;
    }

    private function setErrorLog($log)
    {
        $this->log = $log;
        $time = date("Y-m-d H:i:s");
        $txt = sprintf("[%s] URL:%s  Status: %s\n", $time, $this->url, $log);
        file_put_contents('log.txt', $txt, FILE_APPEND);
    }

    public function createFolder($dir)
    {

        $parts = explode('/', $dir);
        foreach($parts as $part)
            if(!is_dir($dir .= "/$part")) mkdir($dir, 0700);

        $this->dir = $dir;

        return $this;

    }

    public function setFileName($file_name)
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function saveHTML()
    {

        if ($this->isError) return false;

        $content = file_get_contents($this->url);

        file_put_contents("$this->dir/$this->file_name", $content);

    }

    public function savePHPFile()
    {
        ob_start();

        include "$this->url";

        $content = ob_get_contents();

        $fp = fopen($this->file_name,'w');

        fwrite($fp, $content);

        fclose($fp);
    }
}