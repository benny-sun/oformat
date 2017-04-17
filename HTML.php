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

    protected $data, $log;

    protected $http_code, $http_contents;

    protected $file_name = 'default';

    protected $isError = true;

    private $curl_options = array(
        CURLOPT_HEADER => false,
        CURLOPT_NOBODY => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
    );

    public function __construct($url)
    {
        $this->url = $url;
        $this->data = $url;

        if (is_array($url)) {
            $this->getUrlInfoBatch($url);
        } else {
            $this->getUrlInfo($url);
        }
    }
    
    private function getUrlInfo($url)
    {
        $http_code = $this->getHttpCode($url);
        if ($this->checkUrlCorrect($http_code)) $this->isError = false;
    }

    private function getUrlInfoBatch($url_array)
    {
        list($this->http_code, $this->http_contents) = $this->getHttpCodeBatch($url_array);

        $this->checkUrlCorrectBatch($this->http_code);
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

    private function checkUrlCorrectBatch($http_code_arr)
    {
        foreach ($http_code_arr as $key => $value) {
            $this->url = $key;
            switch ($value){
                case 0:
                    $this->setErrorLog('net::ERR_NAME_NOT_RESOLVED');
                    unset($this->http_contents[$key]);
                    break;
                case 403:
                    $this->setErrorLog('403 Forbidden');
                    unset($this->http_contents[$key]);
                    break;
                case 404:
                    $this->setErrorLog('404 Not Found');
                    unset($this->http_contents[$key]);
                    break;
                case 500:
                    $this->setErrorLog('500 Internal Server Error');
                    unset($this->http_contents[$key]);
                    break;
            }
        }
    }

    private function getHttpCode($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, $this->curl_options);
        $output = curl_exec($ch);
        $this->http_contents = $output;
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $http_code;
    }

    private function getHttpCodeBatch($url_arr)
    {
        $mh = curl_multi_init();
        $ch_array = array();
        foreach ($url_arr as $i => $row) {
            $ch_array[$i] = curl_init($row);
            curl_setopt_array($ch_array[$i], $this->curl_options);
            curl_multi_add_handle($mh, $ch_array[$i]);
        }
        
        $running = NULL;
        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $res = array();
        $code = array();
        foreach ($url_arr as $i => $row) {
            $code[$row] = curl_getinfo($ch_array[$i],CURLINFO_HTTP_CODE);
            $res[$row] = curl_multi_getcontent($ch_array[$i]);
            curl_multi_remove_handle($mh, $ch_array[$i]);
        }
        curl_multi_close($mh);
        
        return [$code, $res];
    }

    private function setErrorLog($log)
    {
        $this->log = $log;
        $time = date("Y-m-d H:i:s");
        $txt = sprintf("[%s] %s :: %s\n", $time, $this->url, $log);
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
        $this->file_name = $file_name;

        return $this;
    }

    private function saveBatch()
    {
        $i = 1;
        foreach ($this->http_contents as $content) {
            $path = sprintf('%s%s%03d.html', $this->dir, $this->file_name, $i);
            file_put_contents($path, $content);
            $i++;
        }
    }

    private function saveSingle()
    {
        if ($this->isError) return;
        $path = sprintf('%s%s.html', $this->dir, $this->file_name);
        file_put_contents($path, $this->http_contents);
    }

    public function save()
    {
        if (is_array($this->data)) {
            $this->saveBatch();
        } else {
            $this->saveSingle();
        }
    }
}